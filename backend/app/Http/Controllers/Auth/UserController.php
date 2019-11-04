<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserContract $userContract)
    {
        $this->userService =$userContract;
    }

    public function create() {

    }

    public function delete(int $id) {

    }
}
