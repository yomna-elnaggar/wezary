<?php

namespace App\Http\Resources\teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {     $user = $request->user();
            return [
            'id'=>$this->id,
            'name'=>$this->name,
            'image'=> url($this->image),
            'department'=>  $this->department??'no department',
        ];
    }
}
