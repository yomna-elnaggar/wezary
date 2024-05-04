<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
             'academic_level_id' => $this->academic_level_id,
          	  'stage_level_id' => $this->stage_level_id,
              'icon' => url($this->icon),
              'created_at' => $this->created_at,
              'updated_at' => $this->updated_at,

       
        ];
    }
}
