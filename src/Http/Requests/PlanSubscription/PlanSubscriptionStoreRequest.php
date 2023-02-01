<?php

namespace TomatoPHP\TomatoSubscription\Http\Requests\PlanSubscription;

use Illuminate\Foundation\Http\FormRequest;

class PlanSubscriptionStoreRequest extends FormRequest
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
            'model_id' => 'required',
            'model_type' => 'required',
            'plan_id' => 'required',
            'status' => 'required|string|max:255',
            'is_current' => 'required|boolean'
        ];
    }
}
