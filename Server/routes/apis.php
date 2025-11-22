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

    '/chat/create' => ['controller' => 'ChatsController', 'method' => 'createChat', 'type' => 'POST'],
    '/chats'       => ['controller' => 'ChatsController', 'method' => 'getChats', 'type' => 'GET'],
    '/chat'        => ['controller' => 'ChatsController', 'method' => 'getChatByID', 'type' => 'GET'],
    '/chat/update' => ['controller' => 'ChatsController', 'method' => 'updateChat', 'type' => 'PUT'],
    '/chat/delete' => ['controller' => 'ChatsController', 'method' => 'deleteChat', 'type' => 'DELETE'],

];
