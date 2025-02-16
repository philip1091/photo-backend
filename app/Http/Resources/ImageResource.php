<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'hide' => $this->hide,
            'categories' => ImageCategoryResource::collection($this->imageCategory),
            'pages' => ImagePageResource::collection($this->sitePage),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
