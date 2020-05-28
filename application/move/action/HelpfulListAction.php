<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\HelpfulList;
use app\common\sub_action\HelpfulListSubAction;
use app\common\task\HelpfulListTask;

class HelpfulListAction
{
    /**
     * 显示资源列表
     */
    public static function index($param, $customer_id)
    {
        $where['customer_id'] = $customer_id;
        $field = 'b.project_cover,b.project_title,a.helpful_price,a.create_time';
        $transfer = HelpfulList::alias('a')
            ->join('Helpful_project b', 'a.helpful_project_id = b.id', 'lEFT')
            ->where($where)
            ->field($field)
            ->paginate();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        $data = to_array($transfer);
        return new Transfer('', true, $data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {

        return new Transfer('', true);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {

        return new Transfer('', true);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {

        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {

        return new Transfer('', true);
    }

}
