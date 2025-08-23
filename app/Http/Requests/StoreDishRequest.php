<?php

namespace App\Http\Requests;

use App\Models\DishGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDishRequest extends FormRequest
{
    public function authorize(): bool
    {
        $dishGroup = DishGroup::find($this->input('dish_group_id'));
        return $dishGroup && auth()->user()->id === $dishGroup->user_id;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'calories' => ['nullable', 'integer', 'min:0'],
            'spicy' => ['nullable', Rule::in(['Not Spicy', 'Medium', 'Extra Hot'])],
            'size' => ['nullable', Rule::in(['Small', 'Medium', 'Large'])],
            'image' => ['nullable', 'string', 'max:255'],
            'imageAR' => ['nullable', 'string', 'max:255'],
            'dish_group_id' => ['required', 'exists:dish_groups,id'],
            'dietaries' => ['nullable', 'array'],
            'dietaries.*' => ['exists:dietaries,id'],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['exists:allergens,id'],
            'proteins' => ['nullable', 'array'],
            'proteins.*' => ['exists:proteins,id'],
            'taste_profiles' => ['nullable', 'array'],
            'taste_profiles.*' => ['exists:taste_profiles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'dish_group_id.exists' => 'The selected dish group does not exist.',
            'dietaries.*.exists' => 'One or more dietaries are invalid.',
            'allergens.*.exists' => 'One or more allergens are invalid.',
            'proteins.*.exists' => 'One or more proteins are invalid.',
            'taste_profiles.*.exists' => 'One or more taste profiles are invalid.',
        ];
    }
}
