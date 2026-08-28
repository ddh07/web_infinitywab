@extends('layouts.error')

@section('title', 'Maintenance en cours - Infinity WAB')
@section('description', 'Le site est en maintenance. Merci de revenir un peu plus tard.')

@section('content')
<section class="relative overflow-hidden bg-surface-canvas text-ink-primary py-28 lg:py-36">
    <div class="absolute inset-0 opacity-[0.12] pointer-events-none" style="background-image: radial-gradient(circle, #6bbfa0 1px, transparent 1px); background-size: 28px 28px;" aria-hidden="true"></div>
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.16),_transparent_45%)]"></div>

    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-mint-500 to-azure-500 flex items-center justify-center shadow-2xl shadow-(--glow-accent)">
            <svg class="w-8 h-8 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
            </svg>
        </div>
        <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Maintenance en cours</p>
        <h1 class="font-display text-4xl md:text-5xl font-semibold">Nous revenons très vite.</h1>
        <p class="text-lg text-ink-secondary">
            {{ $message }}
        </p>
    </div>
</section>
@endsection
