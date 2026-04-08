<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the broadcast authentication channels for
| your application. These channels are utilized to authenticate logged-in
| users to your private channels.
|
*/

// Authenticated channel for all users
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return $user->id === (int) $id;
});

// Tenant channel - users can only see their tenant's channel
Broadcast::channel('tenant.{tenantId}', function ($user, $tenantId) {
    return $user->tenant_id === (int) $tenantId;
});

// Admin channel - only super admins can access
Broadcast::channel('admin', function ($user) {
    return $user->hasRole('Super Admin');
});
