<?php

namespace app\admin\validate;

use think\Validate;

class Pasture extends Validate
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
        'id' => 'require',
        'pasture_name' => 'max:20|require',
        'pasture_address' => 'max:50|require',
        'pasture_tel' => 'tel|require',
        'cover' => 'require',
        'introduce' => 'max:1000|require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'pasture_name.max' => '牧场名称不能超过20个字符',
        'pasture_name.require' => '牧场名称必须',
        'pasture_address.max' => '牧场地址不能超过50个字符',
        'pasture_address.require' => '牧场地址必须',
        'pasture_tel.tel' => '牧场电话格式错误',
        'pasture_tel.require' => '牧场电话必须',
        'cover.require' => '封面必须',
        'introduce.max' => '牧场介绍不能超过1000个字符',
        'introduce.require' => '牧场介绍必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['pasture_name','pasture_address','cover','introduce'],
        'read' => ['id'],
        'update' => ['id','pasture_name','pasture_address','cover','introduce'],
        'delete' => ['id'],
    ];
}
