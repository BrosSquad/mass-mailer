<?php

namespace App\Http\Controllers;

use App\Exceptions\MjmlException;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\MessageRequest;
use App\Contracts\Message\MessageContract;

class MessageController extends Controller
{
    private MessageContract $messageService;

    public function __construct(MessageContract $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @throws \Throwable
     *
     * @param  \App\Http\Requests\MessageRequest  $request
     * @param  int  $applicationId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $applicationId, MessageRequest $request): ?JsonResponse
    {
        try {
            $message = $this->messageService->store($request->validated(), $applicationId, $request->user());
            return created($message);
        } catch (MjmlException $e) {
            return badRequest(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }
}
