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
        'helpful_list_id' => 'require|number',
        'helpful_price' =>  'require|number',
        'helpful_project_id' =>  'require|number',
        'customer_id' =>  'require|number',
    ];

    protected $message  =   [
        'limit.number' => '查询条数必须是数字',
        'page.number'     => '当前页面必须是数字',
        'helpful_type.require'     => '帮扶类型必须',
        'helpful_type.in:1,2'     => '帮扶类型填写错误',
        'helpful_price.require'     => '帮扶金额必须',
        'helpful_price.number'     => '帮扶金额必须是数字',
        'helpful_project_id.require'     => '帮扶项目ID必须',
        'helpful_project_id.number'     => '帮扶项目ID必须是数字',
        'customer_id.require'     => '客户ID必须',
        'customer_id.number'     => '客户ID必须是数字',
        'helpful_list_id.require'     => '帮扶列表ID必须',
        'helpful_list_id.number'     => '帮扶列表ID必须是数字',
    ];
    protected $scene = [
        'index'  =>  ['limit','page','helpful_type'],
        'details'  =>  ['helpful_id'],
        'pay'  =>  ['customer_id','helpful_price','helpful_project_id'],
        'save'  =>  ['helpful_project_id','customer_id','helpful_price'],
    ];
}