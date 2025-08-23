<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;
use App\Models\Dish;
use App\Models\DishGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DishController extends Controller
{

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Create the dish
            $dish = Dish::create([
                'name' => [
                    'en' => $request->input('name.en'),
                    'fr' => $request->input('name.fr'),
                    'es' => $request->input('name.es'),
                ],
                'description' => [
                    'en' => $request->input('description.en'),
                    'fr' => $request->input('description.fr'),
                    'es' => $request->input('description.es'),
                ],
                'price' => $request->input('price'),
                'calories' => $request->input('calories'),
                'spicy' => $request->input('spicy'),
                'size' => $request->input('size'),
                'image' => $request->input('image'),
                'imageAR' => $request->input('imageAR'),
            ]);

            // Attach dish group
            if ($request->has('dish_group_id')) {
                $dish->dishGroups()->attach($request->input('dish_group_id'));
            }

            // Attach dietaries
            if ($request->has('dietaries')) {
                $dietaryIds = collect($request->input('dietaries'))->pluck('id')->toArray();
                $dish->dietaries()->sync($dietaryIds);
            }

            // Attach allergens
            if ($request->has('allergens')) {
                $allergenIds = collect($request->input('allergens'))->pluck('id')->toArray();
                $dish->allergens()->sync($allergenIds);
            }

            // Attach proteins
            if ($request->has('proteins')) {
                $proteinIds = collect($request->input('proteins'))->pluck('id')->toArray();
                $dish->proteins()->sync($proteinIds);
            }

            // Attach taste profiles
            if ($request->has('tasteProfiles')) {
                $tasteProfileIds = collect($request->input('tasteProfiles'))->pluck('id')->toArray();
                $dish->tasteProfiles()->sync($tasteProfileIds);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $dish->load([ 'dietaries', 'allergens', 'proteins', 'tasteProfiles']),
                'message' => 'Dish created successfully'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create dish',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $dish = Dish::findOrFail($id);

            // Update dish attributes
            $dish->update([
                'name' => [
                    'en' => $request->input('name.en', $dish->getTranslation('name', 'en')),
                    'fr' => $request->input('name.fr', $dish->getTranslation('name', 'fr')),
                    'es' => $request->input('name.es', $dish->getTranslation('name', 'es')),
                ],
                'description' => [
                    'en' => $request->input('description.en', $dish->getTranslation('description', 'en')),
                    'fr' => $request->input('description.fr', $dish->getTranslation('description', 'fr')),
                    'es' => $request->input('description.es', $dish->getTranslation('description', 'es')),
                ],
                'price' => $request->input('price', $dish->price),
                'calories' => $request->input('calories', $dish->calories),
                'spicy' => $request->input('spicy', $dish->spicy),
                'size' => $request->input('size', $dish->size),
                'image' => $request->input('image', $dish->image),
                'imageAR' => $request->input('imageAR', $dish->imageAR),
            ]);

            // Update dish group
            if ($request->has('pivot.dish_group_id')) {
                $dish->dishGroups()->sync([$request->input('pivot.dish_group_id')]);
            }

            // Update dietaries
            if ($request->has('dietaries')) {
                $dietaryIds = collect($request->input('dietaries'))->pluck('id')->toArray();
                $dish->dietaries()->sync($dietaryIds);
            }

            // Update allergens
            if ($request->has('allergens')) {
                $allergenIds = collect($request->input('allergens'))->pluck('id')->toArray();
                $dish->allergens()->sync($allergenIds);
            }

            // Update proteins
            if ($request->has('proteins')) {
                $proteinIds = collect($request->input('proteins'))->pluck('id')->toArray();
                $dish->proteins()->sync($proteinIds);
            }

            // Update taste profiles
            if ($request->has('tasteProfiles')) {
                $tasteProfileIds = collect($request->input('tasteProfiles'))->pluck('id')->toArray();
                $dish->tasteProfiles()->sync($tasteProfileIds);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $dish->load(['dishGroups', 'dietaries', 'allergens', 'proteins', 'tasteProfiles']),
                'message' => 'Dish updated successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update dish',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Dish $dish): JsonResponse
    {
        $dishGroup = $dish->dishGroups()->first();
        if (!$dishGroup || auth()->user()->id !== $dishGroup->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: You do not own this dish.',
            ], 403);
        }

        try {
            $dish->delete();
            return response()->json([
                'success' => true,
                'message' => 'Dish deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete dish: ' . $e->getMessage(),
            ], 500);
        }
    }
}
