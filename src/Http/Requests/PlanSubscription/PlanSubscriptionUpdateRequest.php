<?php

namespace TomatoPHP\TomatoSubscription\Http\Requests\PlanSubscription;

use Illuminate\Foundation\Http\FormRequest;

class PlanSubscriptionUpdateRequest extends FormRequest
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
            'model_id' => 'sometimes',
            'model_type' => 'sometimes',
            'plan_id' => 'sometimes',
            'status' => 'sometimes|string|max:255',
            'is_current' => 'sometimes|boolean'
        ];
    }
}
