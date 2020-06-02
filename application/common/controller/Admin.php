<?php

namespace app\common\controller;
use app\common\service\Permission;
use think\Controller;
use think\Env;
use think\Request;

class Admin extends Controller
{
    // 不登录也允许访问的访问
    protected $allowNoLoginAction = [];

    public function _initialize()
    {
        $temp = $this->check_environment();
        if ($temp) {
            return true;
        }

        //登录接口放行
        $tem = $this->allow_api();
        if ($tem) {
            return true;
        }
        $temp = $this->token_check();
        if ($temp) {
            goto permission;
        }
        //权限检查
        permission:
        $request = Request::instance();
        $url = $request->url();
        $temp = Permission::check(AID,$url);
        if(!$temp->status){
            $data = [
                'status' => 400,
                'message' => '权限不足',
            ];
            $data = json_encode($data, 256);
            echo $data;
            exit;
        }
        return true;
    }

    //检查api
    public function allow_api()
    {
        $admin_config = config('common.admin');
        $allow_url = $admin_config['allow_url'];
        $request = Request::instance();
        $url = $request->baseUrl();
        if (in_array($url, $allow_url)) {
            return true;
        }
        return false;
    }
    //检查token
    public function token_check()
    {
        $access_token = cookie('access_token_admin');
        $request = request();
        if (!$access_token) {
            $access_token = $request->header('access_token');
            if (!$access_token) {
                $data = [
                    'status' => 400,
                    'message' => '请登录',
                ];
                $data = json_encode($data, 256);
                echo $data;
                exit;
            }

        }
        $admin_user_id = $request->post('user_id');
        if (!$admin_user_id) {
            $data = [
                'status' => 400,
                'message' => '请登录',
            ];
            $data = json_encode($data, 256);
            echo $data;
            exit;
        }
        define('AID', $admin_user_id);
    }
    public function check_environment()
    {
        if (Env::get('environment') === 'test') {
            $this->environment = 'test';
        }else{
            $this->environment = false;
            return false;
        }
        return true;
    }


}
