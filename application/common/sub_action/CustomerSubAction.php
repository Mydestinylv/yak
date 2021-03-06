<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\CustomerTask;
use app\common\task\HerdsmanTask;
use app\common\task\SlaughterManTask;

class CustomerSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['wechat_name']) && !empty($param['wechat_name'])) {
            $where['wechat_name'] = ['like', '%' . $param['wechat_name'] . '%'];
        }
        if (isset($param['real_name']) && !empty($param['real_name'])) {
            $where['real_name'] = ['like', '%' . $param['real_name'] . '%'];
        }
        if (isset($param['type']) && !empty($param['type'])) {
            $where['type'] = $param['type'];
        }
        $field = ['id,head_img,real_name,wechat_name,tel,user_name,type,total_balance,freezing_balance,real_name,id_card,yaks'];
//        $order = 'create_time desc';
//        $paginate = 10;
        $transfer = CustomerTask::paginate($where, $field);
        if (!$transfer->status) {
            return new Transfer('查询错误');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $param['password'] = pswCrypt($param['password']);
        $transfer = CustomerTask::save($param);
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
        $where = ['id' => $param['id']];
        $field = ['id,head_img,wechat_name,tel,user_name,type,total_balance,freezing_balance,real_name,id_card,yaks'];
        $transfer = CustomerTask::find($where, $field);
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
        $where = ['id' => $param['id']];
        unset($param['id']);
        $transfer = CustomerTask::update($param, $where);
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
        $transfer = CustomerTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function passwordReset($param)
    {
        $where['id'] = $param['id'];
        unset($param['id']);
        $param['password'] = pswCrypt($param['password']);
        $transfer = CustomerTask::update($param,$where);
        if (!$transfer->status) {
            return new Transfer('重置失败');
        }
        return new Transfer('', true);
    }
    /**
     * 删除指定资源
     */
    public static function changePassword($param,$where,$type)
    {
        switch ($type){
            case 1:
                $transfer = CustomerTask::valueByWhere($where,'password');
                if(!$transfer->status){
                    return new Transfer('修改密码失败');
                }
                if($transfer->data['password']!==pswCrypt($param['old_password'])){
                    return new Transfer('原密码错误');
                }
                unset($param['repeat_password']);
                unset($param['old_password']);
                $param['password'] = pswCrypt($param['password']);
                $transfer = CustomerTask::update($param,$where);
                if (!$transfer->status) {
                    return new Transfer('重置失败');
                }
                break;
            case 2:
                $transfer = HerdsmanTask::valueByWhere($where,'password');
                if(!$transfer->status){
                    return new Transfer('修改密码失败');
                }
                if($transfer->data['password']!==pswCrypt($param['old_password'])){
                    return new Transfer('原密码错误');
                }
                unset($param['repeat_password']);
                unset($param['old_password']);
                $param['password'] = pswCrypt($param['password']);
                $transfer = HerdsmanTask::update($param,$where);
                if (!$transfer->status) {
                    return new Transfer('重置失败');
                }
                break;
            case 3:
                $transfer = SlaughterManTask::valueByWhere($where,'password');
                if(!$transfer->status){
                    return new Transfer('修改密码失败');
                }
                if($transfer->data['password']!==pswCrypt($param['old_password'])){
                    return new Transfer('原密码错误');
                }
                unset($param['repeat_password']);
                unset($param['old_password']);
                $param['password'] = pswCrypt($param['password']);
                $transfer = SlaughterManTask::update($param,$where);
                if (!$transfer->status) {
                    return new Transfer('重置失败');
                }
                break;
            default:
                return new Transfer('修改密码失败');
        }

        return new Transfer('', true);

    }

    /**
     * 用户信息
     */
    public static function userInfo($param,$where,$type)
    {
        switch ($type){
            case 1:
                $field = 'id,head_img,real_name as name,tel';
                $transfer = CustomerTask::find($where,$field);
                if(!$transfer->status){
                    return new Transfer('获取用户信息失败');
                }
                break;
            case 2:
                $field = 'id,head_img,name,tel,health';
                $transfer = HerdsmanTask::find($where,$field);
                if(!$transfer->status){
                    return new Transfer('获取用户信息失败');
                }
                break;
            case 3:
                $field = 'id,head_img,name,tel,health,prove';
                $transfer = SlaughterManTask::find($where,$field);
                if(!$transfer->status){
                    return new Transfer('获取用户信息失败');
                }
                break;
            default:
                return new Transfer('获取用户信息失败');
        }

        return new Transfer('', true,to_array($transfer->data));

    }

}
