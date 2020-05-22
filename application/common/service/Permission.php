<?php
/**
 * Created by PhpStorm.
 * User: ry
 * Date: 2020/5/21
 * Time: 17:30
 */

namespace app\common\service;

use app\common\lib\Transfer;
use app\common\model\AdminUser;
use app\common\task\PermissionTask;
use GuzzleHttp\Exception\TransferException;

class Permission
{
    public static function check($admin_user_id,$url)
    {
        $role_permission = cookie('role_permission_'.$admin_user_id);
        if(!$role_permission){
            $where['a.id'] = $admin_user_id;
            $transfer = AdminUser::alias('a')
                ->join('Role b','a.role_id = b.id','LEFT')
                ->field('b.permission_id')
                ->where($where)
                ->find();
            unset($where['a.id']);
            if($transfer['permission_id']==false){
                return new Transfer('权限不足');
            }
            $role_permission = $transfer['permission_id'];
            setcookie('role_permission_'.$admin_user_id,$role_permission,'7200');
        }
        //获取当前权限
        $where['route'] = $url;
        $transfer = PermissionTask::find($where,'id');
        if(!$transfer){
            return new Transfer('暂无权限');
        }
        $role_permission = explode(',',$role_permission);
        if(!in_array($transfer->data['id'],$role_permission)){
            return new Transfer('暂无权限');
        }
        return new Transfer('',200);

    }


}