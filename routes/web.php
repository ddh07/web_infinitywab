<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Api\ServiceController as AdminServiceApiController;
use App\Http\Controllers\Admin\Api\ProjectController as AdminProjectApiController;
use App\Http\Controllers\Admin\Api\ProductController as AdminProductApiController;
use App\Http\Controllers\Admin\Api\MessageController as AdminMessageApiController;
use App\Http\Controllers\Admin\Api\CompanyController as AdminCompanyApiController;
use App\Http\Controllers\Admin\Api\PartnerController as AdminPartnerApiController;
use App\Http\Controllers\Admin\Api\FaqController as AdminFaqApiController;
use App\Http\Controllers\Admin\Api\TestimonialController as AdminTestimonialApiController;
use App\Http\Controllers\Admin\Api\TeamMemberController as AdminTeamMemberApiController;
use App\Http\Controllers\Admin\Api\LegalDocumentController as AdminLegalDocumentApiController;
use App\Http\Controllers\Admin\Api\SettingsController as AdminSettingsApiController;
use App\Http\Controllers\Admin\Api\MediaController as AdminMediaApiController;

// Pages publiques
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

// Compat: certaines configs Laravel UI redirigent vers /home
Route::get('/home', function () {
    return redirect()->route('home');
})->middleware('auth');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/projets', [ProjectController::class, 'index'])->name('projects');
Route::get('/projets/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/produits', [ProductController::class, 'index'])->name('products');
Route::get('/produits/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/actualites', [NewsController::class, 'index'])->name('news');
Route::get('/actualites/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/a-propos', [AboutController::class, 'index'])->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
Route::get('/contact/merci', [ContactController::class, 'thanks'])->name('contact.thanks');

Route::get('/confidentialite', [LegalController::class, 'privacy'])->name('privacy');
Route::get('/conditions-utilisation', [LegalController::class, 'terms'])->name('terms');
Route::get('/accessibilite', [LegalController::class, 'accessibility'])->name('accessibility');

// Routes pour l'entreprise et les partenaires
Route::get('/entreprise', [CompanyController::class, 'index'])->name('company');

// Routes API pour l'entreprise et les partenaires
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/company', [CompanyController::class, 'api'])->name('company');
    Route::get('/partners', [CompanyController::class, 'partnersApi'])->name('partners');
    Route::get('/partners/{category}', [CompanyController::class, 'partnersByCategory'])->name('partners.category');
});

// Routes d'administration
Route::prefix('admin')->name('admin.')->middleware(['admin', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/services', function () {
        return view('admin.services');
    })->name('services');

    Route::get('/projets', function () {
        return view('admin.projects');
    })->name('projects');

    Route::get('/produits', function () {
        return view('admin.products');
    })->name('products');

    Route::get('/contenu', function () {
        return view('admin.content');
    })->name('content');

    Route::get('/messages', function () {
        return view('admin.messages');
    })->name('messages');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');

    Route::get('/statistiques', function () {
        return view('admin.analytics');
    })->name('analytics');

    Route::get('/faq', function () {
        return view('admin.faqs');
    })->name('faqs');

    Route::get('/avis', function () {
        return view('admin.testimonials');
    })->name('testimonials');

    Route::get('/equipe', function () {
        return view('admin.team');
    })->name('team');

    Route::get('/parametres', function () {
        return view('admin.settings');
    })->name('settings');

    Route::get('/fichiers', function () {
        return view('admin.media');
    })->name('media');
});

// API Routes pour l'administration
Route::prefix('api/admin')->name('api.admin.')->middleware(['admin', 'verified'])->group(function () {
    // Services
    Route::get('/services', [AdminServiceApiController::class, 'index']);
    Route::post('/services', [AdminServiceApiController::class, 'store']);
    Route::get('/services/{id}', [AdminServiceApiController::class, 'show']);
    Route::put('/services/{id}', [AdminServiceApiController::class, 'update']);
    Route::delete('/services/{id}', [AdminServiceApiController::class, 'destroy']);

    // Projects
    Route::get('/projects', [AdminProjectApiController::class, 'index']);
    Route::post('/projects', [AdminProjectApiController::class, 'store']);
    Route::get('/projects/{id}', [AdminProjectApiController::class, 'show']);
    Route::put('/projects/{id}', [AdminProjectApiController::class, 'update']);
    Route::delete('/projects/{id}', [AdminProjectApiController::class, 'destroy']);

    // Products
    Route::get('/products', [AdminProductApiController::class, 'index']);
    Route::post('/products', [AdminProductApiController::class, 'store']);
    Route::get('/products/{id}', [AdminProductApiController::class, 'show']);
    Route::put('/products/{id}', [AdminProductApiController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductApiController::class, 'destroy']);

    // Messages
    Route::get('/messages', [AdminMessageApiController::class, 'index']);
    Route::post('/messages/{id}/read', [AdminMessageApiController::class, 'markAsRead']);
    Route::post('/messages/{id}/unread', [AdminMessageApiController::class, 'markAsUnread']);
    Route::delete('/messages/{id}', [AdminMessageApiController::class, 'destroy']);

    // Company
    Route::get('/company', [AdminCompanyApiController::class, 'show']);
    Route::put('/company', [AdminCompanyApiController::class, 'update']);

    // Partners
    Route::get('/partners', [AdminPartnerApiController::class, 'index']);
    Route::post('/partners', [AdminPartnerApiController::class, 'store']);
    Route::get('/partners/{id}', [AdminPartnerApiController::class, 'show']);
    Route::put('/partners/{id}', [AdminPartnerApiController::class, 'update']);
    Route::delete('/partners/{id}', [AdminPartnerApiController::class, 'destroy']);

    // FAQ
    Route::get('/faqs', [AdminFaqApiController::class, 'index']);
    Route::post('/faqs', [AdminFaqApiController::class, 'store']);
    Route::get('/faqs/{id}', [AdminFaqApiController::class, 'show']);
    Route::put('/faqs/{id}', [AdminFaqApiController::class, 'update']);
    Route::delete('/faqs/{id}', [AdminFaqApiController::class, 'destroy']);

    // Testimonials (avis clients)
    Route::get('/testimonials', [AdminTestimonialApiController::class, 'index']);
    Route::post('/testimonials', [AdminTestimonialApiController::class, 'store']);
    Route::get('/testimonials/{id}', [AdminTestimonialApiController::class, 'show']);
    Route::put('/testimonials/{id}', [AdminTestimonialApiController::class, 'update']);
    Route::delete('/testimonials/{id}', [AdminTestimonialApiController::class, 'destroy']);

    // Team members (équipe)
    Route::get('/team', [AdminTeamMemberApiController::class, 'index']);
    Route::post('/team', [AdminTeamMemberApiController::class, 'store']);
    Route::get('/team/{id}', [AdminTeamMemberApiController::class, 'show']);
    Route::put('/team/{id}', [AdminTeamMemberApiController::class, 'update']);
    Route::delete('/team/{id}', [AdminTeamMemberApiController::class, 'destroy']);

    // Paramètres système (intégrations + email), stockés en base plutôt qu'en .env
    Route::get('/settings', [AdminSettingsApiController::class, 'show']);
    Route::put('/settings', [AdminSettingsApiController::class, 'update']);
    Route::post('/settings/logo', [AdminSettingsApiController::class, 'uploadLogo']);
    Route::delete('/settings/logo', [AdminSettingsApiController::class, 'removeLogo']);
    Route::post('/settings/favicon', [AdminSettingsApiController::class, 'uploadFavicon']);
    Route::delete('/settings/favicon', [AdminSettingsApiController::class, 'removeFavicon']);
    Route::post('/settings/og-image', [AdminSettingsApiController::class, 'uploadOgImage']);
    Route::delete('/settings/og-image', [AdminSettingsApiController::class, 'removeOgImage']);
    Route::post('/settings/hero-image/{page}', [AdminSettingsApiController::class, 'uploadHeroImage']);
    Route::delete('/settings/hero-image/{page}', [AdminSettingsApiController::class, 'removeHeroImage']);

    // Documents légaux (politique de confidentialité, conditions d'utilisation)
    Route::get('/legal-documents', [AdminLegalDocumentApiController::class, 'index']);
    Route::post('/legal-documents/{slug}', [AdminLegalDocumentApiController::class, 'upload']);
    Route::delete('/legal-documents/{slug}', [AdminLegalDocumentApiController::class, 'destroy']);

    // Bibliothèque de médias (images/fichiers réutilisables dans les formulaires admin)
    Route::get('/media', [AdminMediaApiController::class, 'index']);
    Route::post('/media', [AdminMediaApiController::class, 'store']);
    Route::delete('/media/{id}', [AdminMediaApiController::class, 'destroy']);

    // Dashboard Statistics
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats']);
    Route::get('/analytics/data', [AdminAnalyticsController::class, 'data']);

    // Content Management (if needed)
    Route::get('/content', [AdminContentController::class, 'index']);
    Route::post('/content', [AdminContentController::class, 'store']);
    Route::get('/content/{id}', [AdminContentController::class, 'show']);
    Route::put('/content/{id}', [AdminContentController::class, 'update']);
    Route::delete('/content/{id}', [AdminContentController::class, 'destroy']);

    // User Management (Admin users)
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/users/{id}', [AdminUserController::class, 'show']);
    Route::put('/users/{id}', [AdminUserController::class, 'update']);
    Route::post('/users/{id}/resend-verification', [AdminUserController::class, 'resendVerificationEmail']);
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);
});

// Routes d'authentification + vérification d'email
Auth::routes(['verify' => true]);
