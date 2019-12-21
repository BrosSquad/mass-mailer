<?php

namespace App\Http\Controllers;

use Throwable;
use App\Dto\CreateMessage;
use App\Exceptions\MjmlException;
use App\Http\Requests\MessageRequest;
use App\Contracts\Message\MessageContract;

class MessageController extends Controller
{
    private MessageContract $messageService;

    public function __construct(MessageContract $messageService)
    {
        $this->messageService = $messageService;
    }

    public function createMessage(int $applicationId, MessageRequest $request)
    {
        $createMessage = new CreateMessage($request->validated());
        try {
            $message = $this->messageService->createNewMessage($createMessage, $applicationId, $request->user());
            return created($message);
        } catch (MjmlException $e) {
            return badRequest(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        } catch (Throwable $e) {
            return internalServerError($e);
        }
    }
}
