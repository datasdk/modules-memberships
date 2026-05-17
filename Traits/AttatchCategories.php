<?php

namespace Modules\Memberships\Traits;


trait AttatchCategories {


    public function attachCategory($category = null){

        $categories_type = !empty($category) ? $category::class : null;
        $categories_id = !empty($category) ? $category->id : null;

        $this->update([
            "categories_id" => $categories_id
        ]);

        return $this;

    }

}