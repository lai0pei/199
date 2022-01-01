<?php
return [
    'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 100,
        'math'      => true, //Enable Math Captcha
        'expire'    => 60,   //Stateless/API captcha expiration
        'encrypt' => false,
    ],
    'admin_login' => [
        'length' => 4,
        'width' => 90,
        'height' => 32,
        'quality' => 90,
        'expire' => 5,
        'math' => false,
    ],
    'index' => [
        'length' => 4,
        'width' => 90,
        'height' => 32,
        'quality' => 90,
        'expire' => 5,
        'math' => false,
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],
];
?>