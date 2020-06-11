<?php

namespace app\move\validate;

use think\Validate;

class SaleOrder extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'yaks_id'=>'require|number',
        'goods'=>'require',
        'goods_number'=>'require|number',
        'pay_type'=>'require|number',
        'sale_type'=>'require|number',
        'receiving_address_id'=>'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'yaks_id.require'  =>  '牦牛ID必须',
        'yaks_id.number'  =>  '牦牛ID必须是数字',
        'goods.require'  =>  '商品ID必须',
        'goods_number.require'  =>  '商品数量必须',
        'goods_number.number'  =>  '商品数量必须是数字',
        'pay_type.require'  =>  '支付类型必须',
        'pay_type.number'  =>  '支付类型必须是数字',
        'sale_type.require'  =>  '销售类型必须',
        'sale_type.number'  =>  '销售类型必须是数字',
        'receiving_address_id.require'  =>  '收货地址必须',
        'receiving_address_id.number'  =>  '收货地址必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['yaks_id','goods','goods_number','pay_type','sale_type','receiving_address_id'],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
    ];
}
