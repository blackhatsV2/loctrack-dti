@extends('layouts.app')

@section('styles')
<style>
    .stat-card {
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.3);
    }

    .stat-card.active {
        border-color: var(--primary);
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem !important;
        }

        .stat-card>div:first-child {
            font-size: 2rem !important;
        }
    }

    @media (max-width: 480px) {
        .stat-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Admin Dashboard</h1>
    <p style="color: var(--text-muted); margin-bottom: 2.5rem;">Real-time workforce distribution and analytics.</p>

    <div class="stat-grid">
        <a href="{{ route('admin.employees') }}" class="glass-card stat-card">
            <div style="font-size: 2.5rem; font-weight: 600; color: #818cf8;">{{ $totalEmployees }}</div>
            <div style="color: var(--text-muted); margin-top: 0.5rem; font-size: 0.9rem;">Total Personnel</div>
        </a>
        <a href="{{ route('admin.workforce') }}#records" class="glass-card stat-card">
            <div style="font-size: 2.5rem; font-weight: 600; color: #34d399;">{{ $totalLocations }}</div>
            <div style="color: var(--text-muted); margin-top: 0.5rem; font-size: 0.9rem;">Active Locations</div>
        </a>
        <a href="{{ route('admin.workforce') }}#analytics" class="glass-card stat-card">
            <div style="font-size: 2.5rem; font-weight: 600; color: #f472b6;">{{ $totalOffices }}</div>
            <div style="color: var(--text-muted); margin-top: 0.5rem; font-size: 0.9rem;">Active Offices</div>
        </a>
        <a href="{{ route('admin.map') }}" class="glass-card stat-card">
            <div style="font-size: 2.5rem; font-weight: 600;">🌍</div>
            <div style="color: var(--text-muted); margin-top: 0.5rem; font-size: 0.9rem;">Global View</div>
        </a>
    </div>

    <!-- Online Presence Section -->
    <div class="glass-card animate-fade-in" style="margin-bottom: 2rem;">
        <div style="margin-bottom: 1.5rem;">
            <h2 style="margin-bottom: 0.25rem;">📡 Online Personnel</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Employees currently active within the last 15 minutes.</p>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
            @forelse($onlineUsers as $onlineUser)
            <div class="glass-card"
                style="padding: 0.75rem 1.25rem; display: flex; align-items: center; gap: 0.75rem; border-color: rgba(52, 211, 153, 0.2); background: rgba(52, 211, 153, 0.05);">
                <div class="pulse-dot" style="background: #34d399; width: 8px; height: 8px;"></div>
                <span style="font-weight: 600; font-size: 0.95rem;">{{ $onlineUser->name }}</span>
            </div>
            @empty
            <div style="padding: 2rem; text-align: center; width: 100%; color: var(--text-muted); border: 1px dashed var(--glass-border); border-radius: 1rem;">
                No employees are currently online.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Navigation -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <a href="{{ route('admin.workforce') }}" class="glass-card stat-card" style="padding: 2rem; flex-direction: row; align-items: center; gap: 1.5rem;">
            <div style="font-size: 2.5rem;">🌍</div>
            <div>
                <h3 style="margin-bottom: 0.25rem;">Workforce Geography</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem;">View map distribution and analytics.</p>
            </div>
        </a>
        <a href="{{ route('admin.employees') }}" class="glass-card stat-card" style="padding: 2rem; flex-direction: row; align-items: center; gap: 1.5rem;">
            <div style="font-size: 2.5rem;">👥</div>
            <div>
                <h3 style="margin-bottom: 0.25rem;">Employee Management</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Manage personnel and contact info.</p>
            </div>
        </a>
    </div>

</div>
@endsection