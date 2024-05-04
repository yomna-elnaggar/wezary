<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           
            'name' => $this->name,
          	'grade' =>$this->grade,
            'image' => url($this->image),
            'teacher_name'=>$this->teacher_name,
          	'course_name'=>$this->course_name,
        ];
    }
}
