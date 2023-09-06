<?php

namespace TomatoPHP\TomatoSubscription\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
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
            'name.ar' => 'sometimes|max:255|string',
            'name.en' => 'sometimes|max:255|string',
            'description.ar' => 'nullable|max:65535',
            'description.en' => 'nullable|max:65535',
            'order' => 'nullable|numeric',
            'price' => 'sometimes|numeric',
            'invoice_period' => 'sometimes|numeric',
            'invoice_interval' => 'sometimes|string',
            'is_recurring' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
            'is_default' => 'nullable|boolean'
        ];
    }
}
