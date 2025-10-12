<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Tampilkan semua role.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Form tambah role baru.
     */
    public function create()
    {
        // Daftar menu untuk diatur hak aksesnya
        $menus = [
            'Dashboard',
            'Movies',
            'Studios',
            'Tickets',
            'Orders',
            'Promos',
            'Users',
            'Reports',
        ];

        return view('admin.roles.create', compact('menus'));
    }

    /**
     * Simpan role baru + permissions.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        // Buat role baru
        $role = Role::create([
            'name' => $request->name,
        ]);

        // Simpan permission tiap menu
        if ($request->has('permissions')) {
            foreach ($request->permissions as $menu => $perm) {
                Permission::create([
                    'role_id' => $role->id,
                    'menu_name' => $menu,
                    'can_view' => isset($perm['view']),
                    'can_create' => isset($perm['create']),
                    'can_update' => isset($perm['update']),
                    'can_delete' => isset($perm['delete']),
                    'can_approve' => isset($perm['approve']),
                ]);
            }
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan!');
    }

    /**
     * Form edit role.
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        $menus = [
            'Dashboard',
            'Movies',
            'Studios',
            'Tickets',
            'Orders',
            'Promos',
            'Users',
            'Reports',
        ];

        return view('admin.roles.edit', compact('role', 'menus'));
    }

    /**
     * Update data role.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        // Hapus permission lama
        $role->permissions()->delete();

        // Simpan ulang permission baru
        if ($request->has('permissions')) {
            foreach ($request->permissions as $menu => $perm) {
                $role->permissions()->create([
                    'menu_name' => $menu,
                    'can_view' => isset($perm['view']),
                    'can_create' => isset($perm['create']),
                    'can_update' => isset($perm['update']),
                    'can_delete' => isset($perm['delete']),
                    'can_approve' => isset($perm['approve']),
                ]);
            }
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui!');
    }

    /**
     * Hapus role.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus!');
    }
}
