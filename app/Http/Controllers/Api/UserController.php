<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {

            $randomPassword = Str::random(12); // Generate a 12-character random password

            $user = DB::transaction(function () use ($request, $randomPassword) {
                return User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($randomPassword),
                    'contract_starts_at' => $request->contract_starts_at,
                    'can_access' => $request->can_access ?? false,
                    'admin' => $request->admin ?? false,
                    'address' => $request->address,
                    'amount' => $request->amount,
                ]);
            });

            Mail::to($user->email)->send(new UserCreatedMail($user, $randomPassword));

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => $randomPassword,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $users = User::all();
            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Users retrieved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            $user = DB::transaction(function () use ($request, $user) {
                $data = $request->only([
                    'email', 'contract_starts_at', 'can_access', 'admin', 'address', 'amount'
                ]);
                if ($request->password) {
                    $data['password'] = Hash::make($request->password);
                }
                $user->update($data);
                return $user;
            });

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage(),
            ], 500);
        }
    }
}
