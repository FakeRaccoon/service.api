<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Form extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => $this->customer,
            'item' => $this->item,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
