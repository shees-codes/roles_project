@php

    $user = auth()->user();
    $roles = $user->getRoleNames();
    $permissions = $user->getPermissionNames();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-indigo-600">{{ config('app.name', 'Laravel') }}</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center">
                                <span class="mr-4 text-sm text-gray-700">{{ $user->name }}</span>
                                @if($roles->count() > 0)
                                    <span class="mr-4 px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded-full">
                                        {{ $roles->first() }}
                                    </span>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                                </form>
                            </div>
                        </div>
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

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-2xl font-bold mb-4">Welcome to Your Dashboard</h2>
                        <p class="text-gray-600 mb-6">You are logged in as <strong>{{ $user->email }}</strong></p>

                        @if($roles->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Your Roles:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($roles as $role)
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">{{ $role }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($permissions->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Your Permissions:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($permissions as $permission)
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">{{ $permission }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <h4 class="font-semibold text-lg mb-2">Quick Actions</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:text-indigo-800">Edit Profile</a></li>
                                </ul>
                            </div>


                            @can('access admin panel')
                            <div class="bg-green-50 p-6 rounded-lg">
                                <h4 class="font-semibold text-lg mb-2">Admin Panel</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="{{ route('admin.users.index') }}" class="text-green-600 hover:text-green-800">Manage Users</a></li>
                                    <li><a href="{{ route('admin.roles.index') }}" class="text-green-600 hover:text-green-800">Manage Roles</a></li>
                                    <li><a href="{{ route('admin.permissions.index') }}" class="text-green-600 hover:text-green-800">Manage Permissions</a></li>
                                    <li><a href="{{ route('admin.tenants.index') }}" class="text-green-600 hover:text-green-800">Manage Tenants</a></li>
                                </ul>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
