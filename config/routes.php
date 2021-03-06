<?php
use yii\web\UrlRule;

return array(
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    'users/<alias>'=>'user-management/user',
    'roles/<alias>'=>'user-management/role',
    'permissions/<alias>'=>'user-management/permission',
    'permission-groups/<alias>'=>'user-management/auth-item-group/index',
    'user-visit-log'=>'user-management/user-visit-log/index',
    'myvisitlogs'=>'user-management/user-visit-log/myvisitlogs',
    'logout'=>'user-management/auth/logout',
    'login'=>'user-management/auth/login',
    'change-own-password'=>'user-management/auth/change-own-password',
);