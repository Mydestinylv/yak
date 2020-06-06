<?php

namespace app\move\controller;

use think\Request;
use think\Log;
class Wechat
{
    /**
     * 显示资源列表
     */
    public function index(Request $request)
    {w
        try {
            $param = $request->param();
            $result = $this->validate($param, 'app\move\controller\Wechat.index');
            if ($result !== true) {
                return format($result);
            }
            $transfer = WechatAction::index($param);
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
            $param = $request->param();
            $result = $this->validate($param,'app\move\controller\Wechat.save');
            if ($result !== true) {
                return format($result);
            }
            $transfer = WechatAction::save($param);
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
            $result = $this->validate($param,'app\move\controller\Wechat.read');
            if ($result !== true) {
                return format($result);
            }
            $transfer = WechatAction::read($param);
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
            $param = $request->param();
            $result = $this->validate($param,'app\move\controller\Wechat.update');
            if ($result !== true) {
                return format($result);
            }
            $transfer = WechatAction::update($param);
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
            $result = $this->validate($param,'app\move\controller\Wechat.delete');
            if ($result !== true) {
                return format($result);
            }
            $transfer = WechatAction::delete($param);
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
