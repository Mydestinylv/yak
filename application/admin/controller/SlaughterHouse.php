<?php

namespace app\admin\controller;

use app\admin\action\SlaughterHouseAction;
use app\common\controller\Admin;
use think\Request;
use think\Log;
class SlaughterHouse extends Admin
{
    /**
     * 显示资源列表
     */
    public function index(Request $request)
    {
        try {
            $param = $request->param();
            $result = $this->validate($param, 'app\admin\validate\SlaughterHouse.index');
            if ($result !== true) {
                return format($result);
            }
            $transfer = SlaughterHouseAction::index($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '显示资源列表失败';
                if($this->environment==='test'){
                     return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                }else{
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '获取资源列表失败',
                        'attach' => compact(['param','transfer']),
                    ]);
                    return format($message);
                }
            }
            return format('ok', 200, $transfer->data);
        } catch (\Exception $e) {
            return format(exception_deal($e), 400);
        }
    }

    /**
     * 保存新建的资源
     */
    public function save(Request $request)
    {
        try {
            $param = $request->post();
            $param['slaughter_house_cover'] = Request()->file('slaughter_house_cover');
            $result = $this->validate($param,'app\admin\validate\SlaughterHouse.save');
            if ($result !== true) {
                return format($result);
            }
            $transfer = SlaughterHouseAction::save($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '保存资源失败';
                if($this->environment==='test'){
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                }else{
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '保存资源失败',
                        'attach' => compact(['param','transfer']),
                    ]);
                    return format($message);
                }
            }
            return format('ok', 200, $transfer->data);
        } catch (\Exception $e) {
            return format(exception_deal($e), 400);
        }

    }

    /**
     * 显示指定的资源
     */
    public function read(Request $request)
    {
        try {
            $param = $request->param();
            $result = $this->validate($param,'app\admin\validate\SlaughterHouse.read');
            if ($result !== true) {
                return format($result);
            }
            $transfer = SlaughterHouseAction::read($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '显示指定的资源失败';
                if($this->environment==='test'){
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                }else{
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '显示指定的资源失败',
                        'attach' => compact(['param','transfer']),
                    ]);
                     return format($message);
                }
            }
            return format('ok', 200, $transfer->data);
        } catch (\Exception $e) {
            return format(exception_deal($e), 400);
        }
    }

    /**
     * 保存更新的资源
     */
    public function update(Request $request)
    {
        try {
            $param = $request->post();
            $param['slaughter_house_cover'] = Request()->file('slaughter_house_cover');
            $result = $this->validate($param,'app\admin\validate\SlaughterHouse.update');
            if ($result !== true) {
                return format($result);
            }
            $transfer = SlaughterHouseAction::update($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '保存更新的资源失败';
                if($this->environment==='test'){
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                }else{
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '保存更新的资源失败',
                        'attach' => compact(['param','transfer']),
                    ]);
                    return format($message);
                }
            }
            return format('ok', 200, $transfer->data);
        } catch (\Exception $e) {
            return format(exception_deal($e), 400);
        }
    }

    /**
     * 删除指定资源
     */
    public function delete(Request $request)
    {
        try {
            $param = $request->param();
            $result = $this->validate($param,'app\admin\validate\SlaughterHouse.delete');
            if ($result !== true) {
                return format($result);
            }
            $transfer = SlaughterHouseAction::delete($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '保存更新的资源失败';
                if($this->environment==='test'){
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                }else{
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '删除指定资源失败',
                        'attach' => compact(['param','transfer']),
                    ]);
                    return format($message);
                }
            }
            return format('ok', 200, $transfer->data);
        } catch (\Exception $e) {
            return format(exception_deal($e), 400);
        }
    }
}
