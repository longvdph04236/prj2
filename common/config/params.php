<?php
$folder = ltrim($_SERVER['PHP_SELF'],"/");
$folder = explode("/",$folder);
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'appFolder' => 'http://'.$_SERVER['HTTP_HOST'].'/'.$folder[0]
];
