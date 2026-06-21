<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => new User(['role' => 'customer', 'is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validated($request, $user);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'You cannot delete your own account.');

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'phone' => ['nullable', 'string', 'max:40'],
            'role' => ['required', Rule::in(['admin', 'customer'])],
            'locale' => ['required', Rule::in(['ar', 'en'])],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => false];
    }
}
