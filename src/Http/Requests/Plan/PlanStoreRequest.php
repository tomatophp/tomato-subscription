<?php

namespace TomatoPHP\TomatoSubscription\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class PlanStoreRequest extends FormRequest
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
            'description.ar' => 'nullable|max:65535',
            'description.en' => 'nullable|max:65535',
            'order' => 'nullable',
            'price' => 'required',
            'invoice_period' => 'required',
            'invoice_interval' => 'required|string',
            'is_recurring' => 'nullable',
            'is_active' => 'nullable',
            'is_free' => 'nullable',
            'is_default' => 'nullable'
        ];
    }
}
