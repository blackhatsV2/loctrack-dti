@extends('layouts.app')

@section('styles')
<style>
    .history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    .history-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        font-weight: 400;
        border-bottom: 1px solid var(--glass-border);
    }
    .history-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        vertical-align: middle;
    }
    .history-table tr:hover td {
        background: rgba(99, 102, 241, 0.06);
    }
    .pagination-links {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        gap: 0.25rem;
    }
    .pagination-links a, .pagination-links span {
        padding: 0.4rem 0.75rem;
        border-radius: 0.4rem;
        text-decoration: none;
        font-size: 0.85rem;
        color: var(--text-muted);
        border: 1px solid var(--glass-border);
    }
    .pagination-links a:hover { background: rgba(99,102,241,0.15); color: white; }
    .pagination-links .active { background: var(--primary); color: white; border-color: var(--primary); }
    .coord-mono { font-family: monospace; font-size: 0.85rem; color: var(--text-muted); }
    @media (max-width: 768px) {
        .history-table {
            min-width: 650px;
        }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.employees') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">&larr; Back to Employees</a>
    </div>

    <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem;">Location History</h1>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;">
        <div>
            <p style="color: var(--text-muted); margin-bottom: 0.25rem;">Tracking history for <strong>{{ $user->name }}</strong> — {{ $locations->total() }} records</p>
        </div>
        @if($locations->total() > 0)
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <button type="button" id="delete-selected-btn" class="btn animate-fade-in" style="padding: 0.5rem 1rem; font-size: 0.85rem; background: rgba(244, 63, 94, 0.15); color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.3); display: none; align-items: center; gap: 0.35rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg> Delete Selected (<span id="selected-count">0</span>)
            </button>
            <button type="button" id="clear-all-btn" class="btn" style="padding: 0.5rem 1rem; font-size: 0.85rem; background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border: 1px solid var(--glass-border); display: inline-flex; align-items: center; gap: 0.35rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Clear History
            </button>
        </div>
        @endif
    </div>

    <div class="glass-card" style="padding: 0; overflow-x: auto; position: relative;">
        <table class="history-table">
            <thead>
                <tr>
                    @if($locations->total() > 0)
                    <th style="width: 40px; text-align: center; padding: 0.75rem 1rem;">
                        <input type="checkbox" id="select-all-checkbox" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--primary);">
                    </th>
                    @endif
                    <th>#</th>
                    <th>Date & Time</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Address</th>
                    <th>Office</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $index => $loc)
                    <tr>
                        @if($locations->total() > 0)
                        <td style="text-align: center; padding: 0.75rem 1rem;">
                            <input type="checkbox" class="row-checkbox" value="{{ $loc->id }}" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--primary);">
                        </td>
                        @endif
                        <td style="color: var(--text-muted);">{{ $locations->firstItem() + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($loc->recorded_at)->format('M d, Y — h:i A') }}</td>
                        <td class="coord-mono">{{ $loc->latitude }}</td>
                        <td class="coord-mono">{{ $loc->longitude }}</td>
                        <td>{{ $loc->address ?? '—' }}</td>
                        <td>{{ $loc->office ?? '—' }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <button type="button" class="btn btn-small reuse-btn" data-url="{{ route('location.reuse', $loc->id) }}" style="padding: 0.25rem 0.6rem; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg> Reuse
                                </button>
                                <button type="button" class="btn btn-small delete-btn" data-url="{{ route('admin.history.destroy', $loc->id) }}" style="padding: 0.25rem 0.6rem; font-size: 0.75rem; background: rgba(244, 63, 94, 0.15); color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.3); display: inline-flex; align-items: center; gap: 0.25rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 2rem;">No location history found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($locations->hasPages())
    <div class="pagination-links">
        @if($locations->onFirstPage())
            <span>&laquo;</span>
        @else
            <a href="{{ $locations->previousPageUrl() }}">&laquo;</a>
        @endif

        @foreach($locations->getUrlRange(1, $locations->lastPage()) as $page => $url)
            @if($page == $locations->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if($locations->hasMorePages())
            <a href="{{ $locations->nextPageUrl() }}">&raquo;</a>
        @else
            <span>&raquo;</span>
        @endif
    </div>
    @endif
</div>

<!-- Confirm Modal -->
<div id="confirm-modal" class="modal-overlay" onclick="if(event.target === this) hideConfirmModal()">
    <div class="modal-content">
        <h2 id="confirm-modal-title" style="margin-bottom: 1rem; font-size: 1.5rem; font-weight: 600;">Confirm Deletion</h2>
        <p id="confirm-modal-message" style="color: var(--text-muted); margin-bottom: 2rem; line-height: 1.5; font-size: 0.95rem;"></p>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <button type="button" class="btn" id="confirm-modal-cancel" style="flex: 1; background: rgba(255,255,255,0.05); color: var(--text-muted);" onclick="hideConfirmModal()">Cancel</button>
            <button type="button" class="btn" id="confirm-modal-submit" style="flex: 1; background: #f43f5e; color: white;">Yes, Delete</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global Confirmation Modal Logic
    let confirmAction = null;

    function showConfirmModal(title, message, callback) {
        document.getElementById('confirm-modal-title').textContent = title;
        document.getElementById('confirm-modal-message').textContent = message;
        confirmAction = callback;
        document.getElementById('confirm-modal').classList.add('active');
    }

    function hideConfirmModal() {
        document.getElementById('confirm-modal').classList.remove('active');
        confirmAction = null;
    }

    document.getElementById('confirm-modal-submit').addEventListener('click', function() {
        if (confirmAction) {
            confirmAction();
        }
        hideConfirmModal();
    });

    // Checkbox Selection Logic
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const deleteSelectedBtn = document.getElementById('delete-selected-btn');
    const selectedCountSpan = document.getElementById('selected-count');

    function updateDeleteSelectedVisibility() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const checkedCount = checkedBoxes.length;

        if (checkedCount > 0) {
            deleteSelectedBtn.style.display = 'inline-block';
            selectedCountSpan.textContent = checkedCount;
        } else {
            deleteSelectedBtn.style.display = 'none';
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            updateDeleteSelectedVisibility();
        });
    }

    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (!this.checked && selectAllCheckbox) {
                selectAllCheckbox.checked = false;
            } else if (selectAllCheckbox && document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length) {
                selectAllCheckbox.checked = true;
            }
            updateDeleteSelectedVisibility();
        });
    });

    // Individual Delete Logic
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            showConfirmModal(
                'Delete Location Log',
                'Are you sure you want to permanently delete this location log from history? This action cannot be undone.',
                function() {
                    if (typeof showGlobalLoader === 'function') showGlobalLoader();
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to delete location.');
                            if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                        }
                    })
                    .catch(err => {
                        alert('Error: ' + err.message);
                        if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                    });
                }
            );
        });
    });

    // Delete Selected Logic
    if (deleteSelectedBtn) {
        deleteSelectedBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = "{{ route('admin.employees.history.bulk', $user->id) }}";

            showConfirmModal(
                'Delete Selected Logs',
                `Are you sure you want to permanently delete the ${selectedIds.length} selected location log(s)? This action cannot be undone.`,
                function() {
                    if (typeof showGlobalLoader === 'function') showGlobalLoader();
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'selected',
                            ids: selectedIds
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to delete selected locations.');
                            if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                        }
                    })
                    .catch(err => {
                        alert('Error: ' + err.message);
                        if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                    });
                }
            );
        });
    }

    // Clear All History Logic
    const clearAllBtn = document.getElementById('clear-all-btn');
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = "{{ route('admin.employees.history.bulk', $user->id) }}";

            showConfirmModal(
                'Clear All History',
                "Are you sure you want to permanently clear ALL location history for {{ $user->name }}? This action is irreversible.",
                function() {
                    if (typeof showGlobalLoader === 'function') showGlobalLoader();
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'all'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to clear history.');
                            if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                        }
                    })
                    .catch(err => {
                        alert('Error: ' + err.message);
                        if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                    });
                }
            );
        });
    }

    // Existing Reuse Button Handler
    document.querySelectorAll('.reuse-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.getAttribute('data-url');
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            btn.disabled = true;
            btn.textContent = 'Reusing...';
            if (typeof showGlobalLoader === 'function') showGlobalLoader();

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to reuse location.');
                    btn.disabled = false;
                    btn.textContent = 'Reuse';
                    if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
                }
            })
            .catch(function(err) {
                alert('Error: ' + err.message);
                btn.disabled = false;
                btn.textContent = 'Reuse';
                if (typeof hideGlobalLoader === 'function') hideGlobalLoader();
            });
        });
    });
</script>
@endsection

