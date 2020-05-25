<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\AdminUserTask;

class AdminUserSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['keyword_type']) && (!empty($param['keyword_type'])) && isset($param['keyword']) && (!empty($param['keyword']))) {
            if ($param['keyword_type'] == 'user_name') {
                $where['user_name'] = ['like', '%' . $param['keyword'] . '%'];
            }
            if ($param['keyword_type'] == 'account') {
                $where['account'] = ['like', '%' . $param['keyword'] . '%'];
            }
        }
        $file = 'id,user_name,account,tel,create_time,role_id';
        $order = ['create_time desc'];
        $transfer = AdminUserTask::paginate($where, $file, $order);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        unset($param['repeat_password']);
        $where['account'] = $param['account'];
        $transfer = AdminUserTask::valueByWhere($where,'id');
        if($transfer->data['id']){
            return new Transfer('此账号已存在');
        }
        $param['salt'] = get_salt();
        $param['password'] = password_encryption($param['password'], $param['salt']);
        $transfer = AdminUserTask::save($param);
        if (!$transfer->status) {
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $where['id'] = $param['id'];
        $file = 'id,user_name,account,tel,create_time,role_id';
        $order = ['create_time desc'];
        $transfer = AdminUserTask::paginate($where, $file, $order);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $where['id'] = $param['id'];
        if(isset($param['password'])&&!empty($param['password'])){
            $param['salt'] = get_salt();
            $param['password'] = password_encryption($param['password'], $param['salt']);
        }
        $transfer = AdminUserTask::update($param, $where);
        if (!$transfer->status) {
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = AdminUserTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
