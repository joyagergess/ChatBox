<?php

$apis = [

    '/users'           => ['controller' => 'UserController', 'method' => 'getUsers', 'type' => 'GET'],
    '/user'            => ['controller' => 'UserController', 'method' => 'getUserByID', 'type' => 'GET'],
    '/user/create'     => ['controller' => 'UserController', 'method' => 'createUser', 'type' => 'POST'],
    '/user/update'     => ['controller' => 'UserController', 'method' => 'updateUser', 'type' => 'PUT'],
    '/user/delete'     => ['controller' => 'UserController', 'method' => 'deleteUser', 'type' => 'DELETE'],
    
    '/users_chats'        => ['controller' => 'UsersChatsController', 'method' => 'getUsersChats', 'type' => 'GET'],
    '/users_chat'         => ['controller' => 'UsersChatsController', 'method' => 'getUsersChatById', 'type' => 'GET'],
    '/users_chat/create'  => ['controller' => 'UsersChatsController', 'method' => 'createUsersChat', 'type' => 'POST'],
    '/users_chat/update'  => ['controller' => 'UsersChatsController', 'method' => 'updateUsersChat', 'type' => 'PUT'],
    '/users_chat/delete'  => ['controller' => 'UsersChatsController', 'method' => 'deleteUsersChat', 'type' => 'DELETE'],
    '/users_chats/byuser' => ['controller' => 'UsersChatsController', 'method' => 'getChatsByUser', 'type' => 'GET'],

    '/chat/create'      => ['controller' => 'ChatsController', 'method' => 'createChat', 'type' => 'POST'],
    '/chats'            => ['controller' => 'ChatsController', 'method' => 'getChats', 'type' => 'GET'],
    '/chat'             => ['controller' => 'ChatsController', 'method' => 'getChatByID', 'type' => 'GET'],
    '/chat/update'      => ['controller' => 'ChatsController', 'method' => 'updateChat', 'type' => 'PUT'],
    '/chat/delete'      => ['controller' => 'ChatsController', 'method' => 'deleteChat', 'type' => 'DELETE'],
    '/chat/check' => ['controller' => 'ChatsController', 'method' => 'checkChat', 'type' => 'GET'],
   
    '/messages'           => ['controller' => 'MessagesController', 'method' => 'getAllMessages', 'type' => 'GET'],
    '/message'            => ['controller' => 'MessagesController', 'method' => 'getMessageByID', 'type' => 'GET'],
    '/message/create'     => ['controller' => 'MessagesController', 'method' => 'createMessage', 'type' => 'POST'],
    '/message/update'     => ['controller' => 'MessagesController', 'method' => 'updateMessage', 'type' => 'PUT'],
    '/message/delete'     => ['controller' => 'MessagesController', 'method' => 'deleteMessage', 'type' => 'DELETE'],
    '/messages/by-chat'   => ['controller' => 'MessagesController', 'method' => 'getMessagesByChat', 'type' => 'GET'],
    '/messages/mark-read' => ['controller' => 'MessagesController', 'method' => 'markChatRead', 'type' => 'POST'],
    '/messages/mark-delivered' => ['controller' => 'MessagesController', 'method' => 'markChatDelivered', 'type' => 'POST'],

    '/contacts'           => ['controller' => 'ContactsController', 'method' => 'getAllContacts', 'type' => 'GET'],
    '/contact'            => ['controller' => 'ContactsController', 'method' => 'getContactByID', 'type' => 'GET'],
    '/contact/create'     => ['controller' => 'ContactsController', 'method' => 'createContact', 'type' => 'POST'],
    '/contact/update'     => ['controller' => 'ContactsController', 'method' => 'updateContact', 'type' => 'PUT'],
    '/contact/delete'     => ['controller' => 'ContactsController', 'method' => 'deleteContact', 'type' => 'DELETE'],
    '/contacts/byuser'    => ['controller' => 'ContactsController', 'method' => 'getContactsByUser', 'type' => 'GET'],
    '/contact/info' => ['controller' => 'ContactsController', 'method' => 'getContactInfo', 'type' => 'GET'],



    '/auth/signup'        => ['controller' => 'AuthController', 'method' => 'signup', 'type' => 'POST'],
    '/auth/login'         => ['controller' => 'AuthController', 'method' => 'login', 'type' => 'POST'],

];
