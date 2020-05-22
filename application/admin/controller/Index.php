<?php
namespace app\admin\controller;

use app\common\controller\Admin;
use think\Db;
use \think\Route;

class Index extends Admin
{
    public function initialize()
    {
       // $this->allowNoLoginAction = ['login'];
       // parent::initialize();

    }

    public function index()
    {
        $is_login = session('admin');
        if(empty($is_login)){
            pr('password');
            $this->redirect('admin/index/login');
        }
       
    	// if(session('admin')){
     //        pr(session('admin'));
     //        session(null);
     //        pr(session('admin'));
     //        pr('admin');

     //        $this->redirect('admin/manager/login');
    	// }else{

     //        $this->redirect('admin/index/index');
     //        #$this->success('真在跳转登录界面','admin/customer/login');
    	// }
    	
    	
        return $this->fetch();
    }
    public function login()
    {
        
        if($_POST){                   //post接受
            $data['account'] = $_POST['account'];
            $data['password'] =$_POST['password'];
            //s
            $test = Db::name('manager')->where($data)->find();                  //根据data数组查找user表中的对应字段

            if(!$test){                             //如果test不存在
                $this->error('用户名或密码填写错误');
            }else{

                session('admin', $test);
                return ['code'=>1,'msg'=>'success','data'=>''];
            }
        }else{
         return $this->fetch();
        }

    }
    
    public function loginout()
    {
        session('admin',0);
        return $this->success('退出成功');
    }
    public function ifraim()
    {
    	return $this->fetch();
    }
    

}
