<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/22
 * Time: 11:41
 */

namespace app\client\common;

use Firebase\JWT\JWT;
use think\Cookie;

class Token
{
    public static function createJwt($id,$iss,$aud)
    {
        $key = md5('nobita'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $token = array(
            "user_id" => $id,
            "iss" => $iss,//签发组织
            "aud" => $aud, //签发作者
            "iat" => $time,
            "nbf" => $time,
        );
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }

    //校验jwt权限API
    public static function verifyJwt($jwt,$iss,$aud,$id)
    {
        $key = md5('nobita');
        try {
            $jwtAuth = json_encode(JWT::decode($jwt, $key, array('HS256')));
            $authInfo = json_decode($jwtAuth, true);
            $msg = [];
            if (!empty($authInfo['user_id']) && $authInfo['iss']==$iss && $authInfo['aud']==$aud && $id==$authInfo['user_id']) {
                $msg = [
                    'code' => 200,
                    'msg' => 'Token验证通过'
                ];
            } else {
                $msg = [
                    'code' => 400,
                    'msg' => 'Token验证不通过,用户不存在'
                ];
            }
            return $msg;
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return['code' => 400, 'msg' => 'Token无效'];
        } catch (\Exception $e) {
            return ['code' => 400, 'msg' => $e->getMessage()];
        }
    }
}