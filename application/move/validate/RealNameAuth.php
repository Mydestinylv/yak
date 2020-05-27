<?php

namespace app\move\validate;

use think\Validate;

class RealNameAuth extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $regex = [

        'id_card' => "/^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X)?/"
    ];

	protected $rule = [
        'real_name' =>  'require|max:10',
        'id_card' =>  'id_card|require|max:18',
        'positive' =>  'require',
        'back' =>  'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'real_name.require' =>  '真实姓名必须',
        'real_name.max' =>  '真实姓名不能超过10个字符',
        'id_card.require' =>  '身份证号码必须',
        'id_card.id_card' =>  '身份证号码格式错误',
        'id_card.max' =>  '身份证号码不能超过18个字符',
        'positive.require' =>  '身份证正面照必须',
        'back.require' =>  '身份证背面照必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['real_name','id_card','positive','back'],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
    ];
}
