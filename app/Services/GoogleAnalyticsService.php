<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Lit les métriques réelles de trafic depuis l'API GA4 (Google Analytics Data API),
 * pour remplacer les estimations statiques de la page Statistiques admin.
 *
 * Nécessite un ID de propriété GA4 + des identifiants de compte de service, fournis
 * soit depuis l'admin (onglet Paramètres, JSON collé/uploadé, prioritaire), soit via
 * .env (GA4_PROPERTY_ID + GA4_CREDENTIALS_PATH, chemin vers un fichier sur le
 * serveur). Tant que rien n'est renseigné, isConfigured() renvoie false et l'appelant
 * doit garder son repli sur les estimations existantes — cette classe ne doit jamais
 * faire planter la page Statistiques si GA4 n'est pas branché.
 */
class GoogleAnalyticsService
{
    public function isConfigured(): bool
    {
        return filled(config('services.ga4.property_id')) && $this->credentialsOption() !== null;
    }

    /**
     * Résout les identifiants à passer au client GA4 : JSON collé dans l'admin
     * (prioritaire, décodé en tableau) ou chemin de fichier défini en .env.
     *
     * @return array<string,mixed>|string|null
     */
    private function credentialsOption(): array|string|null
    {
        $json = config('services.ga4.credentials_json');
        if (filled($json)) {
            $decoded = json_decode($json, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            Log::warning('GA4 credentials JSON (admin) is invalid, ignoring it.');
        }

        $path = config('services.ga4.credentials_path');
        if (filled($path) && file_exists($path)) {
            return $path;
        }

        return null;
    }

    /**
     * Métriques globales sur les $days derniers jours : visiteurs, rebond, durée de
     * session, pages par session. Retourne null si GA4 n'est pas configuré ou si la
     * requête échoue (identifiants invalides, propriété inaccessible, quota...).
     */
    public function summary(int $days = 30): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        return Cache::remember("ga4.summary.{$days}", 900, function () use ($days) {
            try {
                $client = new BetaAnalyticsDataClient([
                    'credentials' => $this->credentialsOption(),
                ]);

                $response = $client->runReport([
                    'property' => 'properties/' . config('services.ga4.property_id'),
                    'dateRanges' => [new DateRange([
                        'start_date' => "{$days}daysAgo",
                        'end_date' => 'today',
                    ])],
                    'metrics' => [
                        new Metric(['name' => 'activeUsers']),
                        new Metric(['name' => 'bounceRate']),
                        new Metric(['name' => 'averageSessionDuration']),
                        new Metric(['name' => 'screenPageViewsPerSession']),
                    ],
                ]);

                $client->close();

                $row = $response->getRows()[0] ?? null;
                if (! $row) {
                    return null;
                }

                $values = $row->getMetricValues();
                $bounceRate = (float) $values[1]->getValue();
                $avgDurationSeconds = (float) $values[2]->getValue();

                return [
                    'unique_visitors' => (int) $values[0]->getValue(),
                    'bounce_rate' => round($bounceRate * 100, 1) . '%',
                    'avg_session_duration' => $this->formatDuration($avgDurationSeconds),
                    'pages_per_session' => round((float) $values[3]->getValue(), 1),
                ];
            } catch (Throwable $e) {
                Log::warning('GA4 Data API summary request failed: ' . $e->getMessage());

                return null;
            }
        });
    }

    /**
     * Vues de pages regroupées par préfixe d'URL (ex: /services, /projets, /produits)
     * sur les $days derniers jours. Retourne null si non configuré ou en erreur.
     *
     * @param  array<string,string>  $prefixes  clé => préfixe de chemin (ex: ['services_views' => '/services'])
     * @return array<string,int>|null
     */
    public function pageViewsByPrefix(array $prefixes, int $days = 30): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $cacheKey = 'ga4.page_views_by_prefix.' . $days . '.' . md5(serialize($prefixes));

        return Cache::remember($cacheKey, 900, function () use ($prefixes, $days) {
            try {
                $client = new BetaAnalyticsDataClient([
                    'credentials' => $this->credentialsOption(),
                ]);

                $response = $client->runReport([
                    'property' => 'properties/' . config('services.ga4.property_id'),
                    'dateRanges' => [new DateRange([
                        'start_date' => "{$days}daysAgo",
                        'end_date' => 'today',
                    ])],
                    'dimensions' => [new Dimension(['name' => 'pagePathPlusQueryString'])],
                    'metrics' => [new Metric(['name' => 'screenPageViews'])],
                    'limit' => 1000,
                ]);

                $client->close();

                $totals = array_fill_keys(array_keys($prefixes), 0);

                foreach ($response->getRows() as $row) {
                    $path = $row->getDimensionValues()[0]->getValue();
                    $views = (int) $row->getMetricValues()[0]->getValue();

                    foreach ($prefixes as $key => $prefix) {
                        if (str_starts_with($path, $prefix)) {
                            $totals[$key] += $views;
                        }
                    }
                }

                return $totals;
            } catch (Throwable $e) {
                Log::warning('GA4 Data API page views request failed: ' . $e->getMessage());

                return null;
            }
        });
    }

    private function formatDuration(float $seconds): string
    {
        $minutes = (int) floor($seconds / 60);
        $remainingSeconds = (int) round($seconds - ($minutes * 60));

        return "{$minutes}m {$remainingSeconds}s";
    }
}
