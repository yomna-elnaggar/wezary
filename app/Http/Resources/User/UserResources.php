<?php
namespace App\Http\Resources\User;

use App\Models\Country;
use App\Models\Government;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $user = $this->resource;
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone_number' =>  $user->phone_number,
            'parent_phone' =>  $user->parent_phone,
            'special_code' =>  $user->special_code,
            'pic_identityF' => url( $user->pic_identityF),
            'pic_identityB' =>  url($user->pic_identityB),
            'gender' =>  $user->gender??'no gender',
            'birth_date' =>  $user->birth_date??'no gender',
            'image' =>  url($user->image),
            'academicLevel' =>  $this->academicLevel?$this->academicLevel->name :'no academicLevel',
          	'academicLevel_id' =>  $this->academicLevel?$this->academicLevel->id :'no academicLevel',
            'stageLevel' => $this->stageLevel?$this->stageLevel->name :'no stageLevel',
          	'stageLevel_id' => $this->stageLevel?$this->stageLevel->id :'no stageLevel',
        ];
    }
}

