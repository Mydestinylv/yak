<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/26
 * Time: 9:58
 */

namespace app\client\validate;


class Adopt extends Base
{
    protected $rule =   [
        'limit'  => 'number',
        'page'   => 'number',
        'helpful_type' => 'require|in:1,2',
        'helpful_id' => 'require|number',
    ];

    protected $message  =   [
        'limit.number' => '查询条数必须是数字',
        'page.number'     => '当前页面必须是数字',
        'helpful_type.require'     => '认养类型必须',
        'helpful_type.in:1,2'     => '认养类型填写错误',
    ];
    protected $scene = [
        'index'  =>  ['limit','page','helpful_type'],
        'details'  =>  ['helpful_id'],
    ];
}