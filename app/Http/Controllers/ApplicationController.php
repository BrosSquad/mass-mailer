<?php

namespace App\Http\Controllers;

use App\Contracts\ApplicationContract;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationContract $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getAppllications()
    {

    }

    public function getAppllication(int $id)
    {

    }

    public function create()
    {

    }

    public function update(int $id)
    {

    }

    public function delete(int $id)
    {

    }

}
