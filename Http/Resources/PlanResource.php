<?php

namespace Modules\Memberships\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use DataSDK\Categories\Models\Categories;
use App\Http\Resources\BaseResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($req)
    {

        $includes = explode(",",$req->include);

        $language = $req->get("lang");

        $plan = $this;

        
        $categories = $this->features->pluck("categories_id")->toArray();

        if(!in_array("features",$includes)){ $this->offsetUnset("features"); }
      

        $root_id = optional(Categories::whereIn("id",$categories)->whereIsRoot()->first())->id;
        

        if($language && method_exists($this->resource,"translate")){
            
            $res =  $this->translate($language);          

        } else {

            $res = parent::toArray($req);

        }


     

        return  array_merge($res,[
            "category_id" => $root_id
        ]);
       

        
    }

}
