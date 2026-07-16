@extends('layouts.admin')

@section('title', 'Messages - Admin Infinity WAB')
@section('page-title', 'Messages')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-semibold text-slate-800">Messages</h1>
            <p class="text-xs text-slate-500"><span id="messages-total">Total: {{ \App\Models\Message::count() }} messages</span> — <span id="messages-unread" class="text-indigo-600 font-medium">Non lus: {{ \App\Models\Message::where('status', 'non_lu')->count() }}</span></p>
        </div>
    </div>
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-4">
        <div class="flex flex-wrap items-center gap-3">
            <button onclick="filterMessages('all')" class="filter-btn px-4 py-2 rounded-lg bg-indigo-100 text-indigo-800 font-medium" data-filter="all">
                Tous
            </button>
            <button onclick="filterMessages('unread')" class="filter-btn px-4 py-2 rounded-lg bg-slate-100 text-slate-700 font-medium" data-filter="unread">
                Non lus
            </button>
            <button onclick="filterMessages('read')" class="filter-btn px-4 py-2 rounded-lg bg-slate-100 text-slate-700 font-medium" data-filter="read">
                Lu
            </button>
            <div class="ml-auto">
                <input type="text" id="searchMessages" placeholder="Rechercher…" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:border-indigo-500">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-200">
            @php
                $messages = \App\Models\Message::latest()->get();
            @endphp
            @foreach($messages as $message)
            <div class="message-row p-6 hover:bg-gray-50 cursor-pointer {{ $message->status === 'non_lu' ? 'bg-blue-50' : 'bg-white' }}"
                 data-read="{{ $message->status === 'non_lu' ? 0 : 1 }}"
                 data-id="{{ $message->id }}"
                 data-action="toggle">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="flex items-center mr-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-medium text-sm">
                                        {{ strtoupper(substr($message->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <h3 class="text-sm font-medium text-gray-900 {{ $message->status === 'non_lu' ? 'font-bold' : '' }}">
                                            {{ $message->name }}
                                        </h3>
                                        @if($message->status === 'non_lu')
                                            <span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $message->email }}</div>
                                    @if($message->phone)
                                        <div class="text-sm text-gray-500">{{ $message->phone }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">
                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $message->subject }}</h4>
                        </div>

                        <div class="message-content" id="content-{{ $message->id }}">
                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ $message->message }}
                            </p>
                        </div>

                        <div class="message-details hidden mt-4 pt-4 border-t border-gray-200" id="details-{{ $message->id }}">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>

                                <div class="mt-4 text-xs text-gray-500">
                                    <div>IP: {{ $message->ip_address }}</div>
                                    <div>Navigateur: {{ $message->user_agent }}</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center space-x-3">
                                    <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Répondre par email
                                    </a>
                                    @if($message->phone)
                                    <a href="tel:{{ $message->phone }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                        Appeler
                                    </a>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($message->status === 'non_lu')
                                        <button data-action="read" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            Marquer comme lu
                                        </button>
                                    @else
                                        <button data-action="unread" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                            Marquer comme non lu
                                        </button>
                                    @endif
                                    <button data-action="delete" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($messages->isEmpty())
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun message</h3>
        <p class="text-gray-500">Vous n'avez reçu aucun message pour le moment.</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('click', function(e) {
    const actionEl = e.target.closest('[data-action]');
    if (!actionEl) return;

    const row = actionEl.closest('.message-row');
    if (!row) return;

    const messageId = row.dataset.id;
    if (!messageId) return;

    const action = actionEl.dataset.action;

    if (action === 'toggle') {
        toggleMessage(messageId);
        return;
    }

    if (action === 'read') {
        markAsRead(messageId, e);
        return;
    }

    if (action === 'unread') {
        markAsUnread(messageId, e);
        return;
    }

    if (action === 'delete') {
        deleteMessage(messageId, e);
    }
});

function toggleMessage(messageId) {
    const details = document.getElementById(`details-${messageId}`);
    const content = document.getElementById(`content-${messageId}`);

    if (details.classList.contains('hidden')) {
        // Show details
        details.classList.remove('hidden');
        content.classList.add('hidden');

        // Mark as read if unread
        const row = document.querySelector(`[data-id="${messageId}"]`);
        if (row.dataset.read === '0') {
            markAsRead(messageId, new Event('click'));
        }
    } else {
        // Hide details
        details.classList.add('hidden');
        content.classList.remove('hidden');
    }
}

function markAsRead(messageId, event) {
    event.stopPropagation();

    fetch(`/api/admin/messages/${messageId}/read`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`[data-id="${messageId}"]`);
                row.dataset.read = '1';
                row.classList.remove('bg-blue-50');
                row.classList.add('bg-white');

                // Update UI
                const unreadIndicator = row.querySelector('.bg-blue-500.rounded-full');
                if (unreadIndicator) {
                    unreadIndicator.remove();
                }

                // Update buttons
                location.reload();
            }
        });
}

function markAsUnread(messageId, event) {
    event.stopPropagation();

    fetch(`/api/admin/messages/${messageId}/unread`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
}

function deleteMessage(messageId, event) {
    event.stopPropagation();

    if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
        fetch(`/api/admin/messages/${messageId}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`[data-id="${messageId}"]`);
                    row.remove();

                    // Update counters
                    updateCounters();
                }
            });
    }
}

function filterMessages(filter) {
    const rows = document.querySelectorAll('.message-row');

    // Update button styles
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.filter === filter) {
            btn.classList.add('bg-blue-100', 'text-blue-800');
            btn.classList.remove('bg-gray-100', 'text-gray-700');
        } else {
            btn.classList.remove('bg-blue-100', 'text-blue-800');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        }
    });

    // Filter rows
    rows.forEach(row => {
        if (filter === 'all') {
            row.style.display = '';
        } else if (filter === 'unread') {
            row.style.display = row.dataset.read === '0' ? '' : 'none';
        } else if (filter === 'read') {
            row.style.display = row.dataset.read === '1' ? '' : 'none';
        }
    });
}

// Search functionality
document.getElementById('searchMessages').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.message-row');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

function updateCounters() {
    // Update total count
    const totalMessages = document.querySelectorAll('.message-row').length;
    const totalElement = document.getElementById('messages-total');
    if (totalElement) totalElement.textContent = `Total: ${totalMessages} messages`;

    // Update unread count
    const unreadMessages = document.querySelectorAll('.message-row[data-read="0"]').length;
    const unreadElement = document.getElementById('messages-unread');
    if (unreadElement) unreadElement.textContent = `Non lus: ${unreadMessages}`;
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        // Close all expanded messages
        document.querySelectorAll('.message-details').forEach(details => {
            details.classList.add('hidden');
        });
        document.querySelectorAll('.message-content').forEach(content => {
            content.classList.remove('hidden');
        });
    }
});
</script>
@endpush
@endsection
