<?php

namespace app\admin\validate;

use think\Validate;

class BannerManage extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'picture' => 'require|image',
        'jump_address' => 'require|max:30',
        'is_index' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'picture.require' => 'banner图片必须',
        'picture.image' => 'banner必须是图片',
        'jump_address.require' => '跳转地址必须',
        'jump_address.max' => '跳转地址不能超过30字符',
        'is_index.require' => '是否设为首页必须',
        'is_index.number' => '是否设为首页必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['picture','jump_address','is_index'],
        'read' => ['id'],
        'update' => ['id','is_index'],
        'delete' => ['id'],
    ];
}
