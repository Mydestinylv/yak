<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Role extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public static $permission_list = [
        //客户列表
        'customer' => [
            'customer_index' => 1, //查看
            'customer_save' => 2, //新增
            'customer_update' => 3,  //修改
            'customer_delete' => 4, //删除
        ],
        //卡号管理
        'card_manage' => [
            'card_manage_index' => 1, //查看
        ],
        //实名认证
        'real_name_auth' => [
            'real_name_auth_index' => 1, //查看
            'real_name_auth_update' => 2, //处理
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],
        //客户列表
        'customer_list' => [
            'customer_list_index' => 1, //查看
            'customer_list_save' => 2, //新增
            'customer_list_update' => 3,  //修改
            'customer_list_delete' => 4, //删除
        ],


    ];
    //接口对应模块权限
    public static $url_permission_list = [
//客户列表
        '/admin/customer/index' => 'customer_index',
        '/admin/customer/save' => 'customer_save',
        '/admin/customer/read' => 'customer_update',
        '/admin/customer/update' => 'customer_update',
        '/admin/customer/delete' => 'customer_delete',
    ];
}
