<?php

namespace app\admin\validate;

use think\Validate;

class BookingManage extends Validate
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
        'booking_name' => 'require|max:10',
        'booking_tel' => 'require|tel',
        'pasture_id' => 'require|number',
        'total_number' => 'require|number',
        'adult' => 'require|number',
        'children' => 'require|number',
        'attendance_time' => 'require|date',
        'status' => 'require|number',
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
        'booking_name.require' => '预约人姓名必须',
        'booking_name.max' => '预约人姓名不能大于10个字符',
        'booking_tel.require' => '预约人电话必须',
        'booking_tel.tel' => '预约人电话格式错误',
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
        'status.require' => '状态必须',
        'status.number' => '状态必须是数字',
        'remarks.max' => '备注不能大于1000字符',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['booking_name','booking_tel','pasture_id','total_number','adult','children','attendance_time','status','remarks'],
        'read' => ['id'],
        'update' => ['status','id'],
        'delete' => ['id'],
    ];
}
