<?php

namespace App\Http\Resources\teacher;

use App\Models\Course;
use App\Http\Resources\course\CourseResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $courses = Course::where('academic_level_id',$user->academic_level_id)
                        ->where('stage_level_id' ,$user->stage_level_id)->where('admin_id',$this->id)->latest()->get();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'image'=> url($this->image),
            'department'=>  $this->department??'no department',
            'description' => $this->description,
            'courses' => CourseResources::collection($courses)

        ];
    }
}
