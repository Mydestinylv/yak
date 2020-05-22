<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// 准许跨域请求。

function pr($var) {
	if (config('app_debug')) {
		$template = PHP_SAPI !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
		printf($template, print_r($var, true));
	}
}
// layui-table固定返回数据格式
function layui($value){
	$layuiData['code'] = 0 ; #code值必须为0
	$layuiData['msg'] = '';
	$layuiData['count'] = count($value);
	$layuiData['data'] = $value;
	return $layuiData;
}
#ajax 请求返回格式
function ajaxR($code = 0,$msg = '',$data =[]){

	return ['code'=>$code,'msg'=>$msg,'data'=>$data];
}

