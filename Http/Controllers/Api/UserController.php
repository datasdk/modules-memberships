<?php

namespace Modules\Memberships\Http\Controllers\Api;


use App\Http\Controllers\OrionBaseController;
use Orion\Http\Requests\Request;
use Modules\Crm\Http\Controllers\Api\UserController as OrigUserController;
use Modules\Memberships\Http\Resources\UserResource;

use Modules\Memberships\Models\User;
class UserController extends OrigUserController{


  protected $model = User::class;

  public $resource = UserResource::class;


 public $includes = [
    "memberships.plan"
  ];


}

