<?php

namespace app\admin\validate;

use think\Validate;

class Yaks extends Validate
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
        'pasture_id' => 'require|number',
        'herdsman_id' => 'require|number',
        'yaks_name' => 'require|max:24',
        'yaks_img' => 'require|image',
        'yaks_tag' => 'require',
        'yaks_birthday' => 'require|date',
        'yaks_sex' => 'require|number',
        'adoption_tel' => 'require|tel',
        'adoption_time' => 'require|date',
        'is_adoption' => 'require|number',
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
        'herdsman_id.require' => '牧名名称必须',
        'herdsman_id.number' => '牧名必须是数字',
        'yaks_name.require' => '牦牛名称必须',
        'yaks_name.max' => '牦牛名称不能大于24个字符',
        'yaks_img.require' => '牦牛图片必须',
        'yaks_img.image' => '牦牛图片必须是图片',
        'yaks_tag.require' => '牦牛耳标必须',
        'yaks_birthday.require' => '牦牛出生日期必须',
        'yaks_birthday.date' => '牦牛出生日期格式错误',
        'adoption_time.require' => '认领日期必须',
        'adoption_time.date' => '认领日期格式错误',
        'yaks_sex.require' => '牦牛性别必须',
        'yaks_sex.number' => '牦牛性别必须是数字',
        'adoption_tel.require' => '认领人手机号必须',
        'adoption_tel.tel' => '认领人手机号格式错误',
        'is_adoption.require' => '牦牛认养状态必须',
        'is_adoption.number' => '牦牛认养状态必须是数字',
        'remarks.max' => '备注不能大于1000个字符',

    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['pasture_id','herdsman_id','yaks_name','yaks_img','yaks_tag','yaks_birthday','yaks_sex','adoption_tel','adoption_time','is_adoption','remarks'],
        'read' => ['id'],
        'update' => ['pasture_id','herdsman_id','yaks_name','yaks_img','yaks_tag','yaks_birthday','yaks_sex','adoption_tel','adoption_time','is_adoption','remarks','id'],
        'delete' => ['id'],
    ];
}
