@extends('layouts.app')

@section('content')
    <div class="messenger-wrapper">

        {{-- SIDEBAR --}}
        <div class="chat-sidebar">

            <div class="chat-sidebar-header">

                <div>
                    Tin nhắn
                </div>

                <div class="small text-muted">
                    {{ count($conversations) }} cuộc trò chuyện
                </div>

            </div>

            <div class="conversation-list">

                @forelse($conversations as $conversation)
                    @php

                        if (auth()->user()->role == 1) {
                            $otherUser = $conversation->employer?->user;
                        } else {
                            $otherUser = $conversation->candidate?->user;
                        }

                    @endphp

                    <div class="conversation-item-wrapper" id="conversation-wrapper-{{ $conversation->id }}">

                        <div class="conversation-item" data-user="{{ $otherUser->id }}"
                            id="conversation-{{ $conversation->id }}" onclick="loadMessages({{ $conversation->id }})">

                            <img src="https://ui-avatars.com/api/?background=1877f2&color=fff&name={{ urlencode($otherUser->name ?? 'User') }}"
                                class="conversation-avatar">

                            <div class="conversation-info">

                                <div class="d-flex justify-content-between">

                                    <div class="fw-bold">

                                        {{ $otherUser->name ?? 'User' }}

                                    </div>

                                </div>

                                <div class="conversation-last-message" id="last-message-{{ $conversation->id }}">

                                    {{ $conversation->last_message ?? 'Chưa có tin nhắn' }}

                                </div>

                            </div>

                        </div>

                        <button class="delete-chat-btn" onclick="deleteConversation({{ $conversation->id }})">

                            <i class="fa fa-trash"></i>

                        </button>

                    </div>

                @empty

                    <div class="p-4 text-center text-muted">

                        Chưa có cuộc trò chuyện nào

                    </div>
                @endforelse

            </div>

        </div>

        {{-- CHAT --}}
        <div class="chat-content">

            <div class="chat-header d-flex align-items-center gap-3" id="chatHeader">

                @if ($selectedConversation)
                    @php

                        if (auth()->user()->role == 1) {
                            $chatUser = $selectedConversation->employer->user ?? null;
                        } else {
                            $chatUser = $selectedConversation->candidate->user ?? null;
                        }

                    @endphp

                    <img src="https://ui-avatars.com/api/?background=1877f2&color=fff&name={{ urlencode($chatUser->name ?? 'User') }}"
                        width="45" height="45"
                        style="
                border-radius:50%;
                object-fit:cover;
            ">

                    <div>

                        <div class="fw-bold">

                            {{ $chatUser->name ?? 'Người dùng' }}

                        </div>

                        <div id="chatStatus" class="small text-success">

                            Đang kiểm tra...

                        </div>

                    </div>
                @else
                    <div class="fw-bold">

                        Chọn cuộc trò chuyện

                    </div>
                @endif

            </div>

            <div id="messagesBox" class="messages-box">

                <div class="empty-chat">

                    Hãy chọn cuộc trò chuyện

                </div>

            </div>

            <div class="chat-input">

                <form id="sendForm" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="conversation_id" id="conversation_id">

                    <div class="chat-input-wrapper">

                        <input type="text" name="message" id="messageInput" class="message-input"
                            placeholder="Nhập tin nhắn...">

                        <button class="send-btn">

                            <i class="fa fa-paper-plane"></i>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <style>
        body {
            background: #f0f2f5;
        }

        .messenger-wrapper {
            display: flex;
            height: 80vh;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
        }

        .chat-sidebar {
            width: 360px;
            border-right: 1px solid #eee;
        }

        .chat-sidebar-header {
            padding: 20px;
            font-size: 24px;
            font-weight: 700;
        }

        .conversation-item-wrapper {
            position: relative;
        }

        .conversation-item {
            display: flex;
            gap: 12px;
            padding: 15px;
            cursor: pointer;
        }

        .conversation-item:hover {
            background: #f5f5f5;
        }

        .conversation-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
        }

        .delete-chat-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: none;
        }

        .conversation-item-wrapper:hover .delete-chat-btn {
            display: block;
        }

        .chat-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .messages-box {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f5f7fb;
        }

        .message-row {
            display: flex;
            margin-bottom: 15px;
        }

        .message-row.me {
            justify-content: flex-end;
        }

        .message {
            max-width: 70%;
            padding: 12px;
            border-radius: 18px;
        }

        .message.me {
            background: #1877f2;
            color: #fff;
        }

        .message.other {
            background: #fff;
        }

        .chat-input {
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .chat-input-wrapper {
            display: flex;
            gap: 10px;
        }

        .message-input {
            flex: 1;
            border: none;
            background: #f0f2f5;
            padding: 12px;
            border-radius: 999px;
        }

        .send-btn {
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #1877f2;
            color: #fff;
        }

        .icon-btn {
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .conversation-item.active {
            background: #e7f3ff;
        }
    </style>

    <script>
        let currentConversation = null;

        let currentChannel = null;

        let onlineUsers = [];

        window.currentChatUserId = null;

        /*
        |--------------------------------------------------------------------------
        | LOAD MESSAGES
        |--------------------------------------------------------------------------
        */
        function appendMessage(msg) {
            let mine =
                msg.sender_id ==
                {{ auth()->id() }};

            let html = `

        <div class="message-row ${mine ? 'me' : ''}">

            <div
    class="message ${mine ? 'me' : 'other'}">

    <div>

        ${msg.message ?? ''}

    </div>

   

        </div>

    `;

            document
                .getElementById('messagesBox')
                .insertAdjacentHTML(
                    'beforeend',
                    html
                );

            scrollBottom();
        }

        function loadMessages(conversationId) {
            currentConversation = conversationId;
            /*
            |--------------------------------------------------------------------------
            | ECHO SUBSCRIBE
            |--------------------------------------------------------------------------
            */

            if (currentChannel) {

                window.Echo.leave(
                    'chat.' +
                    currentChannel
                );

            }

            currentChannel = conversationId;

            window.Echo.private(
                    'chat.' + conversationId
                )

                .listen('.message.sent', (e) => {
                    console.log(
                        'Realtime nhận được:',
                        e
                    );

                    if (
                        e.message.sender_id ==
                        {{ auth()->id() }}
                    ) {
                        return;
                    }

                    appendMessage(
                        e.message
                    );


                })


            document.getElementById(
                'conversation_id'
            ).value = conversationId;

            /*
            |--------------------------------------------------------------------------
            | ACTIVE SIDEBAR
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll(
                '.conversation-item'
            ).forEach(item => {

                item.classList.remove('active');

            });

            document.getElementById(
                'conversation-' + conversationId
            ).classList.add('active');

            /*
            |--------------------------------------------------------------------------
            | CHANGE HEADER USER
            |--------------------------------------------------------------------------
            */

            let otherName =
                document.querySelector(
                    '#conversation-' + conversationId + ' .fw-bold'
                ).innerText;

            document.getElementById(
                'chatHeader'
            ).innerHTML = `

<img
    src="https://ui-avatars.com/api/?background=1877f2&color=fff&name=${encodeURIComponent(otherName)}"
    width="45"
    height="45">

<div>

    <div class="fw-bold">
        ${otherName}
    </div>

    <div
        id="chatStatus"
        class="small text-success">

        Đang kiểm tra...

    </div>

</div>
`;
            window.currentChatUserId =
                parseInt(
                    document
                    .querySelector(
                        '#conversation-' +
                        conversationId
                    )
                    .dataset.user
                );

            updateOnlineStatus();

            /*
            |--------------------------------------------------------------------------
            | LOAD MESSAGE LIST
            |--------------------------------------------------------------------------
            */

            fetch('/chat/messages/' + conversationId)

                .then(res => res.json())

                .then(messages => {

                    let html = '';

                    messages.forEach(msg => {

                        let mine =
                            msg.sender_id ==
                            {{ auth()->id() }};

                        html += `

                <div class="message-row ${mine ? 'me' : ''}">

                    <div class="message ${mine ? 'me' : 'other'}">

                        ${msg.message ?? ''}

                       

                        

                    </div>

                </div>

            `;
                    });

                    document.getElementById(
                        'messagesBox'
                    ).innerHTML = html;

                    scrollBottom();

                });

        }

        /*
        |--------------------------------------------------------------------------
        | SEND MESSAGE
        |--------------------------------------------------------------------------
        */

        document.getElementById('sendForm')

            .addEventListener('submit', function(e) {

                e.preventDefault();

                if (!currentConversation) {

                    return;

                }

                let formData =
                    new FormData(this);

                fetch('/chat/send', {

                        method: 'POST',

                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                        body: formData

                    })

                    .then(res => res.json())

                    .then(data => {

                        if (data.success) {

                            appendMessage(
                                data.message
                            );

                            document.getElementById(
                                'messageInput'
                            ).value = '';

                        }

                    });

            });

        /*
        |--------------------------------------------------------------------------
        | AUTO ENTER SEND
        |--------------------------------------------------------------------------
        */

        document.getElementById(
                'messageInput'
            )

            .addEventListener('keypress', function(e) {

                if (e.key === 'Enter') {

                    e.preventDefault();

                    document.getElementById(
                        'sendForm'
                    ).dispatchEvent(
                        new Event('submit')
                    );

                }

            });

        /*
        |--------------------------------------------------------------------------
        | SCROLL
        |--------------------------------------------------------------------------
        */

        function scrollBottom() {
            let box =
                document.getElementById(
                    'messagesBox'
                );

            box.scrollTop =
                box.scrollHeight;
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE CHAT
        |--------------------------------------------------------------------------
        */

        function deleteConversation(id) {
            if (!confirm('Xóa cuộc trò chuyện này?')) {

                return;

            }

            fetch('/chat/delete/' + id, {

                    method: 'DELETE',

                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }

                })

                .then(res => res.json())

                .then(data => {

                    if (data.success) {

                        location.reload();

                    }

                });
        }

        /*
        |--------------------------------------------------------------------------
        | AUTO OPEN
        |--------------------------------------------------------------------------
        */

        @if ($selectedConversation)

            window.addEventListener('load', () => {

                loadMessages(
                    {{ $selectedConversation->id }}
                );

            });
        @endif

        document.addEventListener(
            'DOMContentLoaded',
            function() {

                setTimeout(() => {

                    console.log(
                        'Echo:',
                        window.Echo
                    );

                    console.log(
                        'join:',
                        typeof window.Echo?.join
                    );

                    if (
                        !window.Echo ||
                        typeof window.Echo.join !==
                        'function'
                    ) {

                        console.error(
                            'Presence Channel chưa sẵn sàng'
                        );

                        return;
                    }
                    window.Echo
                        .private('user.{{ auth()->id() }}')
                        .listen('.chat.list.updated', (e) => {

                            console.log('CHAT LIST UPDATE', e);


                        });

                    window.Echo

                        .join('online')

                        .here((users) => {

                            console.log(
                                'ONLINE USERS',
                                users
                            );

                            onlineUsers = users;

                            updateOnlineStatus();

                        })

                        .joining((user) => {

                            console.log(
                                'JOIN',
                                user
                            );

                            onlineUsers.push(
                                user
                            );

                            updateOnlineStatus();

                        })

                        .leaving((user) => {

                            console.log(
                                'LEAVE',
                                user
                            );

                            onlineUsers =
                                onlineUsers.filter(
                                    u =>
                                    u.id != user.id
                                );

                            updateOnlineStatus();

                        });

                }, 1000);

            }
        );

        function updateOnlineStatus() {

            if (
                !window.currentChatUserId
            ) {
                return;
            }

            if (
                typeof onlineUsers ===
                'undefined'
            ) {
                return;
            }

            let online =
                onlineUsers.some(
                    user =>
                    user.id ==
                    window.currentChatUserId
                );

            let status =
                document.getElementById(
                    'chatStatus'
                );

            if (!status) {
                return;
            }

            status.innerHTML =
                online ?
                '🟢 Đang hoạt động' :
                '⚪ Ngoại tuyến';

        }
    </script>
@endsection
