[← Back to README](README.md) | [Next: Process Workflow →](2_Process_Workflow.md)

# Project Overview: Preparedness, Safety & Continuity Portal (PSCP): Workforce Locator

## Introduction
The Preparedness, Safety & Continuity Portal: Workforce Locator is a premium, real-time monitoring platform built with Laravel. It integrates precise employee location tracking with live disaster data to ensure workforce safety and operational resilience.

## Purpose
The primary goal of this system is to provide a unified command center that synchronizes personnel locations with environmental hazards. It enables administrators to monitor field activity, assess risks from natural disasters (earthquakes, volcanoes), and manage the workforce through a high-performance, interactive interface.

## Key Features
- **Unified Command Center**: A centralized dashboard featuring an interactive map (Leaflet.js) that plots real-time employee locations alongside active disaster data.
- **Live Disaster Tracking**: Integration with global hazard APIs (USGS for Earthquakes, NASA for Natural Events) to visualize real-time risks.
- **Geospatial Hazard Layers**: Specialized map layers for active faults, volcano locations, and KMZ/KML environmental data.
- **Workforce Geography**: Dedicated visualization for office vs. home-based distribution with synchronized data lists and map highlighting.
- **Real-time Location Reporting**: Streamlined, mobile-responsive dashboard for staff to submit GPS coordinates with automatic reverse-geocoding.
- **Historical Movement Auditing**: Comprehensive logs for each employee, featuring movement patterns, device telemetry, and address history.
- **Performance-First Design**: Skeleton loaders, optimized database queries, and throttled API endpoints for a near-instantaneous user experience.

## Target Audience
- **Field & Office Staff**: For effortless location reporting and hazard awareness.
- **Security & Logistics Managers**: For real-time monitoring, risk assessment, and personnel safety compliance.

## Technical Foundation
Built on **Laravel 12** and **PHP 8.2+**, the system leverages modern web technologies including **Tailwind CSS v4**, **Chart.js**, and **Leaflet.js** to deliver a robust, scalable, and premium experience across all devices.
