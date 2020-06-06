<?php

namespace app\move\validate;

use think\Validate;

class BookingManage extends Validate
{
    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

    ];
    protected $rule = [
        'id' => 'require',
        'customer_id' => 'require|number',
        'pasture_id' => 'require|number',
        'total_number' => 'require|number',
        'adult' => 'require|number',
        'children' => 'require|number',
        'attendance_time' => 'require|date',
        'remarks' => 'require|max:1000',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'pasture_id.require' => '牧场名称必须',
        'pasture_id.number' => '牧场名称必须是数字',
        'total_number.require' => '总人数必须',
        'total_number.number' => '总人数必须是数字',
        'adult.require' => '成人数量必须',
        'adult.number' => '成人数量必须是数字',
        'children.require' => '儿童数量必须',
        'children.number' => '儿童数量必须是数字',
        'attendance_time.require' => '到达时间必须',
        'attendance_time.date' => '到达时间必须是日期',
        'remarks.max' => '备注不能大于1000字符',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['pasture_id','total_number','adult','children','attendance_time','remarks'],
        'read' => ['id'],
        'update' => ['status','id'],
        'delete' => ['id'],
    ];
}
