<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'chat.{conversationId}',
    function (User $user, $conversationId) {

        $conversation =
            Conversation::find($conversationId);

        if (!$conversation) {
            return false;
        }

        $candidateUserId =
            optional(
                $conversation->candidate
            )->user_id;

        $employerUserId =
            optional(
                $conversation->employer
            )->user_id;

        return
            $user->id == $candidateUserId
            ||
            $user->id == $employerUserId;
    }
);
Broadcast::channel(
    'user.{id}',
    function ($user, $id) {
        return (int)$user->id === (int)$id;
    }
);

Broadcast::channel('online', function ($user) {

    return [

        'id'   => $user->id,

        'name' => $user->name,

    ];

});