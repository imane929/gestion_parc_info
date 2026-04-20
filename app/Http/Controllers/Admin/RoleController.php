<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User as Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $permissions = Permission::all()->groupBy(function($permission) {
            // Grouper par module (premier mot avant le point)
            $parts = explode('.', $permission->code);
            return $parts[0] ?? 'autres';
        });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'code' => 'required|string|max:50|unique:roles,code',
            'libelle' => 'required|string|max:100',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'libelle' => $validated['libelle'],
                'description' => $validated['description'],
                'guard_name' => 'web',
            ]);

            if (!empty($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            }

            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Rôle créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du rôle.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        $role->load(['permissions', 'utilisateurs']);
        $permissionsGrouped = $role->permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->code);
            return $parts[0] ?? 'autres';
        });

        return view('admin.roles.show', compact('role', 'permissionsGrouped'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->code);
            return $parts[0] ?? 'autres';
        });

        $role->load('permissions');

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        // Empêcher la modification du rôle admin
        if ($role->code === 'admin' && !auth()->user()->hasRoleByCode('admin')) {
            abort(403, 'Vous ne pouvez pas modifier le rôle administrateur.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'code' => 'required|string|max:50|unique:roles,code,' . $role->id,
            'libelle' => 'required|string|max:100',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();
        try {
            $role->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'libelle' => $validated['libelle'],
                'description' => $validated['description'],
            ]);

            $role->permissions()->sync($validated['permissions'] ?? []);

            DB::commit();

            return redirect()->route('admin.roles.show', $role)
                ->with('success', 'Rôle mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour du rôle.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        // Empêcher la suppression du rôle admin
        if ($role->code === 'admin') {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer le rôle administrateur.');
        }

        // Vérifier si des utilisateurs ont ce rôle
        if ($role->utilisateurs()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer le rôle car des utilisateurs l\'utilisent.');
        }

        try {
            $role->delete();
            return redirect()->route('admin.roles.index')
                ->with('success', 'Rôle supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du rôle.');
        }
    }

    /**
     * Afficher les permissions
     */
    public function permissions()
    {
        $this->authorize('viewAny', Permission::class);

        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->code);
            return $parts[0] ?? 'autres';
        });

        return view('admin.roles.permissions', compact('permissions'));
    }

    /**
     * Synchroniser les permissions d'un rôle avec un utilisateur
     */
    public function syncUserPermissions(Request $request, Utilisateur $utilisateur)
    {
        $this->authorize('assignPermissions', Role::class);

        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();
        try {
            // Synchroniser les rôles
            if (isset($validated['roles'])) {
                $utilisateur->roles()->sync($validated['roles']);
            }

            // Synchroniser les permissions directes
            if (isset($validated['permissions'])) {
                $utilisateur->permissions()->sync($validated['permissions']);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Permissions mises à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour des permissions.');
        }
    }

    /**
     * Afficher le formulaire d'assignation des permissions
     */
    public function assignPermissions(Utilisateur $utilisateur)
    {
        $this->authorize('assignPermissions', Role::class);

        $utilisateur->load(['roles', 'permissions']);
        
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->code);
            return $parts[0] ?? 'autres';
        });

        return view('admin.roles.assign-permissions', compact('utilisateur', 'roles', 'permissions'));
    }
}