<?php
/**
 * Created by PhpStorm.
 * User: ry
 * Date: 2020/5/21
 * Time: 17:22
 */

return [

    //admin模块配置
    'admin' => [
        'allow_url' => [
            '/admin/login/login',
        ],
    ],

    'move' => [

        'allow_url' => [
            '/public/index.php/move/Checkout/payResult',
            '/public/index.php/move/gift/share'
        ]

    ]


];