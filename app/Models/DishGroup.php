<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DishGroup extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
    ];

    public $translatable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_dish_groups');
    }
}
