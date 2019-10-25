<?php

namespace App\Http\Controllers;

use App\Contracts\MessageContract;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $messageService;

    public function __construct(MessageContract $messageService)
    {
        $this->messageService = $messageService;
    }

    public function getMessages()
    {

    }

    public function getMessage(int $id)
    {

    }

    public function create()
    {

    }
}
