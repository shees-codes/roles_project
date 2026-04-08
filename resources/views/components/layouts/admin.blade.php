<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-indigo-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-xl font-bold">Admin Panel</a>
                        </div>
                        <div class="hidden sm:flex sm:ml-10 sm:space-x-8">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 @if(request()->routeIs('admin.users.*')) border-white @else border-transparent @endif text-sm font-medium hover:border-white">
                                Users
                            </a>
                            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 @if(request()->routeIs('admin.roles.*')) border-white @else border-transparent @endif text-sm font-medium hover:border-white">
                                Roles
                            </a>
                            <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 @if(request()->routeIs('admin.permissions.*')) border-white @else border-transparent @endif text-sm font-medium hover:border-white">
                                Permissions
                            </a>
                            <a href="{{ route('admin.tenants.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 @if(request()->routeIs('admin.tenants.*')) border-white @else border-transparent @endif text-sm font-medium hover:border-white">
                                Tenants
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-sm hover:text-gray-200 mr-4">Back to Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm hover:text-gray-200">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
