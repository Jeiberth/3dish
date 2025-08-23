<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDishGroupRequest;
use App\Models\DishGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DishGroupController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $dishGroup = DB::transaction(function () use ($request) {
                return DishGroup::create([
                    'user_id' => auth()->id(),
                    'name' => [
                        'en' => $request->input('name.en', ''),
                        'fr' => $request->input('name.fr', ''),
                        'es' => $request->input('name.es', ''),
                    ],
                    'order_number' => $request->order_number,
                ]);
            });

            return response()->json([
                'success' => true,
                'data' => $dishGroup->load('dishes'),
                'message' => 'Dish group created successfully.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create dish group: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $dishGroup = DB::transaction(function () use ($request) {
                $dishGroup = DishGroup::findOrFail($request->id);
                $dishGroup->update([
                    'name' => $request->name,
                    'order_number' => $request->order_number,
                ]);
                return $dishGroup;
            });

            return response()->json([
                'success' => true,
                'data' => $dishGroup->load('dishes'),
                'message' => 'Dish group updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update dish group: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function index(): JsonResponse
    {
        try {
            $query = auth()->user()->admin
                ? DishGroup::with(['dishes.dietaries', 'dishes.allergens', 'dishes.proteins', 'dishes.tasteProfiles'])
                    ->get()
                    ->groupBy('user_id')
                : auth()->user()->dishGroups()
                    ->with(['dishes.dietaries', 'dishes.allergens', 'dishes.proteins', 'dishes.tasteProfiles'])
                    ->get();

            return response()->json([
                'success' => true,
                'data' => $query,
                'message' => 'Dish groups retrieved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dish groups: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(DishGroup $dishGroup): JsonResponse
    {
        if (auth()->user()->id !== $dishGroup->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: You do not own this dish group.',
            ], 403);
        }

        try {
            $dishGroup->delete();
            return response()->json([
                'success' => true,
                'message' => 'Dish group deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete dish group: ' . $e->getMessage(),
            ], 500);
        }
    }
}
