<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductsResource extends JsonResource
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
          "name" => $this->name,
          "price" => $this->price,
          "desc" => $this->desc,
          "image" => $this->image,
          "seller_id" => $this->seller->id,
          // "created_at" => $this->created_at,
          // "updated_at" =>$this->updated_at,

        ];

    }
}
