<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::latest()->get();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|in:1,2', // asumsi 1=admin, 2=member
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User added successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|in:1,2',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user, Request $request)
    {
        // Validasi konfirmasi
        $confirmationText = "saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya";
        if ($request->input('delete_confirmation') !== $confirmationText) {
            return redirect()->back()
                ->with('error', 'Konfirmasi penghapusan salah. Harap ketik kalimat dengan benar.');
        }
        // Ambil semua loans lewat receipts
        foreach ($user->receipts as $receipt) {
            $receipt->update(['status' => 'cancelled']);
            foreach ($receipt->loans as $loan) {
                // dd($loan->status);
                // Kalau status masih borrowed, balikin jadi available
                if ($loan->bookItem) {
                    $loan->bookItem->update(['status' => 'available']);
                }
                // Bebas, mau delete loan atau biarin
                $loan->update(['status'=> 'cancelled']);
            }
        }

        // Hapus user (user_id di receipts otomatis jadi NULL karena set null)
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

}
