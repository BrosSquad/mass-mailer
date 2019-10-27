<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract;
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
}
