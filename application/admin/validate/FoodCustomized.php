<?php

namespace app\admin\validate;

use think\Validate;

class FoodCustomized extends Validate
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
        'apply_name' => 'max:20|require',
        'apply_tel' => 'tel|number',
        'family_number' => 'require|number',
        'beneficiary' => 'require|max:20',
        'note' => 'max:200',
        'menu_type' => 'require|number',
        'menu_number' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'apply_name.require' => '申请人姓名必须',
        'apply_name.number' => '申请人姓名不能超过20个字符',
        'apply_tel.require' => '申请人电话必须',
        'apply_tel.tel' => '申请人电话格式不对',
        'family_number.require' => '家庭人数必须',
        'family_number.number' => '家庭人数必须是数字',
        'beneficiary.require' => '受益人必须',
        'beneficiary.max' => '受益人不能超过20个字符',
        'note.max' => '注意事项不能超过200个字符',
        'menu_type.require' => '菜品类型必须',
        'menu_type.number' => '菜品类型必须是数字',
        'menu_number.number' => '菜品数量必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['apply_name','apply_tel','family_number','beneficiary','note','menu_type','menu_number'],
        'read' => ['id'],
        'update' => ['apply_name','apply_tel','family_number','beneficiary','note','menu_type','menu_number','id'],
        'delete' => ['id'],
        'feedback' => ['id'],
    ];
}
