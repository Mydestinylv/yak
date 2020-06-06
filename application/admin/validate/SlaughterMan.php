<?php

namespace app\admin\validate;

use think\Validate;

class SlaughterMan extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

        'id_card' => "/^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X)?/"
    ];
	protected $rule = [
        'id' => 'require',
        'slaughter_house_id' => 'number|require',
        'name' => 'require|max:20',
        'head_img' => 'require',
        'tel' => 'require|tel',
        'id_card' => 'require|id_card',
        'user_name' => 'require|max:20',
        'password' => 'require|max:20|alphaDash',
        'total_balance' => 'number',
        'freezing_balance' => 'number',
        'score' => 'require|number',
        'introduce' => 'max:1000',
        'prove' => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'slaughter_house_id.number' => '屠宰场ID必须是数字',
        'slaughter_house_id.require' => '屠宰场ID必须',
        'name.require' => '姓名必须',
        'name.max' => '姓名不能超过20个字符',
        'head_img.require' => '头像必须',
        'tel.require' => '电话必须',
        'tel.tel' => '电话格式不对',
        'id_card.require' => '身份证必须',
        'id_card.id_card' => '身份证格式错误',
        'user_name.require' => '用户名称必须',
        'user_name.max' => '用户名称不能超过20个字符',
        'password.require' => '密码必须',
        'password.max' => '密码不能超过20个字符',
        'password.alphaDash' => '密码必须是字母和数字，下划线_及破折号-',
        'total_balance.number' => '总金额必须是数字',
        'freezing_balance.number' => '冻结金额必须是数字',
        'score.number' => '评分必须是数字',
        'introduce.max' => '介绍不能超过1000个字符',
        'prove.require' => '屠宰场相关证明',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['slaughter_house_id','name','head_img','tel','id_card','user_name','password','total_balance','freezing_balance','score','introduce','prove'],
        'read' => ['id'],
        'update' => ['slaughter_house_id','name','head_img','tel','id_card','total_balance','freezing_balance','score','introduce','prove','id'],
        'delete' => ['id'],
        'password_reset' => ['id','password'],
    ];
}
