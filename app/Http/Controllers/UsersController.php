<?php

namespace App\Http\Controllers;

use App\Models\users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|min:3|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Create user
            $user = users::create([
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'name' => $request->input('name'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Mail::raw('Your account has been successfully created.', function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Account Creation Confirmation');
            });

            $adminEmail = config('mail.admin_email', 'oviekshagya51@gmail.com'); // Change as needed
            Mail::raw("A new user has been created:\n\nEmail: {$user->email}\nName: {$user->name}", function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                        ->subject('New User Notification');
            });

            // Return response
            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'created_at' => $user->created_at->toIso8601String(),
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the user.' . $e->getMessage()], 400);
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'created_at');

        $users = users::where('active', true);

        if ($search) {
            $users = $users->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $users->orderBy($sortBy, 'desc')
                       ->paginate($perPage);

        $users->getCollection()->transform(function($user) {
            $user->orders_count = $user->orders()->count();
            return $user;
        });

        // Return response
        return response()->json([
            'page' => $users->currentPage(),
            'users' => $users->items(),
        ]);
    }
}
