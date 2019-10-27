<?php

namespace App\Http\Controllers;

use App\Contracts\MessageContract;
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

    }

    public function create(int $applicationId, Request $request)
    {
        try {
            $createMessage = $request->validated();
            $message = $this->messageService->createMessage($request->user(), $applicationId, $createMessage);
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
