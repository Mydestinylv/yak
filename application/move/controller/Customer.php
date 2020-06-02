<?php

namespace app\move\controller;

use app\common\controller\App;
use app\common\sub_action\CustomerSubAction;
use app\move\action\CustomerAction;
use think\Controller;
use think\Request;
use think\Log;

class Customer extends App
{
    /**
     * 显示资源列表
     */
    public function index(Request $request)
    {
        try {
            $param = $request->param();
            $result = $this->validate($param, 'app\move\validate\Customer.index');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerSubAction::index($param);
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
            $param = $request->param();
            $result = $this->validate($param, 'app\move\validate\Customer.save');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerSubAction::save($param);
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
            $result = $this->validate($param, 'app\move\validate\Customer.read');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerSubAction::read($param);
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
            $result = $this->validate($param, 'app\move\validate\Customer.update');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerSubAction::update($param);
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
            $result = $this->validate($param, 'app\move\validate\Customer.delete');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerSubAction::delete($param);
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

    /**
     * 修改密码
     */
    public function changePassword(Request $request)
    {
        try {
            $param = $request->post();
            $result = $this->validate($param, 'app\move\validate\Customer.changePassword');
            if ($result !== true) {
                return format($result);
            }
            switch (TYPE) {
                case 1:
                    $where['id'] = CID;
                    break;
                case 2:
                    $where['id'] = HID;
                    break;
                case 3:
                    $where['id'] = SID;
                    break;
                default:
                    return format('修改密码失败',200);
            }
            $transfer = CustomerAction::changePassword($param,$where,TYPE);
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

    /**
     * 密码重置
     */
    public function passwordReset(Request $request)
    {
        try {
            $param = $request->post();
            $result = $this->validate($param, 'app\move\validate\Customer.PasswordReset');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerAction::passwordReset($param, CID);
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

    /**
     * 用户信息
     */
    public function userInfo(Request $request)
    {
        try {
            $param = $request->post();
            $result = $this->validate($param, 'app\move\validate\Customer.userInfo');
            if ($result !== true) {
                return format($result);
            }
            switch (TYPE) {
                case 1:
                    $where['id'] = CID;
                    break;
                case 2:
                    $where['id'] = HID;
                    break;
                case 3:
                    $where['id'] = SID;
                    break;
                default:
                    return format('获取用户信息失败',200);
            }
            $transfer = CustomerAction::userInfo($param,$where,TYPE);
            if (!$transfer->status) {
                $message = $transfer->message ?: '获取用户信息失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '获取用户信息失败',
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
     * 发送短信
     */
    public function sendSms(Request $request)
    {
        try {
            $param = $request->post();
            $result = $this->validate($param, 'app\move\validate\Customer.sendSms');
            if ($result !== true) {
                return format($result);
            }
            $transfer = CustomerAction::sendSms($param, CID);
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
