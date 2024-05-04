<?php

namespace App\Http\Resources\course;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseRecentlyResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
   
        $user = $request->user();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'images' => url($this->image),
            'duration' => $this->duration ? $this->duration : 0, 
            'department' => $this->department ? $this->department->name : null,
            'description' => $this->description,
            'teacher' => $this->teacher ? $this->teacher->name : null,
            'is_favorite' => $user ? $this->favoritedBy->contains($user) : false,
            'percentage' => $this->percentage ? $this->percentage : 0, 
        ];
    }
}
