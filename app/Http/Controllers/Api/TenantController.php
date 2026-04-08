<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Display a listing of tenants
     */
    public function index(Request $request): JsonResponse
    {
        $tenants = Tenant::with('users')
            ->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%');
            })
            ->when($request->is_active !== null, function ($query) use ($request) {
                return $query->where('is_active', $request->boolean('is_active'));
            })
            ->paginate($request->per_page ?? 15);

        return response()->json($tenants);
    }

    /**
     * Store a newly created tenant
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:tenants,slug'],
            'domain' => ['nullable', 'string', 'max:255', 'unique:tenants,domain'],
            'is_active' => ['boolean'],
        ]);

        $tenant = Tenant::create($validated);

        return response()->json([
            'message' => 'Tenant created successfully',
            'tenant' => $tenant,
        ], 201);
    }

    /**
     * Display the specified tenant
     */
    public function show(Tenant $tenant): JsonResponse
    {
        $tenant->load('users');

        return response()->json([
            'tenant' => $tenant,
        ]);
    }

    /**
     * Update the specified tenant
     */
    public function update(Request $request, Tenant $tenant): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'domain' => ['nullable', 'string', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'is_active' => ['boolean'],
        ]);

        $tenant->update($validated);

        return response()->json([
            'message' => 'Tenant updated successfully',
            'tenant' => $tenant,
        ]);
    }

    /**
     * Remove the specified tenant
     */
    public function destroy(Tenant $tenant): JsonResponse
    {
        if ($tenant->users()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete tenant with existing users',
            ], 403);
        }

        $tenant->delete();

        return response()->json([
            'message' => 'Tenant deleted successfully',
        ]);
    }

    /**
     * Get tenant's users
     */
    public function users(Tenant $tenant): JsonResponse
    {
        $users = $tenant->users()->with('roles')->get();

        return response()->json([
            'users' => $users,
        ]);
    }
}
