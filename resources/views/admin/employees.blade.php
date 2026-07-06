@extends('layouts.app')

@section('styles')
<style>
    .search-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .search-bar input, .search-bar select {
        padding: 0.65rem 1rem;
        border-radius: 0.5rem;
        background: #0f172a;
        border: 1px solid #334155;
        color: white;
        font-size: 0.9rem;
        font-family: 'Outfit', sans-serif;
    }
    .search-bar input { flex: 1; min-width: 200px; }
    .search-bar select { min-width: 180px; }
    .search-bar button {
        padding: 0.65rem 1.5rem;
        font-size: 0.9rem;
    }

    .emp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    .emp-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        font-weight: 400;
        border-bottom: 1px solid var(--glass-border);
        white-space: nowrap;
    }
    .emp-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        vertical-align: middle;
    }
    .emp-table tr:hover td {
        background: rgba(99, 102, 241, 0.06);
    }
    .action-link {
        color: #818cf8;
        text-decoration: none;
        font-weight: 500;
        margin-right: 1rem;
        font-size: 0.85rem;
    }
    .action-link:hover {
        color: #a5b4fc;
        text-decoration: underline;
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
    .emp-count { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem; }
    @media (max-width: 768px) {
        .search-bar {
            flex-direction: column;
        }
        .search-bar input {
            min-width: 100%;
        }
        .search-bar select {
            min-width: 100%;
        }
        .emp-table {
            min-width: 600px;
        }
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        background: #0f172a;
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .modal.active { display: flex; }
    .modal-content {
        width: 100%;
        max-width: 550px;
        max-height: 85vh;
        overflow-y: auto;
        position: relative;
        margin: auto;
    }
    .input-group {
        margin-bottom: 1.25rem;
    }
    .input-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        background: #0f172a;
        border: 1px solid #334155;
        color: white;
        font-family: 'Outfit', sans-serif;
    }
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    .btn-danger:hover {
        background: #dc2626;
    }

    /* Override global button styles for clear filter button */
    #clear-search-btn {
        background: rgba(255, 255, 255, 0.05) !important;
        color: var(--text-muted) !important;
        border: 1px solid var(--glass-border) !important;
        box-shadow: none !important;
        transform: none !important;
    }
    #clear-search-btn:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: none !important;
    }

    /* Override global button styles for action links (like Delete button) */
    button.action-link {
        background: none !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 1rem 0 0 !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        display: inline !important;
        font-family: inherit !important;
        color: #ef4444 !important;
        box-shadow: none !important;
        transform: none !important;
        transition: color 0.2s ease !important;
    }
    button.action-link:hover {
        color: #f87171 !important;
        text-decoration: underline !important;
        background: none !important;
        box-shadow: none !important;
        transform: none !important;
    }

    /* Reset button styles for modal close buttons */
    .close-btn {
        background: transparent !important;
        border: none !important;
        padding: 0.5rem !important;
        font-size: 1.5rem !important;
        cursor: pointer !important;
        color: var(--text-muted) !important;
        box-shadow: none !important;
        transform: none !important;
        transition: color 0.2s ease !important;
        line-height: 1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .close-btn:hover {
        color: white !important;
        background: transparent !important;
        box-shadow: none !important;
        transform: none !important;
    }
    /* Searchable Select */
    .searchable-select {
        position: relative;
    }
    .searchable-select .ss-input {
        width: 100%;
        padding: 0.75rem 2.25rem 0.75rem 1rem;
        border-radius: 0.75rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--glass-border);
        color: white;
        font-size: 0.9rem;
        font-family: 'Outfit', sans-serif;
        cursor: text;
    }
    .searchable-select .ss-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
    }
    .searchable-select .ss-input.has-value {
        color: #fff;
    }
    .searchable-select .ss-input:not(.has-value)::placeholder {
        color: rgba(255,255,255,0.35);
    }
    .searchable-select .ss-arrow {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: rgba(255,255,255,0.4);
        font-size: 0.65rem;
        transition: transform 0.2s;
    }
    .searchable-select.open .ss-arrow {
        transform: translateY(-50%) rotate(180deg);
    }
    .searchable-select .ss-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        max-height: 200px;
        overflow-y: auto;
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 0.75rem;
        z-index: 10000;
        box-shadow: 0 8px 24px rgba(0,0,0,0.4);
    }
    .searchable-select.open .ss-dropdown {
        display: block;
    }
    .searchable-select .ss-option {
        padding: 0.55rem 1rem;
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.15s;
    }
    .searchable-select .ss-option:hover,
    .searchable-select .ss-option.highlighted {
        background: rgba(99,102,241,0.2);
        color: #fff;
    }
    .searchable-select .ss-option.selected {
        color: var(--primary);
        font-weight: 500;
    }
    .searchable-select .ss-empty {
        padding: 0.75rem 1rem;
        color: rgba(255,255,255,0.35);
        font-size: 0.85rem;
        text-align: center;
    }
    .searchable-select .ss-dropdown::-webkit-scrollbar {
        width: 4px;
    }
    .searchable-select .ss-dropdown::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.15);
        border-radius: 2px;
    }
    .searchable-select .ss-option.others-option {
        border-top: 1px solid rgba(255,255,255,0.08);
        color: #a5b4fc;
        font-style: italic;
    }
    .ss-custom-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--glass-border);
        color: white;
        font-size: 0.9rem;
        font-family: 'Outfit', sans-serif;
        margin-top: 0.5rem;
    }
    .ss-custom-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
    }
    .ss-custom-input::placeholder {
        color: rgba(255,255,255,0.35);
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Employees</h1>
            <p style="color: var(--text-muted); margin-bottom: 0;">Manage and track all employees.</p>
        </div>
        <button onclick="openAddModal()" class="btn" style="background: var(--primary); display: flex; align-items: center; gap: 0.5rem;">
            Add Employee
        </button>
    </div>

    <div class="search-bar">
        <input type="text" id="employee-search-input" placeholder="Search by name, email, ID, or mobile..." autocomplete="off" onkeyup="filterEmployees()" oninput="filterEmployees()">
        <select id="employee-office-select" onchange="filterEmployees()">
            <option value="">All Offices</option>
            @foreach($offices as $o)
                <option value="{{ $o }}">{{ $o }}</option>
            @endforeach
        </select>
        <button type="button" id="clear-search-btn" onclick="clearFilters()" style="display: none;">Clear</button>
    </div>

    <div class="emp-count" id="emp-count">Showing {{ $employees->count() }} of {{ $employees->count() }} employees</div>

    <div class="glass-card" style="padding: 0; overflow-x: auto; position: relative;">
        <div class="page-loading" id="employees-loading" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; background: rgba(15, 23, 42, 0.82);">
            <div class="spinner"></div>
        </div>
        <table class="emp-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID No.</th>
                    <th>Office</th>
                    <th>Mobile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employee-table-body">
                @foreach($employees as $emp)
                    @php $loc = $emp->locations->first(); @endphp
                    <tr class="emp-row"
                        data-name="{{ strtolower($emp->name) }}"
                        data-email="{{ strtolower($emp->email) }}"
                        data-id-no="{{ strtolower($loc->employee_id_no ?? $emp->employee_id_no ?? '') }}"
                        data-mobile="{{ strtolower($loc->mobile_no ?? $emp->mobile_no ?? '') }}"
                        data-office="{{ strtolower($loc->office ?? $emp->office ?? '') }}">
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="font-weight: 500;">{{ $emp->name }}</div>
                            </div>
                            <div style="color: var(--text-muted); font-size: 0.8rem;">{{ $emp->email }}</div>
                        </td>
                        <td>{{ $loc->employee_id_no ?? $emp->employee_id_no ?? '—' }}</td>
                        <td>{{ $loc->office ?? $emp->office ?? '—' }}</td>
                        <td>{{ $loc->mobile_no ?? $emp->mobile_no ?? '—' }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.employees.edit', $emp) }}" class="action-link">Edit</a>
                            <a href="{{ route('admin.employees.history', $emp) }}" class="action-link">History</a>
                            <button onclick="confirmDelete('{{ $emp->id }}', '{{ $emp->name }}')" class="action-link">Delete</button>
                        </td>
                    </tr>
                @endforeach
                <tr id="no-employees-row" style="display: {{ $employees->isEmpty() ? '' : 'none' }};">
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">No employees found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    <!-- Add Employee Modal -->
    <div id="add-employee-modal" class="modal">
        <div class="glass-card modal-content animate-fade-in" style="position: relative;">
            <!-- Loading Overlay -->
            <div id="add-employee-loading" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #0f172a; z-index: 10; align-items: center; justify-content: center; border-radius: inherit;">
                <div class="spinner"></div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="margin: 0;">Add New Employee</h2>
                <button onclick="closeAddModal()" class="close-btn">&times;</button>
            </div>

            <form id="add-employee-form" action="{{ route('admin.employees.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label class="input-label">Full Name</label>
                    <input type="text" name="name" class="form-input" placeholder="e.g. Juan Dela Cruz" required>
                </div>

                <div class="input-group">
                    <label class="input-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="e.g. juan@dti6.gov.ph" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="input-group">
                        <label class="input-label">ID No. (Optional)</label>
                        <input type="text" name="employee_id_no" class="form-input" placeholder="e.g. 12345">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Employee Type</label>
                        <div class="searchable-select" id="ss-employee-type">
                            <input type="text" class="ss-input" placeholder="Search employee type..." autocomplete="off">
                            <input type="hidden" name="employee_type" value="">
                            <span class="ss-arrow"></span>
                            <div class="ss-dropdown">
                                @foreach($employeeTypes as $type)
                                    <div class="ss-option" data-value="{{ $type }}">{{ $type }}</div>
                                @endforeach
                                @unless($employeeTypes->contains('Intern'))
                                    <div class="ss-option" data-value="Intern">Intern</div>
                                @endunless
                                <div class="ss-option others-option" data-value="__others__">Others (specify manually)</div>
                            </div>
                            <input type="text" class="ss-custom-input" style="display:none;" placeholder="Type custom employee type...">
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Address (Optional)</label>
                    <input type="text" name="address" class="form-input" placeholder="e.g. Iloilo City">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="input-group">
                        <label class="input-label">Mobile Number (Optional)</label>
                        <input type="text" name="mobile_no" class="form-input" placeholder="e.g. 09123456789">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Office</label>
                        <div class="searchable-select" id="ss-office">
                            <input type="text" class="ss-input" placeholder="Search office..." autocomplete="off">
                            <input type="hidden" name="office" value="">
                            <span class="ss-arrow"></span>
                            <div class="ss-dropdown">
                                @foreach($offices as $o)
                                    <div class="ss-option" data-value="{{ $o }}">{{ $o }}</div>
                                @endforeach
                                <div class="ss-option others-option" data-value="__others__">Others (specify manually)</div>
                            </div>
                            <input type="text" class="ss-custom-input" style="display:none;" placeholder="Type custom office name...">
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="input-group">
                        <label class="input-label">Latitude (Optional)</label>
                        <input type="number" step="any" name="latitude" class="form-input" placeholder="e.g. 10.7202">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Longitude (Optional)</label>
                        <input type="number" step="any" name="longitude" class="form-input" placeholder="e.g. 122.5621">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="button" onclick="closeAddModal()" class="btn" style="background: rgba(255,255,255,0.1); flex: 1; border: 1px solid var(--glass-border); color: white;">Cancel</button>
                    <button type="submit" class="btn" style="flex: 2; background: var(--primary);">Create Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal">
        <div class="glass-card modal-content animate-fade-in" style="max-width: 400px; text-align: center; padding: 2rem;">
            <h2 style="margin-bottom: 0.5rem; border: none;">Delete Employee?</h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">
                Are you sure you want to delete <strong id="delete-emp-name" style="color: white;"></strong>? 
                This action cannot be undone and all location history will be lost.
            </p>

            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 1rem;">
                    <button type="button" onclick="closeDeleteModal()" class="btn" style="background: rgba(255,255,255,0.1); flex: 1; border: 1px solid var(--glass-border); color: white;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="flex: 1;">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
@section('scripts')
<script>
    const totalEmployees = {{ $employees->count() }};

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.getElementById('employees-loading')?.classList.add('hidden');
        }, 600);

        document.querySelectorAll('.searchable-select').forEach(initSearchableSelect);
    });

    function initSearchableSelect(container) {
        const input = container.querySelector('.ss-input');
        const hidden = container.querySelector('input[type="hidden"]');
        const dropdown = container.querySelector('.ss-dropdown');
        const options = Array.from(dropdown.querySelectorAll('.ss-option'));
        let highlightedIdx = -1;

        // Set initial display value from hidden input
        if (hidden.value) {
            const matchingOpt = options.find(opt => opt.dataset.value === hidden.value);
            if (matchingOpt) {
                input.value = hidden.value;
                input.classList.add('has-value');
                matchingOpt.classList.add('selected');
            } else {
                // Value exists but not in options list — show as Others
                input.value = 'Others';
                input.classList.add('has-value');
                if (container.querySelector('.ss-custom-input')) {
                    const ci = container.querySelector('.ss-custom-input');
                    ci.style.display = '';
                    ci.value = hidden.value;
                }
            }
        }

        function open() {
            container.classList.add('open');
            filterOptions('');
            highlightedIdx = -1;
        }

        function close() {
            container.classList.remove('open');
            const ci = container.querySelector('.ss-custom-input');
            if (ci && ci.style.display !== 'none') {
                input.value = 'Others';
            } else {
                input.value = hidden.value;
            }
            highlightedIdx = -1;
        }

        const customInput = container.querySelector('.ss-custom-input');

        function selectOption(value, text) {
            if (value === '__others__') {
                // Show custom input, clear hidden for now
                hidden.value = '';
                input.value = 'Others';
                input.classList.add('has-value');
                container.classList.remove('open');
                if (customInput) {
                    customInput.style.display = '';
                    customInput.value = '';
                    customInput.focus();
                }
                return;
            }
            if (customInput) customInput.style.display = 'none';
            hidden.value = value;
            input.value = text;
            input.classList.toggle('has-value', !!value);
            options.forEach(opt => opt.classList.toggle('selected', opt.dataset.value === value));
            close();
        }

        // Custom input writes directly to hidden field
        if (customInput) {
            customInput.addEventListener('input', function() {
                hidden.value = this.value;
            });
        }

        function filterOptions(query) {
            const q = query.toLowerCase();
            let visibleCount = 0;
            options.forEach(opt => {
                const match = opt.textContent.toLowerCase().includes(q);
                opt.style.display = match ? '' : 'none';
                opt.classList.remove('highlighted');
                if (match) visibleCount++;
            });

            // Show/hide empty message
            let emptyMsg = dropdown.querySelector('.ss-empty');
            if (visibleCount === 0) {
                if (!emptyMsg) {
                    emptyMsg = document.createElement('div');
                    emptyMsg.className = 'ss-empty';
                    emptyMsg.textContent = 'No matches found';
                    dropdown.appendChild(emptyMsg);
                }
                emptyMsg.style.display = '';
            } else if (emptyMsg) {
                emptyMsg.style.display = 'none';
            }
            highlightedIdx = -1;
        }

        function getVisibleOptions() {
            return options.filter(opt => opt.style.display !== 'none');
        }

        function highlightOption(idx) {
            const visible = getVisibleOptions();
            visible.forEach(opt => opt.classList.remove('highlighted'));
            if (idx >= 0 && idx < visible.length) {
                highlightedIdx = idx;
                visible[idx].classList.add('highlighted');
                visible[idx].scrollIntoView({ block: 'nearest' });
            }
        }

        input.addEventListener('focus', function() {
            this.select();
            open();
        });

        input.addEventListener('input', function() {
            if (!container.classList.contains('open')) open();
            filterOptions(this.value);
        });

        input.addEventListener('keydown', function(e) {
            const visible = getVisibleOptions();
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!container.classList.contains('open')) open();
                highlightOption(Math.min(highlightedIdx + 1, visible.length - 1));
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightOption(Math.max(highlightedIdx - 1, 0));
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (highlightedIdx >= 0 && highlightedIdx < visible.length) {
                    selectOption(visible[highlightedIdx].dataset.value, visible[highlightedIdx].textContent);
                }
            } else if (e.key === 'Escape') {
                close();
                input.blur();
            }
        });

        options.forEach(opt => {
            opt.addEventListener('mousedown', function(e) {
                e.preventDefault(); // prevent blur before click registers
                selectOption(this.dataset.value, this.textContent);
            });
        });

        input.addEventListener('blur', function() {
            // Small delay to allow mousedown on option to fire
            setTimeout(() => close(), 150);
        });
    }

    // --- Instant Client-Side Filtering (like Workforce page) ---
    function filterEmployees() {
        const search = document.getElementById('employee-search-input').value.toLowerCase().trim();
        const officeFilter = document.getElementById('employee-office-select').value.toLowerCase();
        const rows = document.querySelectorAll('.emp-row');
        const clearBtn = document.getElementById('clear-search-btn');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const office = row.dataset.office;
            const idNo = row.dataset.idNo;
            const mobile = row.dataset.mobile;

            const matchesSearch = !search || 
                                  name.includes(search) || 
                                  email.includes(search) || 
                                  idNo.includes(search) || 
                                  mobile.includes(search);
            const matchesOffice = !officeFilter || office === officeFilter;

            if (matchesSearch && matchesOffice) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Toggle "No employees found" row
        const noEmployeesRow = document.getElementById('no-employees-row');
        if (noEmployeesRow) {
            noEmployeesRow.style.display = visibleCount === 0 ? '' : 'none';
        }

        // Update count
        document.getElementById('emp-count').textContent = `Showing ${visibleCount} of ${totalEmployees} employees`;

        // Show/hide clear button
        if (search || officeFilter) {
            clearBtn.style.display = '';
        } else {
            clearBtn.style.display = 'none';
        }
    }

    function clearFilters() {
        document.getElementById('employee-search-input').value = '';
        document.getElementById('employee-office-select').value = '';
        filterEmployees();
        document.getElementById('employee-search-input').focus();
    }

    function openAddModal() {
        const modal = document.getElementById('add-employee-modal');
        const form = modal.querySelector('form');
        const modalContent = modal.querySelector('.modal-content');

        if (form) {
            form.reset();
            // Reset searchable selects
            modal.querySelectorAll('.searchable-select').forEach(container => {
                const input = container.querySelector('.ss-input');
                const hidden = container.querySelector('input[type="hidden"]');
                const customInput = container.querySelector('.ss-custom-input');
                const options = container.querySelectorAll('.ss-option');
                if (input) {
                    input.value = '';
                    input.classList.remove('has-value');
                }
                if (hidden) {
                    hidden.value = '';
                }
                if (customInput) {
                    customInput.value = '';
                    customInput.style.display = 'none';
                }
                options.forEach(opt => opt.classList.remove('selected', 'highlighted'));
            });
        }
        
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Disable background scroll
        
        // Reset modal scroll position to top
        if (modalContent) modalContent.scrollTop = 0;
        
        // Scroll window to top for a clean backdrop
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Focus the first input
        setTimeout(() => {
            modal.querySelector('input[name="name"]')?.focus();
        }, 300);
    }

    function closeAddModal() {
        document.getElementById('add-employee-modal').classList.remove('active');
        document.body.style.overflow = ''; // Re-enable background scroll
    }

    function confirmDelete(id, name) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const nameSpan = document.getElementById('delete-emp-name');
        
        nameSpan.innerText = name;
        form.action = `/admin/employees/${id}`;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddModal();
            closeDeleteModal();
        }
    });

    // Close modals on clicking outside
    window.onclick = function(event) {
        const addModal = document.getElementById('add-employee-modal');
        const deleteModal = document.getElementById('delete-modal');
        if (event.target == addModal) closeAddModal();
        if (event.target == deleteModal) closeDeleteModal();
    }

    // Standardize all form inputs (trim whitespace) before submission
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form.method.toLowerCase() === 'post') {
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
            inputs.forEach(input => {
                input.value = input.value.trim();
            });
        }

        if (form.id === 'add-employee-form') {
            const loadingOverlay = document.getElementById('add-employee-loading');
            if (loadingOverlay) loadingOverlay.style.display = 'flex';
            
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.innerText = 'Creating...';
            }
        }
    });
</script>
@endsection
@endsection
