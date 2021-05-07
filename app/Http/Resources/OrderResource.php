<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id ,
          'number' => $this->id,
          'product_count' => $this->product()->get(),
          ///  'product_count' => $this->product()->count(),
        ];
    }
}
