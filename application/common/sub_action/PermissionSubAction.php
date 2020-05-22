<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\Permission;
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
            ->field('a.id,a.name as permission_name,a.group_id,b.name as permission_group_name,a.route')
            ->select();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        $data = to_array($transfer);
        $permission_data = [];
        foreach ($data as $k => $v) {
            $permission_data[$v['group_id']]['name'] = $v['permission_group_name'];
            $permission_data[$v['group_id']]['permission'][$v['id']] = $v['permission_name'];
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
        $permission_data['choose_permission'] = $choose_permission;
        return new Transfer('', true, $permission_data == false ? [] : $permission_data);
    }
}
