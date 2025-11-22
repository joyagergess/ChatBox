<?php

$apis = [

    '/users'           => ['controller' => 'UserController', 'method' => 'getUsers', 'type' => 'GET'],
    '/user'            => ['controller' => 'UserController', 'method' => 'getUserByID', 'type' => 'GET'],
    '/user/create'     => ['controller' => 'UserController', 'method' => 'createUser', 'type' => 'POST'],
    '/user/update'     => ['controller' => 'UserController', 'method' => 'updateUser', 'type' => 'PUT'],
    '/user/delete'     => ['controller' => 'UserController', 'method' => 'deleteUser', 'type' => 'DELETE'],

];
