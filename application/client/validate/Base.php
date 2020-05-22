<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/22
 * Time: 11:32
 */

namespace app\client\validate;


use think\Validate;

class Base extends Validate
{
    /***
     * 身份证真实性验证规则
     */
    protected function checkMobile($mobile)
    {
        $check = '/^1([38][0-9]|4[579]|5[0-3,5-9]|6[6]|7[0135678]|9[89])\d{8}$/';
        if (preg_match($check, $mobile)) {
            return true;
        } else {
            return false;
        }
    }

    /***
     * 身份证真实性验证规则
     * 正则表达式6-16位字符（英文/数字/符号）至少两种或下划线组合
     */
    protected function checkpwd($pwd)
    {
        $check = '/^(\w*(?=\w*\d)(?=\w*[A-Za-z])\w*){6,16}$/';
        if (preg_match($check, $pwd)) {
            return true;
        } else {
            return false;
        }
    }
}