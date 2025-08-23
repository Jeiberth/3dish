<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DishGroup;
use App\Models\Dish;
use App\Models\Dietary;
use App\Models\Allergen;
use App\Models\Protein;
use App\Models\TasteProfile;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Users
        $users = User::factory()->count(5)->create();
        $admin = User::factory()->create([
            'admin' => true,
        ]);

        // Seed Dietaries, Allergens, Proteins, and TasteProfiles
        $dietaries = Dietary::factory()->count(7)->create();
        $allergens = Allergen::factory()->count(6)->create();
        $proteins = Protein::factory()->count(6)->create();
        $tasteProfiles = TasteProfile::factory()->count(6)->create();

        // Seed DishGroups and Dishes for each user
        $users->each(function ($user) use ($dietaries, $allergens, $proteins, $tasteProfiles) {
            $dishGroups = DishGroup::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);

            $dishGroups->each(function ($dishGroup) use ($dietaries, $allergens, $proteins, $tasteProfiles) {
                $dishes = Dish::factory()->count(5)->create();

                $dishes->each(function ($dish) use ($dishGroup, $dietaries, $allergens, $proteins, $tasteProfiles) {
                    // Attach dish to dish group
                    $dish->dishGroups()->attach($dishGroup->id);

                    // Attach random dietaries (1 to 3)
                    $dish->dietaries()->attach(
                        $dietaries->random(rand(1, 3))->pluck('id')
                    );

                    // Attach random allergens (0 to 2)
                    $dish->allergens()->attach(
                        $allergens->random(rand(0, 2))->pluck('id')
                    );

                    // Attach random proteins (1 to 2)
                    $dish->proteins()->attach(
                        $proteins->random(rand(1, 2))->pluck('id')
                    );

                    // Attach random taste profiles (1 to 3)
                    $dish->tasteProfiles()->attach(
                        $tasteProfiles->random(rand(1, 3))->pluck('id')
                    );
                });
            });
        });
    }
}
