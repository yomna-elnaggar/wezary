<?php

namespace App\Http\Resources\course;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $totalMinutes = $this->subjects ? $this->subjects->sum('totale_min') : 0;
        $totalSeconds = $this->subjects ? $this->subjects->sum('totale_sec') : 0;
        $totalMinutes += round($totalSeconds / 60);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $user = $request->user();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'images' => url($this->image),
            'duration' => $totalMinutes > 0 ? $hours . 'h' . $minutes . 'm' : 0 . 'h' . 0 . 'm',
            'department' => $this->department ? $this->department->name : null,
            'description' => $this->description,
            'teacher' => $this->teacher ? $this->teacher->name : null,
            'is_favorite' => $user ? $this->favoritedBy->contains($user) : false,
            'percentage' => $this->percentage ? $this->percentage : 0, 
        ];
    }
}
