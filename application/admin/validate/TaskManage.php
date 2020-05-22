<?php

namespace app\admin\validate;

use think\Validate;

class TaskManage extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'enclosure_url' => 'fileSize:52428800',
        'pasture_id' => 'require|number',
        'task_name' => 'require|max:10',
        'task_detail' => 'require|max:1000',
        'finish_time' => 'date',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'enclosure_url.fileSize' => '文件大小不能超过50M',
        'pasture_id.require' => '牧场名称必须',
        'pasture_id.number' => '牧场名称必须是数字',
        'task_name.require' => '任务名称必须',
        'task_name.max' => '任务名称不能大于20个字符',
        'task_detail.require' => '任务详情',
        'task_detail.max' => '任务详情不能大于1000个字符',
        'finish_time.date' => '完成时间格式不对',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['pasture_id', 'task_name', 'task_detail', 'finish_time', 'enclosure_url'],
        'read' => ['id'],
        'update' => ['pasture_id', 'task_name', 'task_detail', 'finish_time', 'id', 'enclosure_url'],
        'delete' => ['id'],
    ];

}
