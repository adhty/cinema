<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Validation\Rule;

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
        // Logging buat debug
        \Log::info('Masuk ke store function', $request->all());

        // ✅ FIX: Hapus `$role->id` karena $role belum ada
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        // Buat role baru
        $role = Role::create(['name' => $request->name]);
        \Log::info('Role created', ['id' => $role->id]);

        // Simpan permissions (jika ada)
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

        \Log::info('Selesai simpan role');

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

        // ✅ FIX: validasi unique harus abaikan role yang sedang diedit
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
        ]);

        // Update nama role
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
        $role->permissions()->delete(); // ✅ Tambahkan ini biar relasi permissions juga hilang
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus!');
    }
}
