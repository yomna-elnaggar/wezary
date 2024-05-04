<?php

namespace App\Http\Resources\course;

use App\Http\Resources\subject\SubjectResources;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetilsResources extends JsonResource
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
        $totalMinutes = $this->subjects ? $this->subjects->sum('totale_min') : 0;
        $totalSeconds = $this->subjects ? $this->subjects->sum('totale_sec') : 0;
        $totalMinutes += round($totalSeconds / 60);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
      	
      

        return [
            'id' => $this->id,
            'name' => $this->name,
            'images' => url($this->image),
            'duration' => $totalMinutes > 0 ? $hours . 'h' . $minutes . 'm' : 0 . 'h' . 0 . 'm',
            'description'=> $this->description,
            'department'=> $this->department?$this->department->name :null,
            'teacher' => $this->teacher?$this->teacher->id :null,
            'subjects' => SubjectResources::collection($this->whenLoaded('subjects')),
        ];
    }
}
