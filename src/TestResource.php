<?php

namespace TomatoPHP\TomatoSubscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id
        ];
    }
}
