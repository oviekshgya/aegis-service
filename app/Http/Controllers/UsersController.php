<?php

namespace App\Http\Controllers;

use App\Models\users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

/**
    * @OA\Info(
    *      version="1.0.0",
    *      title="Dokumentasi API Aegis Service",
    *      description="Oviek Shagya",
    *      @OA\Contact(
    *          email="oviekshagya51@gmail.com"
    *      )
    * )
    *
    * @OA\Server(
    *      url=L5_SWAGGER_CONST_HOST,
    *      description="Demo API Aegis Service"
    * )
    */
class UsersController extends Controller
{
 /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password", "name"},
     *             @OA\Property(property="email", type="string", example="aadadaa@gmail.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="name", type="string", example="New User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=17),
     *             @OA\Property(property="email", type="string", example="aadadaa@gmail.com"),
     *             @OA\Property(property="name", type="string", example="New User"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-18T19:15:35+00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Bad Request")
     *         )
     *     )
     * )
     */
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

            // Mail::raw('Your account has been successfully created.', function ($message) use ($user) {
            //     $message->to($user->email)
            //             ->subject('Account Creation Confirmation');
            // });

            Mail::to($user->email)->send(new \App\Mail\UserCreatedMail($user));

            $adminEmail = config('mail.admin_email', 'oviekshagya51@gmail.com'); // Change as needed
            // Mail::raw("A new user has been created:\n\nEmail: {$user->email}\nName: {$user->name}", function ($message) use ($adminEmail) {
            //     $message->to($adminEmail)
            //             ->subject('New User Notification');
            // });
            Mail::to('oviekshagya51@gmail.com')->send(new \App\Mail\AdminNotificationMail($user));

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

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get list of users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="page", type="integer", example=1),
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=16),
     *                     @OA\Property(property="email", type="string", example="sasarnnda2106@gmail.com"),
     *                     @OA\Property(property="name", type="string", example="New User"),
     *                     @OA\Property(property="active", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-18T18:30:42.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-18T18:30:42.000000Z"),
     *                     @OA\Property(property="orders_count", type="integer", example=0)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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
