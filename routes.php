<?php

return [
    '/' => 'MainController/index',
    '/create' => 'MainController/form',
    '/edit/::num' => 'MainController/form/$1',
    '/save' => 'MainController/save',
    '/error' => 'MainController/error',
    '/login' => 'MainController/login',
    '/logout' => 'MainController/logout',
];