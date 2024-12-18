@extends('structures.main')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>


    </ol>
    <div id="notification">
        @php
            // Retrieve the notification from the cache
            $notification = Cache::get('subscription_notification_' . auth()->user()->id);
        @endphp

        @if ($notification && auth()->check() && auth()->user()->role->name !== 'superadmin')
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="subscription-notification">
                <button type="button" class="btn-close" id="close-notification-btn" aria-label="Close"></button>
                {{ $notification }}
            </div>
        @endif
    </div>

    {{-- <div class="container m-4 border-1">
        <div class="text-end">
            <button id="createSiteButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#siteCreationModal">
                Add New Site
            </button>

            @if (auth()->check() && auth()->user()->role->name == 'user')
                <a href="renew-plans" class="btn payment mb-3" id="renewplanButton"><i class="bi bi-lock"></i> Renew
                    Plan</a>
            @endif
        </div>
    </div> --}}






    @if (auth()->check())
        @if (auth()->user()->role->name === 'superadmin')
            <x-admin-card />
        @else
            <x-user-card />
        @endif
    @endif








    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


    <style>
        /* Custom scrollbar styles for all containers */
        #pluginCategoriesContainer::-webkit-scrollbar,
        #pluginList::-webkit-scrollbar,
        #selectedPluginsContainer::-webkit-scrollbar,
        #all-categories::-webkit-scrollbar {
            width: 3px;
            height: 8px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-track,
        #pluginList::-webkit-scrollbar-track,
        #selectedPluginsContainer::-webkit-scrollbar-track,
        #all-categories::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-thumb,
        #pluginList::-webkit-scrollbar-thumb,
        #selectedPluginsContainer::-webkit-scrollbar-thumb,
        #all-categories::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-thumb:hover,
        #pluginList::-webkit-scrollbar-thumb:hover,
        #selectedPluginsContainer::-webkit-scrollbar-thumb:hover,
        #all-categories::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .icon-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .icon-container i {
            font-size: 40px;
            color: #28a745;
        }
    </style>
@endsection
