<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\Permission;
use app\common\model\PermissionGroup;
use app\common\model\Role;
use app\common\task\PermissionTask;
use app\common\task\RoleTask;

class PermissionSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {

        $where = [];
        $transfer = Permission::alias('a')
            ->join('Permission_group b', 'a.group_id = b.id', 'LEFT')
            ->field('a.id,a.name as permission_name,a.group_id,b.name as permission_group_name')
            ->select();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        $permission_data = to_array($transfer);
        $data = [];
        $i = 0;
        foreach($permission_data as $k => $v){
            $data[$v['group_id']]['permission_name'] = $v['permission_group_name'];
            if(isset($data[$v['group_id']]['permission'][$i])){
                $i++;
                $data[$v['group_id']]['permission'][$i]['name'] = $v['permission_name'];
                $data[$v['group_id']]['permission'][$i]['code'] = $v['id'];
            }else{
                $i = 0;
                $data[$v['group_id']]['permission'][$i]['name'] = $v['permission_name'];
                $data[$v['group_id']]['permission'][$i]['code'] = $v['id'];
            }
        }
        if (isset($param['id']) && !empty($param['id'])) {
            $where['id'] = $param['id'];
            $field = 'permission_id';
            $transfer = RoleTask::find($where, $field);
            if (!$transfer->status) {
                return new Transfer('获取权限失败');
            }
            $role_data = to_array($transfer->data);
            if (empty($role_data['permission_id'])) {
                $choose_permission = [];
            } else {
                $choose_permission = explode(',', $role_data['permission_id']);
            }
        } else {
            $choose_permission = [];
        }
        $data['choose_permission'] = $choose_permission;
        return new Transfer('', true, $permission_data == false ? [] : to_array($data));
    }
}
