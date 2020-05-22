<?php

namespace app\admin\validate;

use think\Validate;

class RealNameAuth extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'customer_id' => 'require',
        'id_card' => 'require|max:24',
        'positive' => 'require|file',
        'status' => 'require',
        'back' => 'require|file',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'customer_id.require' => '客户id必须',
        'id_card.max' => '身份证号码不能大于24个字符',
        'id_card.require' => '身份证号码必须',
        'positive.require' => '身份证正面图片必须',
        'positive.file' => '身份证正面图片必须是图片',
        'back.require' => '身份证背面图片必须',
        'back.file' => '身份证背面图片必须是图片',
        'status.require' => '状态必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['customer_id','id_card','positive','back','status'],
        'read' => ['id'],
        'update' => ['id','status'],
        'delete' => ['id'],
    ];
}
