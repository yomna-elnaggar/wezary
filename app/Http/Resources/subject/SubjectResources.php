<?php

namespace App\Http\Resources\subject;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResources extends JsonResource
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

        $isAttached = $user && $user->courses()->where('id', $this->course->id)->exists();

        $status = $isAttached ? 'free' : $this->status;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
            'm' => $this->totale_min,
            's' => $this->totale_sec ? $this->totale_sec : 0,
            'description' => $this->description,
            'status' => $status,
            'drive_link' => $this->drive_link,
            'department' => $this->course->department->name
        ];
    }
}
