<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        // 1️⃣ Buat role baru
        $role = Role::create(['name' => $request->name]);

        // 2️⃣ Simpan permission tiap menu
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

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan!');
    }

    public function edit($id)
{
    $role = Role::with('permissions')->findOrFail($id);

    // daftar menu (harus sama kayak waktu create)
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

public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
    ]);

    // Update nama role
    $role->update(['name' => $request->name]);

    // Hapus permission lama
    $role->permissions()->delete();

    // Simpan ulang permission baru
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

    return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui!');
}

}
