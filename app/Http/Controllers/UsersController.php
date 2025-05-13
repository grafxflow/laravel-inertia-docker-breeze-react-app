<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    /**
     * Display the active users.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Users/Index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Edit the user account.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => User::find($request->user),
        ]);
    }

    /**
     * Update the user information.
     */
    public function update(UserUpdateRequest $request): RedirectResponse
    {
        // Removes password field if it's null
        if ( ! $request->password) {
            unset($request['password']);
        }

        // Update the User details
        User::find($request->user)->update($request->all());

        // Redirect to the User Index page
        return Redirect::route('users.index');
    }

    /**
     * Delete the user account.
     */
    public function delete(Request $request): RedirectResponse
    {
        User::find($request->user)->delete();

        return Redirect::route('users.index');
    }

    /**
     * Create the user account.
     */
    public function create(): Response
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store the user account.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        // Store the User details
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('users.index');
    }
}
