<?php

namespace TomatoPHP\TomatoSubscription\Http\Requests\PlanFeature;

use Illuminate\Foundation\Http\FormRequest;

class PlanFeatureStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name.ar' => 'required|max:255|string',
            'name.en' => 'required|max:255|string',
            'key' => 'required|max:255|string',
            'value' => 'nullable|max:255|string',
            'description.ar' => 'nullable|max:65535',
            'description.en' => 'nullable|max:65535',
            'extra' => 'nullable',
            'is_active' => 'nullable|boolean'
        ];
    }
}
