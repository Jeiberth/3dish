<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Dish extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'price',
        'calories',
        'spicy',
        'size',
        'image',
        'imageAR',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'price' => 'decimal:2',
        'spicy' => 'string',
        'size' => 'string',
    ];

    public function dishGroups()
    {
        return $this->belongsToMany(DishGroup::class, 'dish_dish_groups');
    }

    public function dietaries()
    {
        return $this->belongsToMany(Dietary::class, 'dish_dietaries');
    }

    public function allergens()
    {
        return $this->belongsToMany(Allergen::class, 'dish_allergens');
    }

    public function proteins()
    {
        return $this->belongsToMany(Protein::class, 'dish_proteins');
    }

    public function tasteProfiles()
    {
        return $this->belongsToMany(TasteProfile::class, 'dish_taste_profiles');
    }
}
