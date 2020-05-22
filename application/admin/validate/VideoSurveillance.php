<?php

namespace app\admin\validate;

use think\Validate;

class VideoSurveillance extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'surveillance_name' => 'max:20|require',
        'surveillance_code' => 'require|max:30',
        'channel_number' => 'require|number',
        'viewing_address' => 'require|max:50',
        'site' => 'require|max:50',
        'install_position' => 'require|max:150',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'surveillance_name.require' => '监控名称必须',
        'surveillance_name.max' => '监控名称不能超过20个字符',
        'surveillance_code.require' => '监控编号必须',
        'surveillance_code.max' => '监控编号不能超过30个字符',
        'channel_number.number' => '通道号必须是数字',
        'viewing_address.require' => '观看地址必须',
        'viewing_address.max' => '观看地址不能超过50个字符',
        'site.require' => '所属场地必须',
        'site.max' => '所属场地不能超过50个字符',
        'install_position.require' => '安装位置必须',
        'install_position.max' => '安装位置必须不能超过150个字符',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['surveillance_name','surveillance_code','channel_number','viewing_address','site','install_position'],
        'read' => ['id'],
        'update' => ['surveillance_name','surveillance_code','channel_number','viewing_address','site','install_position','id'],
        'delete' => ['id'],
    ];
}
