@extends('layouts.admin')

@section('title', 'Fichiers - Admin Infinity WAB')
@section('page-title', 'Fichiers')

@section('content')
<div class="space-y-4">
    <div>
        <h1 class="text-lg font-semibold text-ink-primary">Bibliothèque de fichiers</h1>
        <p class="text-xs text-ink-muted">Images et documents importés, réutilisables dans les formulaires de l'administration.</p>
    </div>

    <div id="mediaLibraryPage" class="flex flex-col h-[calc(100vh-14rem)] min-h-[500px] rounded-lg border border-(--border-default) bg-surface-raised overflow-hidden">
        @include('admin.partials.media-library-body')
    </div>
</div>

@push('scripts')
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    window.initMediaLibraryPage(document.getElementById('mediaLibraryPage'));
});
</script>
@endpush
@endsection
