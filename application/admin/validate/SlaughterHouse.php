<?php

namespace app\admin\validate;

use think\Validate;

class SlaughterHouse extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

    ];
    protected $rule = [
        'id' => 'require',
        'slaughter_house_name' => 'max:20|require',
        'slaughter_house_address' => 'max:50|require',
        'slaughter_house_tel' => 'tel|require',
        'slaughter_house_cover' => 'require',
        'slaughter_house_introduce' => 'max:1000|require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'slaughter_house_name.max' => '屠宰场名称不能超过20个字符',
        'slaughter_house_name.require' => '屠宰场名称必须',
        'slaughter_house_address.max' => '屠宰场地址不能超过50个字符',
        'slaughter_house_address.require' => '屠宰场地址必须',
        'slaughter_house_tel.tel' => '屠宰场电话格式错误',
        'slaughter_house_tel.require' => '屠宰场电话必须',
        'slaughter_house_cover.require' => '封面必须',
        'slaughter_house_introduce.max' => '屠宰场介绍不能超过1000个字符',
        'slaughter_house_introduce.require' => '屠宰场介绍必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['slaughter_house_name', 'slaughter_house_address', 'slaughter_house_cover', 'slaughter_house_introduce'],
        'read' => ['id'],
        'update' => ['id', 'slaughter_house_name', 'slaughter_house_address', 'slaughter_house_cover', 'slaughter_house_introduce'],
        'delete' => ['id'],
    ];
}
