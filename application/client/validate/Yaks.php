<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/23
 * Time: 14:59
 */

namespace app\client\validate;


class Yaks extends Base
{
    protected $rule =   [
        'limit'  => 'number',
        'page'   => 'number',
        'yaks_id'   => 'require|number',
    ];

    protected $message  =   [
        'limit.number' => '查询条数必须是数字',
        'page.number'     => '当前页面必须是数字',
        'yaks_id.require'     => '请传入牦牛id',
        'yaks_id.number'     => '牦牛id必须是数字',
    ];
    protected $scene = [
        'adopt'  =>  ['limit','page'],
        'details'  =>  ['yaks_id'],
    ];
}