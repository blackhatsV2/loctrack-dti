<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preparedness, Safety & Continuity Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('dti-logo.png') }}">
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#6366f1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ===== DARK THEME (default) ===== */
        :root,
        html[data-theme="dark"] {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --body-bg: #0f172a;
            --nav-bg: #1e293b;
            --card-bg: #1e293b;
            --border-color: #334155;
            --input-bg: #0f172a;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --table-row-hover: rgba(99, 102, 241, 0.06);
            --modal-bg: #1e293b;
            --sidebar-bg: #1e293b;
            --event-card-bg: #0f172a;
            --map-loading-bg: rgba(15, 23, 42, 0.85);
            --mobile-menu-bg: #0f172a;
            --loader-bg: #0f172a;
            --toast-bg: #1e293b;
            --table-sticky-bg: #1e293b;
            --profile-info-bg: rgba(0, 0, 0, 0.15);
            --profile-info-border: rgba(255, 255, 255, 0.05);
            --minimap-bg: #111;
            --scrollbar-thumb: rgba(255,255,255,0.1);
            --filter-item-hover: rgba(255,255,255,0.03);
            --filter-count-bg: rgba(255,255,255,0.06);
            --notif-dropdown-bg: #1e293b;
            --notif-item-hover: rgba(255, 255, 255, 0.05);
            --notif-item-border: rgba(255,255,255,0.05);
            --disaster-popup-bg: #0f172a;
            --search-placeholder: rgba(255,255,255,0.35);
            --ss-option-color: rgba(255,255,255,0.8);
            --ss-empty-color: rgba(255,255,255,0.35);
            --ss-scrollbar-thumb: rgba(255,255,255,0.15);
            --leaflet-popup-bg: #1e293b;
            --leaflet-popup-color: #f1f5f9;
            --tile-filter: brightness(0.9) invert(0);

            /* Legacy aliases */
            --bg-dark: #0f172a;
            --glass: #1e293b;
            --glass-border: #334155;
        }

        /* ===== LIGHT THEME ===== */
        html[data-theme="light"] {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --body-bg: #f1f5f9;
            --nav-bg: #ffffff;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --input-bg: #f8fafc;
            --text-light: #0f172a;
            --text-muted: #64748b;
            --table-row-hover: rgba(99, 102, 241, 0.07);
            --modal-bg: #ffffff;
            --sidebar-bg: #f8fafc;
            --event-card-bg: #f1f5f9;
            --map-loading-bg: rgba(241, 245, 249, 0.9);
            --mobile-menu-bg: #ffffff;
            --loader-bg: #f1f5f9;
            --toast-bg: #ffffff;
            --table-sticky-bg: #ffffff;
            --profile-info-bg: rgba(99, 102, 241, 0.04);
            --profile-info-border: rgba(99, 102, 241, 0.1);
            --minimap-bg: #e2e8f0;
            --scrollbar-thumb: rgba(0,0,0,0.15);
            --filter-item-hover: rgba(0,0,0,0.03);
            --filter-count-bg: rgba(0,0,0,0.06);
            --notif-dropdown-bg: #ffffff;
            --notif-item-hover: rgba(0, 0, 0, 0.04);
            --notif-item-border: rgba(0,0,0,0.05);
            --disaster-popup-bg: #ffffff;
            --search-placeholder: rgba(0,0,0,0.35);
            --ss-option-color: rgba(0,0,0,0.75);
            --ss-empty-color: rgba(0,0,0,0.4);
            --ss-scrollbar-thumb: rgba(0,0,0,0.15);
            --leaflet-popup-bg: #ffffff;
            --leaflet-popup-color: #0f172a;
            --tile-filter: brightness(1) invert(0);

            /* Legacy aliases */
            --bg-dark: #f1f5f9;
            --glass: #ffffff;
            --glass-border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        nav {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-wrap: nowrap;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .nav-hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.25rem;
            line-height: 1;
            box-shadow: none;
        }
        .nav-hamburger:hover {
            background: rgba(99, 102, 241, 0.15);
            transform: none;
            box-shadow: none;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            flex-shrink: 0;
            margin-right: auto; /* Push links to the right */
        }
        
        .logo-img {
            height: 48px; /* Slightly larger for better visibility */
            width: auto;
            object-fit: contain;
            display: block;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.025em;
            color: #818cf8;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-links.mobile-open {
            display: flex;
        }

        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 400;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .nav-links a:hover {
            background: rgba(99, 102, 241, 0.15);
            color: var(--primary);
        }

        .nav-links a.active {
            background: rgba(99, 102, 241, 0.15);
            color: var(--primary);
            font-weight: 600;
        }

        .nav-badge {
            display: inline-block;
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.5rem;
            border-radius: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-left: 0.5rem;
            vertical-align: middle;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-badge:hover {
            background: var(--primary-hover);
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 1rem;
            box-sizing: border-box;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: var(--modal-bg);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin: auto;
            max-height: 90vh;
            overflow-y: auto;
            box-sizing: border-box;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        main {
            flex: 1;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            width: 100%;
            max-width: 1200px;
        }

        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        button, .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        /* ===== Button Variants ===== */
        .btn-primary {
            background: var(--primary) !important;
            color: white !important;
            border: none !important;
        }
        .btn-primary:hover {
            background: var(--primary-hover) !important;
        }

        /* Ghost: subtle border button that looks good in both themes */
        .btn-ghost {
            background: var(--filter-count-bg) !important;
            color: var(--text-light) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: none !important;
        }
        .btn-ghost:hover {
            background: rgba(99, 102, 241, 0.12) !important;
            color: var(--primary) !important;
            border-color: var(--primary) !important;
            box-shadow: none !important;
            transform: translateY(-1px) !important;
        }
        .btn-ghost.active, .btn-ghost.active-hazard-filter {
            background: rgba(99, 102, 241, 0.18) !important;
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* Secondary/Cancel ghost: clearly distinct from primary */
        .btn-secondary-ghost {
            background: var(--filter-count-bg) !important;
            color: var(--text-muted) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: none !important;
        }
        .btn-secondary-ghost:hover {
            background: rgba(244, 63, 94, 0.08) !important;
            color: #f43f5e !important;
            border-color: rgba(244, 63, 94, 0.4) !important;
            box-shadow: none !important;
            transform: translateY(-1px) !important;
        }

        .alert-success {
            background: rgba(74, 222, 128, 0.15);
            border: 1px solid rgba(74, 222, 128, 0.3);
            color: #4ade80;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.3);
            color: #f43f5e;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* ===== Mobile Responsive ===== */
        @media (max-width: 768px) {
            nav {
                padding: 1rem 1.25rem;
            }
            .nav-hamburger {
                display: block;
            }
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--mobile-menu-bg);
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
                padding: 1.5rem;
                border-top: 1px solid var(--border-color);
                border-bottom: 1px solid var(--border-color);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                z-index: 99;
                will-change: transform, opacity;
                transform: translateZ(0);
            }
            .nav-links.mobile-open {
                display: flex;
            }
            .nav-links a {
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                text-align: center;
                background: var(--filter-item-hover);
                color: var(--text-light);
            }
            .nav-links form {
                width: 100%;
            }
            .nav-links form a {
                display: block;
                padding: 0.75rem 1rem;
                text-align: center;
                background: rgba(244, 63, 94, 0.1);
                color: #f43f5e;
            }
            .nav-badge {
                align-self: center;
                margin-left: 0;
                margin-top: 0.25rem;
                margin-bottom: 0.5rem;
                padding: 0.25rem 0.75rem;
            }
            main {
                padding: 1rem;
            }
            .glass-card {
                padding: 1.25rem;
                border-radius: 1rem;
            }
            .modal-content {
                margin: auto;
                padding: 1.5rem;
                border-radius: 1rem;
                max-width: 100%;
            }
            h1 {
                font-size: 1.5rem !important;
            }
        }

        @media (max-width: 480px) {
            main {
                padding: 0.75rem;
            }
            .glass-card {
                padding: 1rem;
            }
            .modal-overlay {
                padding: 0.75rem;
            }
            .modal-content {
                padding: 1.25rem;
            }
        }

        /* ===== Reusable Loading States ===== */
        .page-loading {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            padding: 3rem;
            width: 100%;
        }
        .page-loading.hidden {
            display: none !important;
        }
        .spinner {
            width: 36px; height: 36px;
            border: 3px solid rgba(99, 102, 241, 0.2);
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        .spinner-text {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Global redirect loading overlay */
        #global-loader {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--loader-bg);
            z-index: 9999;
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1.25rem;
            transition: opacity 0.4s ease;
            opacity: 0;
        }
        
        #global-loader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        #top-progress {
            position: fixed;
            top: 0; left: 0;
            width: 0; height: 3px;
            background: #6366f1;
            z-index: 10001;
            transition: width 0.4s ease;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
            display: none;
            pointer-events: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Skeleton Shimmer Utility */
        .skeleton {
            background: rgba(255, 255, 255, 0.07);
            border-radius: 0.75rem;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        /* Notification System */
        .notification-container {
            position: relative;
            display: inline-block;
            margin-right: 0.5rem;
            margin-left: 0.5rem;
        }
        .notification-bell {
            background: var(--filter-count-bg);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-light);
            transition: all 0.2s ease;
            position: relative;
        }
        .notification-bell:hover {
            background: rgba(99, 102, 241, 0.15);
            color: var(--primary);
        }
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #f43f5e;
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 10px;
            display: none;
        }
        .notification-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.75rem;
            background: var(--notif-dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            width: 300px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
            flex-direction: column;
            overflow: hidden;
            animation: fadeIn 0.2s ease-out;
        }
        .notification-dropdown.active {
            display: flex;
        }
        .notification-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 0.95rem;
        }
        .notification-item {
            padding: 1rem;
            border-bottom: 1px solid var(--notif-item-border);
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .notification-item:hover {
            background: var(--notif-item-hover);
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #f43f5e;
        }
        html[data-theme="dark"] .notification-title {
            color: #fca5a5;
        }
        .notification-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* Nearest Disaster Popup Overlay */
        #disaster-popup {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            opacity: 0;
            background: var(--disaster-popup-bg);
            border: 1px solid var(--border-color);
            border-top: 4px solid #f43f5e;
            border-radius: 1rem;
            padding: 1.5rem;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(244, 63, 94, 0.25);
            z-index: 10000;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none;
        }
        #disaster-popup.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
        .popup-close {
            position: absolute;
            top: 0.75rem;
            right: 1rem;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0;
        }
        .popup-close:hover {
            color: var(--text-light);
        }
        
        .mobile-action-notif {
            display: none;
            margin: 0;
        }
        @media (max-width: 768px) {
            #notification-container > .notification-bell {
                display: none !important;
            }
            .notification-container {
                margin: 0;
            }
            .mobile-action-notif {
                display: inline-block;
                margin: 0;
            }
        }

        /* ===== Theme Toggle Button ===== */
        .theme-toggle {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-light);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            padding: 0;
            font-size: 1rem;
        }
        .theme-toggle:hover {
            background: rgba(99, 102, 241, 0.15);
            border-color: var(--primary);
            transform: none;
            box-shadow: none;
        }
        .theme-toggle .icon-sun  { display: none; }
        .theme-toggle .icon-moon { display: block; }
        html[data-theme="light"] .theme-toggle .icon-sun  { display: block; }
        html[data-theme="light"] .theme-toggle .icon-moon { display: none; }

        /* ===== Mobile & Small Screen Main Page Blur System ===== */
        #mobile-backdrop-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 98;
            opacity: 0;
            pointer-events: none;
            will-change: opacity;
            transform: translateZ(0);
            transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay,
        .modal {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        @media (max-width: 1024px) {
            body.mobile-blur-active #mobile-backdrop-overlay {
                opacity: 1;
                pointer-events: auto;
            }

            nav {
                z-index: 100;
            }

            .nav-links.mobile-open {
                z-index: 101;
            }

            .notification-container {
                position: relative;
                z-index: 102;
            }

            .notification-dropdown {
                z-index: 1000;
            }

            .searchable-select.open {
                z-index: 999;
            }

            .searchable-select.open .ss-dropdown {
                z-index: 1000;
            }

            .modal-overlay,
            .modal {
                z-index: 9999;
            }

            #disaster-popup {
                z-index: 10000;
            }

            .leaflet-popup {
                z-index: 1000;
            }
        }
    </style>
    @yield('styles')
    <!-- Prevent FOUC: set theme before first paint -->
    <script>
        (function() {
            var saved = localStorage.getItem('pscp-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
</head>
<body>
    <div id="mobile-backdrop-overlay" onclick="closeAllMobileOverlays()"></div>
    <div id="top-progress"></div>
    <div id="global-loader">
        <div class="spinner"></div>
        <div class="spinner-text" style="font-weight: 500;">Connecting...</div>
    </div>
    <script>
        // Clear session cache on authentication entry/exit points
        const currentPath = window.location.pathname;
        if (currentPath === '/' || currentPath.includes('/login') || currentPath.includes('/logout')) {
            sessionStorage.clear();
        }

        // For dashboard/map/disasters pages, check if we already have the cache warm
        const isMapOrDashboard = currentPath.includes('/dashboard') || 
                                 currentPath.includes('/map') || 
                                 currentPath.includes('/disasters');
        
        // Cache exists if we have locations, earthquakes, and events
        const hasCache = sessionStorage.getItem('cached_locations') && 
                         sessionStorage.getItem('cached_earthquakes') && 
                         sessionStorage.getItem('cached_events');
                         
        const delay = (isMapOrDashboard && !hasCache) ? 0 : 1000;

        window.loaderTimeout = setTimeout(function() {
            const loader = document.getElementById('global-loader');
            if (loader && !window.pageLoaded) {
                if (isMapOrDashboard) {
                    const textEl = loader.querySelector('.spinner-text');
                    if (textEl) textEl.textContent = 'Loading system resources...';
                }
                loader.style.display = 'flex';
                setTimeout(() => loader.style.opacity = '1', 10);
            }
        }, delay);
    </script>
    <div id="toast-container" style="position: fixed; bottom: 2rem; right: 2rem; z-index: 9999; display: flex; flex-direction: column; gap: 1rem;"></div>

    <div id="disaster-popup">
        <button class="popup-close" onclick="closeDisasterPopup()">&times;</button>
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f43f5e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            <h3 style="color: #f43f5e; font-size: 1.1rem; margin: 0;">Disaster Alert!</h3>
        </div>
        <div id="disaster-popup-content" style="font-size: 0.9rem; color: var(--text-light); line-height: 1.5;">
            <!-- Content injected via JS -->
        </div>
    </div>
    <nav>
        <a href="{{ url('/') }}" class="logo-container">
            <picture>
                <source srcset="{{ asset('dti-logo.webp') }}" type="image/webp">
                <img src="{{ asset('dti-logo.png') }}" alt="DTI Logo" class="logo-img" width="40" height="40" decoding="async">
            </picture>
            <span class="logo-text">PSCP Workforce Locator</span>
        </a>
        
        @auth
            <div class="notification-container" id="notification-container">
                <div class="notification-bell" onclick="toggleNotifications(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-badge notif-badge" id="notif-badge">0</span>
                </div>
                <div class="notification-dropdown" id="notification-dropdown">
                    <div class="notification-header">Alerts & Notifications</div>
                    <div id="notification-list">
                        <div class="notification-item" style="color: var(--text-muted); text-align: center; font-size: 0.85rem;">
                            No recent alerts near your location.
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle light/dark theme" title="Toggle theme">
            <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </button>
        <button class="nav-hamburger" onclick="toggleMobileNav()" aria-label="Toggle navigation"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block;"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg></button>
        <div class="nav-links" id="nav-links">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.employees') }}" class="{{ request()->routeIs('admin.employees*') ? 'active' : '' }}">Employees</a>
                    <a href="{{ route('admin.workforce') }}" class="{{ request()->routeIs('admin.workforce') ? 'active' : '' }}">Workforce</a>

                    <span class="nav-badge" onclick="toggleProfileModal()">Admin</span>
                @else
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('location.geography') }}" class="{{ request()->routeIs('location.geography') ? 'active' : '' }}">My Geography</a>
                    <a href="{{ route('location.history') }}" class="{{ request()->routeIs('location.history') ? 'active' : '' }}">History</a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="opacity: 0.7;">Logout</a>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </nav>

    @auth
        <!-- Profile Modal -->
        <div id="profile-modal" class="modal-overlay" onclick="if(event.target === this) toggleProfileModal()">
            <div class="modal-content">
                <h2 style="margin-bottom: 1.5rem;">Update Profile</h2>
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>New Password (Optional)</label>
                        <input type="password" name="password" class="form-control" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                    </div>
                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                        <button type="submit" style="flex: 2;">Update Details</button>
                        <button type="button" class="btn btn-secondary-ghost" style="flex: 1;" onclick="toggleProfileModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">
                    <ul style="list-style: none; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
    <script>
        /* ===== Theme Toggle ===== */
        function toggleTheme() {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme') || 'dark';
            var next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('pscp-theme', next);
            window.dispatchEvent(new CustomEvent('pscp-theme-changed', { detail: { theme: next } }));
        }
    </script>
    <script>
        // Global loading feedback
        window.addEventListener('load', function() {
            window.pageLoaded = true;
            if (window.loaderTimeout) clearTimeout(window.loaderTimeout);
            
            if (window.manualLoaderControl) return;
            hideGlobalLoader();
        });

        function hideGlobalLoader() {
            const loader = document.getElementById('global-loader');
            if (loader) {
                loader.classList.add('fade-out');
                setTimeout(() => {
                    loader.style.display = 'none';
                    loader.classList.remove('fade-out');
                }, 400);
            }
        }

        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'glass-card animate-fade-in';
            toast.style.padding = '1rem 1.5rem';
            toast.style.minWidth = '300px';
            toast.style.borderLeft = `4px solid ${type === 'success' ? '#4ade80' : '#f43f5e'}`;
            toast.style.boxShadow = '0 20px 40px rgba(0,0,0,0.6)';
            toast.style.marginBottom = '0'; /* Reset padding from glass-card if any */
            
            toast.innerHTML = `
                <div style="font-weight: 600; color: var(--text-light); margin-bottom: 0.25rem;">${title}</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">${message}</div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                toast.style.transition = 'all 0.4s ease';
                setTimeout(() => toast.remove(), 450);
            }, 4000);
        }

        function toggleProfileModal() {
            const modal = document.getElementById('profile-modal');
            if (modal) {
                modal.classList.toggle('active');
            }
        }

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW registered:', reg.scope))
                    .catch(err => console.log('SW registration failed:', err));
            });
        }

        // Show loader on navigation and form submissions
        function showGlobalLoader() {
            const loader = document.getElementById('global-loader');
            if (loader) {
                loader.style.display = 'flex';
                loader.style.opacity = '1';
                loader.classList.remove('fade-out');
            }
        }

        document.addEventListener('submit', function(e) {
            // Wait a tiny bit to see if the event was cancelled by onsubmit="return confirm(...)"
            setTimeout(() => {
                if (!e.defaultPrevented) {
                    sessionStorage.removeItem('cached_locations');
                    showGlobalLoader();
                }
            }, 10);
        });

        function startProgressBar() {
            const bar = document.getElementById('top-progress');
            if (bar) {
                bar.style.display = 'block';
                bar.style.width = '0%';
                setTimeout(() => bar.style.width = '40%', 10);
                setTimeout(() => bar.style.width = '70%', 300);
                setTimeout(() => bar.style.width = '90%', 1000);
            }
        }

        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link) {
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');
                
                if (href && 
                    !href.startsWith('#') && 
                    !href.startsWith('javascript:') && 
                    target !== '_blank' && 
                    !link.hasAttribute('download') &&
                    !link.classList.contains('no-loader')) {
                    
                    // Show progress bar instead of full-screen loader for immediate feedback
                    startProgressBar();
                }
            }
        });

        // InstantClick-like prefetching
        document.addEventListener('mouseover', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && link.origin === window.location.origin && !link.dataset.prefetched) {
                const href = link.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                    const prefetchLink = document.createElement('link');
                    prefetchLink.rel = 'prefetch';
                    prefetchLink.href = href;
                    document.head.appendChild(prefetchLink);
                    link.dataset.prefetched = 'true';
                }
            }
        });

        // Handle browser back button (hide loader if it was showing)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                const loader = document.getElementById('global-loader');
                if (loader) {
                    loader.style.display = 'none';
                }
            }
        });

        /* --- Universal Capture Phase Handler: Close Popups/Dropdowns/Modals on Outside Click without Activating Outside Elements --- */
        window.addEventListener('click', function(e) {
            let closedOverlay = false;

            // 1. Mobile Navigation Menu
            const navLinks = document.getElementById('nav-links');
            const hamburger = document.querySelector('.nav-hamburger');
            if (navLinks && navLinks.classList.contains('mobile-open')) {
                const inNav = navLinks.contains(e.target);
                const inTrigger = hamburger && hamburger.contains(e.target);
                if (!inNav && !inTrigger) {
                    navLinks.classList.remove('mobile-open');
                    closedOverlay = true;
                }
            }

            // 2. Notification Dropdown
            const notifDropdown = document.getElementById('notification-dropdown');
            if (notifDropdown && notifDropdown.classList.contains('active')) {
                const inDropdown = notifDropdown.contains(e.target);
                const inContainer = !!e.target.closest('.notification-container');
                if (!inDropdown && !inContainer) {
                    notifDropdown.classList.remove('active');
                    closedOverlay = true;
                }
            }

            // 3. Profile Modal
            const profileModal = document.getElementById('profile-modal');
            if (profileModal && profileModal.classList.contains('active')) {
                const profileContent = profileModal.querySelector('.modal-content');
                const adminBadge = document.querySelector('.nav-badge');
                const inContent = profileContent && profileContent.contains(e.target);
                const inBadge = adminBadge && adminBadge.contains(e.target);
                if (!inContent && !inBadge) {
                    profileModal.classList.remove('active');
                    closedOverlay = true;
                }
            }

            // 4. Disaster Alert Popup
            const disasterPopup = document.getElementById('disaster-popup');
            if (disasterPopup && disasterPopup.classList.contains('show')) {
                const inPopup = disasterPopup.contains(e.target);
                if (!inPopup) {
                    disasterPopup.classList.remove('show');
                    closedOverlay = true;
                }
            }

            // 5. Searchable Select Dropdowns
            document.querySelectorAll('.searchable-select.open').forEach(ss => {
                if (!ss.contains(e.target)) {
                    ss.classList.remove('open');
                    const customInput = ss.querySelector('.ss-custom-input');
                    const selectBox = ss.querySelector('.ss-input');
                    const hiddenInput = ss.querySelector('input[type="hidden"]');
                    if (customInput && customInput.style.display !== 'none' && !customInput.value) {
                        if (selectBox) selectBox.style.display = 'block';
                        customInput.style.display = 'none';
                    } else if (selectBox && hiddenInput) {
                        selectBox.value = hiddenInput.value;
                    }
                    closedOverlay = true;
                }
            });

            // 6. Page Modals / Overlays (e.g., Add Employee, Delete Employee confirmation)
            document.querySelectorAll('.modal, .modal-overlay').forEach(modal => {
                if (modal.id === 'profile-modal') return; // Handled separately
                const style = window.getComputedStyle(modal);
                const isVisible = style.display !== 'none' && style.visibility !== 'hidden' && (modal.offsetWidth > 0 || modal.offsetHeight > 0);
                if (isVisible) {
                    const modalContent = modal.querySelector('.modal-content') || modal;
                    const inContent = modalContent && modalContent.contains(e.target);
                    if (!inContent) {
                        modal.style.display = 'none';
                        modal.classList.remove('active', 'show');
                        closedOverlay = true;
                    }
                }
            });

            // If an active popup or dropdown was closed by this outside click, prevent activating the outside element!
            if (closedOverlay) {
                e.stopPropagation();
                e.stopImmediatePropagation();
                e.preventDefault();
            }
        }, true);

        function toggleNotifications(event) {
            const dropdown = document.getElementById('notification-dropdown');
            if (!dropdown) return;

            // If opening from inside mobile nav drawer, close mobile nav for a clean view
            const navLinks = document.getElementById('nav-links');
            if (navLinks && navLinks.classList.contains('mobile-open')) {
                navLinks.classList.remove('mobile-open');
            }

            const willBeActive = !dropdown.classList.contains('active');

            if (willBeActive && window.innerWidth <= 768) {
                let bell = null;
                if (event && event.currentTarget) {
                    bell = event.currentTarget;
                } else {
                    bell = document.querySelector('.mobile-action-notif .notification-bell') || document.querySelector('.notification-bell');
                }

                if (bell) {
                    const rect = bell.getBoundingClientRect();
                    const topPos = rect.bottom + 8;
                    const rightOffset = Math.max(10, Math.min(window.innerWidth - rect.right, window.innerWidth - 340));
                    
                    dropdown.style.setProperty('position', 'fixed', 'important');
                    dropdown.style.setProperty('top', topPos + 'px', 'important');
                    dropdown.style.setProperty('right', rightOffset + 'px', 'important');
                    dropdown.style.setProperty('left', 'auto', 'important');
                    dropdown.style.setProperty('transform', 'none', 'important');
                    dropdown.style.setProperty('width', 'calc(100vw - 2rem)', 'important');
                    dropdown.style.setProperty('max-width', '340px', 'important');
                    dropdown.style.setProperty('margin-top', '0', 'important');
                    dropdown.style.setProperty('z-index', '10000', 'important');
                }
            } else if (!willBeActive) {
                dropdown.style.top = '';
                dropdown.style.right = '';
                dropdown.style.left = '';
                dropdown.style.transform = '';
                dropdown.style.position = '';
                dropdown.style.width = '';
                dropdown.style.maxWidth = '';
                dropdown.style.marginTop = '';
                dropdown.style.zIndex = '';
            }

            dropdown.classList.toggle('active');
        }

        function closeDisasterPopup() {
            const popup = document.getElementById('disaster-popup');
            if (popup) popup.classList.remove('show');
        }

        @auth
        document.addEventListener('DOMContentLoaded', function() {
            fetchNearestDisaster();
            
            // Poll for notifications every 5 minutes (300000 ms)
            setInterval(fetchNearestDisaster, 300000);
        });        function handleDisasterClick(lat, lon, targetPath) {
            const currentPath = window.location.pathname;
            // Allow exact match or with trailing slash
            if (currentPath === targetPath || currentPath === targetPath + '/') {
                const targetMap = (typeof map !== 'undefined') ? map : (window.map ? window.map : null);
                if (targetMap) {
                    targetMap.flyTo([lat, lon], 10, {duration: 1.5});
                    setTimeout(() => {
                        targetMap.eachLayer(function(layer) {
                            if (layer.getLatLng && layer.openPopup) {
                                const latlng = layer.getLatLng();
                                if (Math.abs(latlng.lat - lat) < 0.0001 && Math.abs(latlng.lng - lon) < 0.0001) {
                                    layer.openPopup();
                                }
                            }
                        });
                    }, 1500);
                }
                closeDisasterPopup();
                const dropdown = document.getElementById('notification-dropdown');
                if (dropdown) dropdown.classList.remove('active');
            } else {
                window.location.href = `${targetPath}?lat=${lat}&lon=${lon}&zoom=10&open_popup=1`;
            }
        }

        function fetchNearestDisaster() {
            fetch('/api/notifications/nearest-disaster')
                .then(response => response.json())
                .then(data => { if (data) {
                        const isAdminUser = data.is_admin || false;
                        const targetPath = isAdminUser ? '/admin/dashboard' : '/dashboard';

                        if (isAdminUser && data.philippine_disasters) {
                            const badges = document.querySelectorAll('.notif-badge, .notification-badge');
                            badges.forEach(badge => {
                                badge.style.display = data.philippine_disasters.length > 0 ? 'block' : 'none';
                                badge.textContent = data.philippine_disasters.length;
                            });
                            
                            const notifList = document.getElementById('notification-list');
                            if (notifList) {
                                let html = '<div style="padding: 1rem 1rem 0.5rem 1rem; font-size: 0.8rem; font-weight: 700; color: var(--text-light); border-bottom: 1px solid var(--border-color); text-transform: uppercase; letter-spacing: 0.05em;">Active Philippine Disasters</div>';
                                data.philippine_disasters.forEach(disaster => {
                                    const isEarthquake = disaster.type === 'earthquake';
                                    const typeLabel = isEarthquake ? 'Earthquake' : (disaster.category || 'NASA Alert');
                                    const badgeColor = isEarthquake ? '#fb7185' : '#60a5fa';
                                    const badgeBg = isEarthquake ? 'rgba(244, 63, 94, 0.2)' : 'rgba(59, 130, 246, 0.2)';
                                    const titlePrefix = isEarthquake ? 'M ' + disaster.magnitude + ' - ' : '';
                                    
                                    html += `
                                        <div onclick="handleDisasterClick(${disaster.latitude}, ${disaster.longitude}, '${targetPath}')" 
                                             class="notification-item"
                                             style="cursor: pointer; transition: all 0.2s;">
                                            <div style="display: inline-block; padding: 0.2rem 0.5rem; border-radius: 0.4rem; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; background: ${badgeBg}; color: ${badgeColor};">${typeLabel}</div>
                                            <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">${titlePrefix}${disaster.title}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">Distance: <strong>${disaster.distance_km} km</strong> away</div>
                                            <div style="font-size: 0.7rem; color: var(--text-muted); opacity: 0.8; margin-top: 4px;">${new Date(disaster.time).toLocaleString()}</div>
                                        </div>
                                    `;
                                });
                                
                                if (data.philippine_disasters.length === 0) {
                                    html += '<div style="padding: 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.85rem;">No active disasters in the Philippines</div>';
                                }
                                
                                notifList.innerHTML = `<div style="max-height: 400px; overflow-y: auto;">${html}</div>`;
                            }
                            
                            // Close popup if any
                            const popup = document.getElementById('disaster-popup');
                            if (popup) popup.classList.remove('show');
                        } else if (data.nearest_disaster) {
                            const disaster = data.nearest_disaster;
                            
                            // Hazard card styling components
                            const isEarthquake = disaster.type === 'earthquake';
                            const typeLabel = isEarthquake ? 'Earthquake' : (disaster.category || 'NASA Alert');
                            const badgeColor = isEarthquake ? '#fb7185' : '#60a5fa';
                            const badgeBg = isEarthquake ? 'rgba(244, 63, 94, 0.2)' : 'rgba(59, 130, 246, 0.2)';
                            const titlePrefix = isEarthquake ? 'M ' + disaster.magnitude + ' - ' : '';

                            const hazardCardHtml = `
                                <div onclick="handleDisasterClick(${disaster.latitude}, ${disaster.longitude}, '${targetPath}')" 
                                     style="background: var(--profile-info-bg); border: 1px solid var(--border-color); border-radius: 0.75rem; padding: 1rem; cursor: pointer; transition: all 0.2s;"
                                     onmouseover="this.style.borderColor='#6366f1'; this.style.background='var(--notif-item-hover)';"
                                     onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='var(--profile-info-bg)';"
                                     class="notification-item-card">
                                    <div style="display: inline-block; padding: 0.2rem 0.5rem; border-radius: 0.4rem; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; background: ${badgeBg}; color: ${badgeColor};">${typeLabel}</div>
                                    <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">${titlePrefix}${disaster.title}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">Distance: <strong>${disaster.distance_km} km</strong> away</div>
                                    <div style="font-size: 0.7rem; color: var(--text-muted); opacity: 0.8; margin-top: 4px;">${new Date(disaster.time).toLocaleString()}</div>
                                    <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #818cf8; font-weight: 600;">View on map &rarr;</div>
                                </div>
                            `;
                            
                            // Update dropdown UI
                            const badges = document.querySelectorAll('.notif-badge, .notification-badge');
                            badges.forEach(badge => {
                                badge.style.display = 'block';
                                badge.textContent = '1';
                            });

                            const notifList = document.getElementById('notification-list');
                            if (notifList) {
                                const headerHtml = '<div style="padding: 1rem 1rem 0.5rem 1rem; font-size: 0.8rem; font-weight: 700; color: var(--text-light); border-bottom: 1px solid var(--border-color); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nearest Disaster Alert</div>';
                                notifList.innerHTML = `<div style="max-height: 400px; overflow-y: auto;">${headerHtml}<div style="padding: 0 0.5rem 0.5rem 0.5rem;">${hazardCardHtml}</div></div>`;
                            }

                            // Handle Popup Logic
                            const lastAlertedId = localStorage.getItem('last_alerted_disaster_id');
                            const hasSeenThisSession = sessionStorage.getItem('seen_disaster_popup');

                            // Show popup if it's a NEW disaster altogether, OR if they haven't seen it in this login session
                            if (lastAlertedId !== disaster.id || !hasSeenThisSession) {
                                
                                // Inject content into popup
                                const popupContent = document.getElementById('disaster-popup-content');
                                if (popupContent) {
                                    popupContent.innerHTML = hazardCardHtml;
                                }

                                // Show the popup
                                const popup = document.getElementById('disaster-popup');
                                if (popup) popup.classList.add('show');
                                
                                // Save states
                                localStorage.setItem('last_alerted_disaster_id', disaster.id);
                                sessionStorage.setItem('seen_disaster_popup', 'true');
                                
                                // Auto hide after 15 seconds
                                setTimeout(() => {
                                    if (popup) popup.classList.remove('show');
                                }, 15000);
                            }
                        }
                    } 
                })
                .catch(err => console.error('Failed to fetch nearest disaster', err));
        }
        @endauth

        // ===== Optimized Mobile View Blur & Overlay System =====
        let isOverlayCheckPending = false;

        function isMobileOrSmallScreen() {
            return window.innerWidth <= 1024;
        }

        function toggleMobileNav() {
            const navLinks = document.getElementById('nav-links');
            if (!navLinks) return;
            const isOpening = !navLinks.classList.contains('mobile-open');
            navLinks.classList.toggle('mobile-open');

            if (isOpening && isMobileOrSmallScreen()) {
                document.body.classList.add('mobile-blur-active');
            } else {
                scheduleOverlayCheck();
            }
        }

        function scheduleOverlayCheck() {
            if (isOverlayCheckPending) return;
            isOverlayCheckPending = true;
            requestAnimationFrame(() => {
                isOverlayCheckPending = false;
                checkActiveOverlays();
            });
        }

        function checkActiveOverlays() {
            const mobileBackdrop = document.getElementById('mobile-backdrop-overlay');
            if (!mobileBackdrop) return;

            if (!isMobileOrSmallScreen()) {
                document.body.classList.remove('mobile-blur-active');
                return;
            }

            // Fast class selector checks without layout thrashing
            const isNavOpen = !!document.querySelector('#nav-links.mobile-open');
            const isNotifOpen = !!document.querySelector('#notification-dropdown.active');
            const isDisasterPopupOpen = !!document.querySelector('#disaster-popup.show');
            const isSelectOpen = !!document.querySelector('.searchable-select.open');
            const isModalOpen = !!document.querySelector('.modal.active, .modal-overlay.active');

            const hasActiveOverlay = isNavOpen || isNotifOpen || isDisasterPopupOpen || isSelectOpen || isModalOpen;

            if (hasActiveOverlay) {
                document.body.classList.add('mobile-blur-active');
            } else {
                document.body.classList.remove('mobile-blur-active');
            }
        }

        function closeAllMobileOverlays() {
            const navLinks = document.getElementById('nav-links');
            if (navLinks) navLinks.classList.remove('mobile-open');

            const notifDropdown = document.getElementById('notification-dropdown');
            if (notifDropdown) notifDropdown.classList.remove('active');

            const disasterPopup = document.getElementById('disaster-popup');
            if (disasterPopup) disasterPopup.classList.remove('show');

            document.querySelectorAll('.searchable-select.open').forEach(ss => ss.classList.remove('open'));

            document.querySelectorAll('.modal.active, .modal-overlay.active').forEach(modal => {
                if (modal.id === 'global-loader') return;
                modal.classList.remove('active', 'show');
                if (modal.style.display !== 'none' && modal.style.display !== '') {
                    modal.style.display = 'none';
                }
            });

            document.body.classList.remove('mobile-blur-active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            checkActiveOverlays();

            // Targeted observer to avoid full body subtree layout thrashing
            const overlayObserver = new MutationObserver(function() {
                scheduleOverlayCheck();
            });

            const targetNav = document.getElementById('nav-links');
            const targetNotif = document.getElementById('notification-dropdown');
            const targetDisaster = document.getElementById('disaster-popup');

            if (targetNav) overlayObserver.observe(targetNav, { attributes: true, attributeFilter: ['class'] });
            if (targetNotif) overlayObserver.observe(targetNotif, { attributes: true, attributeFilter: ['class'] });
            if (targetDisaster) overlayObserver.observe(targetDisaster, { attributes: true, attributeFilter: ['class'] });
            overlayObserver.observe(document.body, { attributes: true, attributeFilter: ['class'] });

            window.addEventListener('resize', scheduleOverlayCheck, { passive: true });
        });
    </script>
    @yield('scripts')
</body>
</html>
