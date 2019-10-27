<?php

namespace App\Http\Controllers;

use App\Contracts\MessageContract;
use App\Dto\CreateMessage;
use App\Http\Requests\MessageRequest;
use App\Jobs\NotifyUser;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $messageService;

    public function __construct(MessageContract $messageService)
    {
        $this->messageService = $messageService;
    }

    public function getMessages(int $page, int $perPage)
    {
        return response()->json([
            'messages' => $this->messageService->getMessages($page, $perPage)
        ]);
    }

    public function getMessage(int $id)
    {
        try {
            return response()->json(['message' => $this->messageService->getMessage($id)]);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Message was not found'], 404);
        }
    }

    public function create(MessageRequest $request)
    {
        try {
            $createMessage = new CreateMessage($request->validated());
            $message = $this->messageService->createMessage($request->user(), $request->input('applicationId'), $createMessage);
            NotifyUser::dispatch($message)
                ->onQueue('notifications')
                ->delay(now()->addSeconds(10));

            return response()->json($message, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            return response()->json(['deleted' => $this->messageService->deleteMessage($id)]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error while deleting message'], 500);
        }
    }
}
