<?php

namespace App\Domains\Plot\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'address' => $this->address,
            'price' => $this->price,
            'area' => $this->area,
        ];;
    }
}
