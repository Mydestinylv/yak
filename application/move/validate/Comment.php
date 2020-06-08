<?php

namespace app\move\validate;

use think\Validate;

class Comment extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'yaks_id'   =>  'require|number',
        'herdsman_id'   =>  'require|number',
        'task_id'   =>  'require|number',
        'score'   =>  'require|number',
        'comment_content'   =>  'require|max:200',
        'slaughter_house_id'   =>  'require|number',
        'sale_order_code'   =>  'require',
        'comment_type'   =>  'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'yaks_id.require'   =>  '牦牛ID必须',
        'yaks_id.number'   =>  '牦牛ID必须是数字',
        'herdsman_id.require'   =>  '牧民ID必须',
        'herdsman_id.number'   =>  '牧民ID必须是数字',
        'task_id.require'   =>  '任务ID必须',
        'task_id.number'   =>  '任务ID必须是数字',
        'score.require'   =>  '评分必须',
        'score.number'   =>  '评分必须是数字',
        'comment_content.require'   =>  '评论内容必须',
        'comment_content.max'   =>  '评论内容不能超过200个字符',
        'slaughter_house_id.require'   =>  '屠宰场ID必须',
        'slaughter_house_id.number'   =>  '屠宰场ID必须是数字',
        'sale_order_code.require'   =>  '销售订单编号必须',
        'comment_type.require'   =>  '评论类型必须',
        'comment_type.number'   =>  '评论类型必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'herdsman' => ['yaks_id','herdsman_id','task_id','score','comment_content','comment_type'],
        'slaughter' => ['yaks_id','slaughter_house_id','score','comment_content','comment_type'],
        'saleOrder' => ['yaks_id','herdsman_id','sale_code','score','comment_content','comment_type'],
        'delete' => [''],
    ];
}
