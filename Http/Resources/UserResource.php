<?php

namespace Modules\Memberships\Http\Resources;

use App\Models\User as BasicUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\BaseResource;


class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($req)
    {
        
        $resource = $this->resource;

        $res = $this->translateResource($resource,$req);

        $hasplans = $this->memberships->map(fn($membership) => $membership->plan)->pluck("name");


        return array_merge(
            $res->toArray(),
            [ 
                "hasPlans" => $hasplans
            ]
        );


    }


 

}
