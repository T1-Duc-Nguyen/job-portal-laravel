<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Conversation;
use App\Models\Employer;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\NewMessageNotification;
use Illuminate\Support\Facades\Log;
use App\Events\ChatListUpdated;

class ChatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHAT PAGE
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | GET CONVERSATIONS
        |--------------------------------------------------------------------------
        */

        if ($user->role == 1) {

            $candidate = Candidate::where(
                'user_id',
                $user->id
            )->first();

            $conversations = Conversation::where(
                'candidate_id',
                $candidate?->id
            )
                ->latest('updated_at')
                ->get();

        } else {

            $employer = Employer::where(
                'user_id',
                $user->id
            )->first();

            $conversations = Conversation::where(
                'employer_id',
                $employer?->id
            )
                ->latest('updated_at')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | SELECTED CONVERSATION
        |--------------------------------------------------------------------------
        */

        $selectedConversation = null;

        if ($request->conversation) {

            $selectedConversation =
                Conversation::find(
                    $request->conversation
                );
        }

        return view(
            'chat.index',
            compact(
                'conversations',
                'selectedConversation'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | OPEN CHAT
    |--------------------------------------------------------------------------
    */

    public function open($userId)
    {
        $candidate = Candidate::where(
            'user_id',
            Auth::id()
        )->first();

        $employer = Employer::where(
            'user_id',
            $userId
        )->first();

        if (! $candidate || ! $employer) {

            abort(404);

        }

        $conversation =
            Conversation::firstOrCreate(

                [
                    'candidate_id' => $candidate->id,

                    'employer_id' => $employer->id,
                ]

            );

        return redirect(

            '/chat?conversation='.
            $conversation->id

        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD MESSAGES
    |--------------------------------------------------------------------------
    */

    public function messages($conversationId)
    {
        $conversation =
            Conversation::findOrFail(
                $conversationId
            );

        $this->authorizeConversation(
            $conversation
        );

        Message::where(
            'conversation_id',
            $conversationId
        )
            ->where(
                'sender_id',
                '!=',
                Auth::id()
            )
            ->update([
                'is_read' => 1,
            ]);
           
        

        $messages = Message::where(
            'conversation_id',
            $conversationId
        )
            ->with('sender')
            ->orderBy('id')
            ->get();

        return response()->json($messages);
    }

    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */

    public function send(Request $request)
    {
        $request->validate([

            'conversation_id' => 'required|exists:conversations,id',

            'message' => 'nullable|string|max:5000',
            
        ]);

        $conversation =
            Conversation::findOrFail(
                $request->conversation_id
            );

        $this->authorizeConversation(
            $conversation
        );

       
       
        /*
        |--------------------------------------------------------------------------
        | CREATE MESSAGE
        |--------------------------------------------------------------------------
        */

        $message = Message::create([

            'conversation_id' => $conversation->id,

            'sender_id' => Auth::id(),

            'message' => $request->message,

            

            'is_read' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE CONVERSATION
        |--------------------------------------------------------------------------
        */

        $conversation->update([

            'last_message' => $request->message,
            'last_message_at' => now(),
        ]);
        $conversation->load(
    'candidate.user',
    'employer.user'
);

event(
    new ChatListUpdated(
        $conversation
    )
);
        $message->load('sender');
        
        broadcast(
            new MessageSent($message)
        )->toOthers();
        /*
|--------------------------------------------------------------------------
| REALTIME BADGE
|--------------------------------------------------------------------------
*/

$receiverId = null;

if (
    Auth::id() ==
    optional($conversation->candidate)->user_id
) {

    $receiverId =
        optional(
            $conversation->employer
        )->user_id;

} else {

    $receiverId =
        optional(
            $conversation->candidate
        )->user_id;
}

$count = Message::whereHas(
        'conversation',
        function ($q) use ($receiverId) {

            $candidate =
                \App\Models\Candidate::where(
                    'user_id',
                    $receiverId
                )->first();

            $employer =
                \App\Models\Employer::where(
                    'user_id',
                    $receiverId
                )->first();

            if ($candidate) {

                $q->where(
                    'candidate_id',
                    $candidate->id
                );

            } elseif ($employer) {

                $q->where(
                    'employer_id',
                    $employer->id
                );
            }
        }
    )
    ->where('sender_id', '!=', $receiverId)
    ->where('is_read', 0)
    ->count();

event(
    new NewMessageNotification(
        $receiverId,
        $count
    )
);

    Log::info('Realtime Badge', [
        'receiver' => $receiverId,
        'count' => $count
    ]);

        return response()->json([

            'success' => true,

            'message' => $message->load('sender'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CONVERSATION
    |--------------------------------------------------------------------------
    */

    public function deleteConversation($id)
    {
        $conversation =
            Conversation::findOrFail($id);

        $this->authorizeConversation(
            $conversation
        );

        $conversation->delete();

        return response()->json([

            'success' => true,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | AUTHORIZE
    |--------------------------------------------------------------------------
    */

    private function authorizeConversation(
        $conversation
    ) {
        $userId = Auth::id();

        $candidateUserId =
            optional(
                $conversation->candidate
            )->user_id;

        $employerUserId =
            optional(
                $conversation->employer
            )->user_id;

        if (

            $userId != $candidateUserId &&

            $userId != $employerUserId

        ) {

            abort(403);

        }
    }
}
