<?php

namespace app\move\validate;

use think\Validate;

class Withdrawal extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */

    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

    ];

	protected $rule = [
        'name'  =>  'require|max:20',
        'tel'  =>  'require|tel',
        'withdrawal_price'  =>  'require|number',
        'withdrawal_account'  =>  'require|number',
        'withdrawal_remark'  =>  'max:100',

    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'  =>  '姓名必须',
        'name.max'  =>  '姓名不能超过20个字符',
        'tel.require'  =>  '电话必须',
        'tel.tel'  =>  '电话格式错误',
        'withdrawal_price.require'  =>  '提现金额必须',
        'withdrawal_price.number'  =>  '提现金额必须是数字',
        'withdrawal_account.require'  =>  '提现账号必须',
        'withdrawal_remark.max'  =>  '提现备注不能超过100个字符',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['name','tel','withdrawal_price','withdrawal_account','withdrawal_remark'],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
        'bill' => [''],
    ];
}
