<?php

namespace app\move\controller;

use app\common\controller\App;
use app\move\action\ChatAction;
use think\Request;
use think\Log;

class Chat extends App
{
    /**
     * 显示资源列表
     */
    public function index(Request $request)
    {
        try {
            $param = $request->param();
            $result = $this->validate($param, 'app\move\validate\Chat.index');
            if ($result !== true) {
                return format($result);
            }
            switch (TYPE){
                case 1 :
                    $where['customer_id'] = CID;
                    break;
                case 2 :
                    $where['herdsman_id'] = HID;

                    break;
                case 3 :
                    $where['slaughter_man_id'] = SID;
                    break;
                default :
                    return format('获取资源失败');
            }
            $transfer = ChatAction::index($param,$where);
            if (!$transfer->status) {
                $message = $transfer->message ?: '显示资源列表失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '获取资源列表失败',
                        'attach' => compact(['param', 'transfer']),
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
            $result = $this->validate($param, 'app\move\validate\Chat.save');
            if ($result !== true) {
                return format($result);
            }
            $transfer = ChatAction::save($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '保存资源失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '保存资源失败',
                        'attach' => compact(['param', 'transfer']),
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
            $result = $this->validate($param, 'app\move\validate\Chat.read');
            if ($result !== true) {
                return format($result);
            }
            $transfer = ChatAction::read($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '显示指定的资源失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '显示指定的资源失败',
                        'attach' => compact(['param', 'transfer']),
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
            $result = $this->validate($param, 'app\move\validate\Chat.update');
            if ($result !== true) {
                return format($result);
            }
            $transfer = ChatAction::update($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '保存更新的资源失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '保存更新的资源失败',
                        'attach' => compact(['param', 'transfer']),
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
            $result = $this->validate($param, 'app\move\validate\Chat.delete');
            if ($result !== true) {
                return format($result);
            }
            $transfer = ChatAction::delete($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '保存更新的资源失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '删除指定资源失败',
                        'attach' => compact(['param', 'transfer']),
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
