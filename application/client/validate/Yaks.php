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
        'invest_type' => 'require|in:0,1'
    ];

    protected $message  =   [
        'limit.number' => '查询条数必须是数字',
        'page.number'     => '当前页面必须是数字',
        'yaks_id.require'     => '请传入牦牛id',
        'yaks_id.number'     => '牦牛id必须是数字',
        'invest_type.require'     => '认养类型必须',
        'invest_type.in:0,1'     => '认养类型填写错误',
    ];
    protected $scene = [
        'adopt'  =>  ['limit','page','invest_type'],
        'details'  =>  ['yaks_id'],
    ];
}