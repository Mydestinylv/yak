<?php

if (!function_exists('fsockopen_ext')) {
    /**
     * [fsockopen_ext description]
     * @author mosquito <zwj1206_hi@163.com> 2018-03-20
     * @param  [type]  $method   [get, post]
     * @param  [type]  $url      [description]
     * @param  [type]  $params   [description]
     * @param  [type]  $header   [description]
     * @param  integer $timeout [description]
     * @param  boolean $wait [description]
     * @return [type]            [description]
     */
    function fsockopen_ext($method, $url, $params = null, $header = null, $timeout = 30, $wait = true)
    {
        try {
            //
            $method = strtoupper($method);
            $purl = parse_url($url);
            if (!$purl['host']) {
                return false;
            }
            isset($purl['scheme']) || $purl['scheme'] = 'http';
            isset($purl['port']) || $purl['port'] = 80;
            isset($purl['path']) || $purl['path'] = '';
            if (isset($purl['query'])) {
                $purl['query'] = '?' . $purl['query'];
            } else {
                $purl['query'] = '';
            }
            if (isset($purl['fragment'])) {
                $purl['fragment'] = '#' . $purl['fragment'];
            } else {
                $purl['fragment'] = '';
            }
            if (is_array($params)) {
                $params_str = http_build_query($params);
            } else {
                $params_str = strval($params);
            }
            if (is_array($header)) {
                if (strpos(current($header), ":") === false) {
                    $into_header = [];
                    foreach ($header as $key => $value) {
                        $into_header[] = "$key: $value";
                    }
                    $header = $into_header;
                }
                $header_str = implode("\r\n", $header);
            } else {
                $header_str = strval($header);
            }

            //创建
            $fp = fsockopen($purl['host'], $purl['port'], $errno, $errstr, $timeout);
            if (!$fp || !is_resource($fp)) {
                return false;
            }
            // stream_set_blocking($fp, 0);
            if (function_exists('socket_set_timeout')) {
                socket_set_timeout($fp, $timeout);
            } elseif (function_exists('stream_set_timeout')) {
                stream_set_timeout($fp, $timeout);
            }

            //组合头信息
            $header = [];
            switch ($method) {
                case 'POST':
                    $header[] = 'POST ' . $purl['path'] . $purl['query'] . $purl['fragment'] . ' HTTP/1.0';
                    $header[] = 'Host: ' . $purl['host'];
                    $header[] = 'Content-type: application/x-www-form-urlencoded';
                    $header[] = 'Content-Length: ' . strlen($params_str);
                    $header_str && $header[] = $header_str;
                    $header[] = "\r\n" . $params_str;
                    $header[] = "\r\n";
                    break;
                case 'GET':
                    if ($params_str) {
                        $purl['query'] = $purl['query'] . ($purl['query'] ? '&' : '?') . $params_str;
                    }
                    $header[] = 'GET ' . $purl['path'] . $purl['query'] . $purl['fragment'] . ' HTTP/1.0';
                    $header[] = 'Host: ' . $purl['host'];
                    $header_str && $header[] = $header_str;
                    $header[] = "\r\n";
                    break;
            }
            $header_str = implode("\r\n", $header);

            //写入数据
            $write = fwrite($fp, $header_str);
            if ($write === false) {
                return false;
            }

            //等待响应
            $result = true;
            if ($wait) {
                while (!feof($fp)) {
                    $line = fread($fp, 4096);
                    $result .= $line;
                }
            }
            fclose($fp);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('to_object')) {
    /**
     * 转换为对象
     * @author mosquito 2017-09-15
     * @param  mixed $mixture [description]
     * @param  integer $depth [description]
     * @return mixed           [description]
     */
    function to_object($mixture = null, $depth = 0)
    {
        $func = function ($mixture, $depth, $depth_count) use (&$func) {
            $obj = new \stdClass();
            if (is_object($mixture)) {
                $mixture = get_object_vars($mixture);
            }
            if (is_array($mixture)) {
                foreach ($mixture as $key => $value) {
                    if (is_array($value)) {
                        if ($depth == 0 || $depth != 0 && $depth_count < $depth) {
                            $value = $func($value, $depth, $depth_count + 1);
                        }
                    }
                    $obj->$key = $value;
                }
            }
            return $obj;
        };
        return $func($mixture, $depth, 1);
    }
}

if (!function_exists('to_array')) {
    /**
     * 转换为数组
     * @param $data
     * @return bool|mixed
     */
    function to_array($data)
    {
        if (!is_object($data) && !is_array($data)) {
            return false;
        }
        return json_decode(json_encode($data, JSON_FORCE_OBJECT), true);
    }
}

if (!function_exists('return_format')) {
    /**
     * 返回自定义 return_format 数据
     */
    function return_format($data = 'fail', $status = false)
    {
        $return['status'] = $status;
        $return['data'] = $data;
        return $return;
    }
}
if (!function_exists('param_exist')) {
    /**
     * 返回自定义 param_exist 数据
     */
    function param_exist($param, $request)
    {
        foreach ($param as $item) {
            if (!isset($request[$item]) || ($request[$item] === '')) {
                return return_format($item);
            }
        }
        return return_format('ok', true);
    }
}
if (!function_exists('is_mobile')) {
    /**
     * 是否是手机号
     * @author mosquito zwj1206_hi@163.com 2018-02-22
     * @param  [type]  $mobile [description]
     * @return boolean         [description]
     */
    function is_mobile($mobile)
    {
        if (preg_match('/^1\d{10}$/', $mobile)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('is_nickname')) {
    /**
     * 是否是字符串的用户名
     * @param $nickname
     * @return bool
     */
    function is_nickname($nickname)
    {
        if (preg_match('/^[a-zA-Z][a-zA-Z0-9_]{3,15}$/', $nickname)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('base64_urlencode')) {
    /**
     * [base64_urlencode description]
     * @author mosquito 2018-01-22
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function base64_urlencode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

if (!function_exists('base64_urldecode')) {
    /**
     * [base64_urldecode description]
     * @author mosquito 2018-01-22
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function base64_urldecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}

if (!function_exists('num_random')) {
    /**
     * 数字随机
     * @author mosquito <zwj1206_hi@163.com> 2018-03-23
     * @param  integer $length [description]
     * @return [type]          [description]
     */
    function num_random($length = 6)
    {
        if ($length < 1) {
            return false;
        }
        $ml = 8;
        $bei = floor($length / $ml);
        $yu = $length % $ml;
        $ret = '';
        if ($bei > 0) {
            while ($bei--) {
                $ret .= str_pad(mt_rand(1, pow(10, $ml) - 1), $ml, '0', STR_PAD_LEFT);
            }
        }
        if ($yu > 0) {
            $ret .= str_pad(mt_rand(1, pow(10, $yu) - 1), $yu, '0', STR_PAD_LEFT);
        }
        return $ret;
    }
}

if (!function_exists('strs_random')) {
    /**
     * 字符串随机
     * @author mosquito <zwj1206_hi@163.com> 2018-05-02
     * @param  integer $length [description]
     * @return [type]          [description]
     */
    function strs_random($length = 16)
    {
        if ($length < 1) {
            return false;
        }
        $chars = 'abcdehilmnrsuvwz0123456789';
        $rand_max = strlen($chars) - 1;
        $ret = '';
        for ($i = 0; $i < $length; $i++) {
            $ret .= $chars[mt_rand(0, $rand_max)];
        }
        return $ret;
    }
}

if (!function_exists('hanzi_random')) {
    /**
     * 汉字随机
     * @author mosquito zwj1206_hi@163.com 2018-02-08
     * @param  integer $num [description]
     * @return [type]       [description]
     */
    function hanzi_random($num = 4)
    {
        for ($i = 0; $i < $num; $i++) {
            $str .= '&#' . rand(19968, 40869) . ';';
        }
        return mb_convert_encoding($str, "UTF-8", "HTML-ENTITIES");
    }
}

if (!function_exists('round_str')) {
    /**
     * [round_str description]
     * @author mosquito <zwj1206_hi@163.com> 2018-03-19
     * @param  [type]  $val       [description]
     * @param  integer $precision [description]
     * @param  [type]  $mode      [description]
     * @return [type]             [description]
     */
    function round_str($val, $precision = 2, $mode = PHP_ROUND_HALF_UP)
    {
        return sprintf('%0.' . $precision . 'f', round($val, $precision, $mode));
    }
}
if (!function_exists('floor_str')) {
    /**
     * [round_str description]
     * @author mosquito <zwj1206_hi@163.com> 2018-03-19
     * @param  [type]  $val       [description]
     * @param  integer $precision [description]
     * @param  [type]  $mode      [description]
     * @return [type]             [description]
     */
    function floor_str($val, $precision = 2)
    {
        for ($i = 0; $i < $precision; $i++) {
            $val *= 10;
        }
        $val = floor($val);
        for ($i = 0; $i < $precision; $i++) {
            $val /= 10;
        }
        return sprintf('%0.' . $precision . 'f', $val);
    }
}

if (!function_exists('order_id')) {
    /**
     * 生成订单号 ，依赖 num_random()
     * @author mosquito zwj1206_hi@163.com 2018-02-23
     * @return [type] [description]
     */
    function order_id($attach = '')
    {
        return date('ymdHis') . num_random(6) . $attach;
    }
}
if (!function_exists('array_format')) {
    /**
     * 返回自定义 array_format 数据，依赖 value_to_string()
     * @author mosquito 2018-02-06
     * @param  mixed $message [description]
     * @param  integer $status [description]
     * @param  mixed $data [description]
     * @return array        [description]
     */
    function array_format($message = null, $status = -1, $result = null, $sum = null)
    {
        is_array($message) && extract($message);
        $ret = array(
            'message' => strval($message),
            'status' => $status,
        );
        $result !== null && $ret['data'] = $result;
        $sum !== null && $ret['sum'] = $sum;

        return $ret;
    }
}
if (!function_exists('json_format')) {
    /**
     * [json_format description]
     * @author mosquito <zwj1206_hi@163.com> 2018-03-19
     * @return [type] [description]
     */
    function json_format($message = null, $status = 0, $result = null, $sum = null)
    {
        array_format($message, $status, $result, $sum);
        // $args = func_get_args();
        return json(
        //array_format(...$args),
            array_format($message, $status, $result, $sum),
            isset($args[4]) ? $args[4] : 200,
            isset($args[5]) ? $args[5] : [],
            isset($args[6]) ? $args[6] : []
        );
    }
}
if (!function_exists('format')) {
    /**
     * [format description]
     * 对响应进行格式化
     * @author mosquito <zwj1206_hi@163.com> 2018-03-19
     * @return [type] [description]jingjinjing
     */
    function format($message = 'error', $status = 400, $data = null)
    {
        $message = (($status === 200) && ($message == '' || $message == 'ok')) ? '成功' : $message;
        is_array($message) && extract($message);
        $data_ret = array(
            'msg' => strval($message),
            'status' => $status,
        );
        $data !== null && $data_ret['data'] = $data;
        return json($data_ret);
    }
}
if (!function_exists('list_format')) {
    /**
     * [list_format description]
     * @author mosquito <zwj1206_hi@163.com> 2018-03-26
     * @param  [type] $paginate [description]
     * @return [type]           [description]
     */
    function list_format($paginate, &$list_data, &$page)
    {
        if ($paginate instanceof LengthAwarePaginator) {
            $paginate = json_decode($paginate->toJson(), true);
            $list_data = $paginate['data'];
            $page = [
                'current_page' => $paginate['current_page'],
                'last_page' => $paginate['last_page'],
                'per_page' => $paginate['per_page'],
                'total' => $paginate['total'],
            ];
        } else {
            $list_data = [];
            $page = [
                'current_page' => 0,
                'last_page' => 0,
                'per_page' => 0,
                'total' => 0,
            ];
        }
        return true;
    }
}

if (!function_exists('base64_image_format')) {
    /**
     * [base64_image_format description]
     * @author mosquito <zwj1206_hi@163.com> 2018-04-21
     * @param  [type] $base64_str [description]
     * @return [type]             [description]
     */
    function base64_image_format($base64_str)
    {
        $image_arr = explode(',', $base64_str);
        $image_str = base64_decode(array_pop($image_arr));
        if (!$image_str) {
            return false;
        }
        $image_info = getimagesizefromstring($image_str);
        if (!$image_info) {
            return false;
        }

        //获取图片后缀
        $suffix_list = array(
            1 => 'gif', 2 => 'jpg', 3 => 'png', 4 => 'swf',
            5 => 'psd', 6 => 'bmp', 7 => 'tiff', 8 => 'tiff',
            9 => 'jpc', 10 => 'jp2', 11 => 'jpf', 12 => 'jb2',
            13 => 'swc', 14 => 'aiff', 15 => 'wbmp', 16 => 'xbm',
        );
        $suffix = $suffix_list[$image_info[2]];
        $suffix || $suffix = 'jpg';

        return [
            'base64_str' => $base64_str,
            'image_str' => $image_str,
            'image_suffix' => $suffix,
            'image_w' => $image_info[0],
            'image_h' => $image_info[1],
            'image_size' => strlen($image_str),
        ];
    }
}

if (!function_exists('is_idcard')) {
    /**
     * [is_idcard description]
     * @author mosquito <zwj1206_hi@163.com> 2018-05-29
     * @param  [type]  $idcard [description]
     * @return boolean         [description]
     */
    function is_idcard($idcard)
    {
        $idcard = strtoupper($idcard);
        $iw = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $szVerCode = "10X98765432";
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $sum += intval($idcard[$i]) * $iw[$i];
        }
        $iy = $sum % 11;
        $bit = $szVerCode[$iy];
        return $bit != $idcard[17] ? false : true;
    }
}

if (!function_exists('idcard_format')) {
    /**
     * [idcard_format description]
     * @author mosquito <zwj1206_hi@163.com> 2018-05-29
     * @param  [type] $idcard [description]
     * @return [type]         [description]
     */
    function idcard_format($idcard)
    {
        if (!$idcard) {
            return false;
        }
        $len = mb_strlen($idcard);
        if ($len != 18) {
            return false;
        }
        preg_match('/^\d{6}(\d{4})(\d{2})(\d{2})\d{2}(\d{1})\S{1}$/', $idcard, $match);
        $birthday = $match[1] . '-' . $match[2] . '-' . $match[3];
        $sex = intval($match[4] % 2 ? 1 : 2);

        return [
            'idcard' => $idcard,
            'birthday' => $birthday,
            'sex' => $sex,
        ];
    }
}
if (!function_exists('long_connection')) {
    function long_connection($url, $data)
    {
        try {
            $client = stream_socket_client($url, $err, $msg, 1);
            fwrite($client, json_encode($data) . "\n");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
if (!function_exists('date_now')) {
    function date_now()
    {
        return date('Y-m-d H:i:s');
    }
}
if (!function_exists('array_tiled')) {
    /**
     * 转换为一维数组
     * @param $array
     */
    function array_tiled(array $array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                unset($array[$key]);
                $array = array_merge($array, $value);
            }
        }
        return $array;
    }
}
if (!function_exists('array_exist')) {
    /**
     * 返回自定义 arr_exist 数据
     * 数组中的元素在另一个数组中是否都存在
     */
    function array_exist($arr, $array)
    {
        foreach ($arr as $item) {
            if (!isset($array[$item]) || ($array[$item] === '')) {
                return new \app\common\lib\Transfer($item . ' 不存在或者为空');
            }
        }
        return new \app\common\lib\Transfer('', true);
    }
}
if (!function_exists('array_key_exist')) {
    /**
     * 返回自定义 arr_exist 数据
     * 数组中的键在另一个数组中是否都存在
     */
    function array_key_exist($arr, $array)
    {
        $arr_key_list = array_keys($arr);
        foreach ($arr_key_list as $item) {
            if (!isset($array[$item]) || ($array[$item] === '')) {
                return new \app\common\lib\Transfer($arr[$item] . ' 不存在或者为空');
            }
        }
        return new \app\common\lib\Transfer('', true);
    }
}
if (!function_exists('array_extract')) {
    /**
     * 返回自定义 arr_exist 数据
     * 数组中的元素在另一个数组中是否都存在
     */
    function array_extract($arr, $array)
    {
        $arr_temp = [];
        foreach ($arr as $key => $item) {
            if (!isset($array[$item]) || ($array[$item] === '')) {
                return new \app\common\lib\Transfer($item . ' 不存在或者为空');
            }
            $arr_temp[$key] = $array[$key];
        }
        return new \app\common\lib\Transfer('', true, $arr_temp);
    }
}
if (!function_exists('exception_record')) {
    /**
     * 返回自定义 arr_exist 数据
     * 数组中的元素在另一个数组中是否都存在
     */
    function exception_record(\Exception $e)
    {
        $file = $e->getFile();
        $line = $e->getLine();
        $message = $e->getMessage();
        $code = $e->getCode();
        $trace_string = $e->getTraceAsString();
        think\Log::error([__CLASS__ . '  ' . __FUNCTION__,
            'failure_desc' => '记录异常信息',
            'attach' => [
                'file' => $file,
                'line' => $line,
                'message' => $message,
                'code' => $code,
                'trace_string' => $trace_string,
            ],
        ]);
        return $message;
    }
}
if (!function_exists('exception_deal')) {
    /**
     * 返回自定义 arr_exist 数据
     * 数组中的元素在另一个数组中是否都存在
     */
    function exception_deal(\Exception $e)
    {
        $app_debug = \think\Env::get('app_debug');
        if ($app_debug) {
            //将异常交给系统处理
            $handle = new \think\exception\Handle();
            $result = $handle->render($e);
            echo $result->getData();
            exit;
        }
        //正式环境 将异常记录日志，返回异常提示信息
        exception_record($e);
        return '页面错误！请稍后再试';
    }
}

if (!function_exists('curl_request')) {
    /**
     *请求数据
     */
    function curl_request($url = '', $data = [], $method = false)
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);//返回response头部信息

        if ($method) {

            $data = json_encode($data, JSON_UNESCAPED_UNICODE);

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        //执行命令
        $datas = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return json_decode($datas, true);
    }

    function curl_request_not_decode($url = '', $data = [], $method = false)
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);//返回response头部信息

        if ($method) {

            $data = json_encode($data, JSON_UNESCAPED_UNICODE);

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        //执行命令
        $datas = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $datas;

    }

    if (!function_exists('curl_request_post')) {
        /**
         *请求数据
         */
        function curl_upload_file($url = '', $data = [], $headers = [])
        {
            $curl = curl_init();
            //设置头信息
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //设置抓取的url
            curl_setopt($curl, CURLOPT_URL, $url);
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);//返回response头部信息

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
            //执行命令
            $data = curl_exec($curl);
            //关闭URL请求
            curl_close($curl);
            //显示获得的数据
            if ($data === false) {
                return new \app\common\lib\Transfer('上传文件失败');
            }
            $result = json_decode($data, true);
            if ($result === null) {
                return new \app\common\lib\Transfer($data);
            }
            if (!isset($result['data'])) {
                \think\Log::error([__CLASS__ . '  ' . __FUNCTION__,
                    'failure_desc' => '上传文件失败',
                    'attach' => $data,
                ]);
                return new \app\common\lib\Transfer('上传文件失败');
            }
            return new \app\common\lib\Transfer('', true, to_array($result['data']));
        }

        //获取数据分析版本
        function getVersion($j = 1)
        {
            $version_num = \think\Env::get('version.version_num');
            for ($i = 0; $i < $version_num; $i++) {

                $data['version_' . $i]['version'] = $i;
                $data['version_' . $i]['user_num_all'] = 0;
                $data['version_' . $i]['data_date'] = date('Y-m-d', strtotime("-$j Day"));
            }
            return $data;
        }

        //获取数据分析时间
        function getDataAnalyDate($day)
        {
            switch ($day) {
                case 1:
                    $date['start_time'] = date('Y-m-d', strtotime('-1 Day'));
                    break;
                case \app\common\model\DataAnalysis::WEEk:
                    $date['start_time'] = date('Y-m-d', strtotime("-$day Day"));
                    break;
                case \app\common\model\DataAnalysis::HALFAMONTH:
                    $date['start_time'] = date('Y-m-d', strtotime("-$day Day"));
                    break;
                case \app\common\model\DataAnalysis::MONTH:
                    $date['start_time'] = date('Y-m-d', strtotime("-$day Day"));
                    break;
                default:
                    $date = [];
                    break;
            }
            $date['end_time'] = date('Y-m-d', strtotime("-1 Day"));
            return $date;
        }


        //日期差取天数
        function date_subtract($start_time, $end_time)
        {
            $start_time = date('Y-m-d', strtotime($start_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            if ($end_time < $start_time) {
                return false;
            }
            $data = (strtotime($end_time) - strtotime($start_time)) / 86400;
            return $data;
        }
    }
    function processing_parametric($url)
    {
        $position = strpos($url, '?');
        if ($position) {
            $url = substr($url, 0, $position);
            return $url;
        } else {
            return $url;
        }
    }

    if (!function_exists('arr_foreach')) {
        /**
         * 多维数组取值
         */
        function arr_foreach($arr)
        {
            if (!is_array($arr)) {
                return false;
            }
            $result = [];
            foreach ($arr as $key => $val) {
                if (is_array($val)) {
                    $result = array_merge($result, (array)arr_foreach($val));
                } else {
                    $result = array_merge($result, (array)$val);
                }
            }
            return $result;
        }
    }

    if (!function_exists('arr_str')) {
        /**
         * 数组的值转换
         * */
        function arr_str($arr)
        {
            foreach ($arr as $key => $value) {
                $arr[$key] = (string)$value;
            }
            return $arr;
        }
    }
    if (!function_exists('img_upload')) {
        /**
         * 文件上传
         * */
        function img_upload($img)
        {
            if ($img) {
                $info = $img->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $image_url = ROOT_PATH . 'public' . DS . 'uploads' . DS . $info->getSaveName();
                    return $image_url;
                } else {
                    // 上传失败获取错误信息
                    echo $img->getError();
                }
            }
        }
    }
    if (!function_exists('datetime_conversion')) {
        /**
         * 数组的值转换
         * */
        function datetime_conversion($time)
        {
            if (empty($time)) {
                return $time = NULL;
            } else {
                return $time;
            }
        }
    }

    if (!function_exists('get_salt')) {
        /**
         * 后台用户密码加密
         * */
        function get_salt()
        {
            $salt = '';
            $length = 6;
            $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < $length; ++$i) {
                $salt .= $pattern{mt_rand(0, 61)};
            }
            return $salt;
        }
    }

    if (!function_exists('password_encryption')) {
        /**
         * 后台用户密码加密
         * */
        function password_encryption($password, $salt)
        {
            if (!empty($password)) {

                $password = md5(md5($password) . md5($salt));
                return $password;
            }
        }
    }

    function get_token()
    {
        $token = '';
        for ($i = 1000; $i > 0; $i--) {
            $str_random = strtotime('now') . strs_random();
            $access_token = hash('sha512', $str_random, false);
            break;
        }
        if ($i === 0) {
            \think\Log::error([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '获取token失败',
                'attach' => compact(['i', 'token']),
            ]);
            return new \app\common\lib\Transfer('获取token失败');
        }
        return new \app\common\lib\Transfer('获取token成功', true, compact('access_token'));
    }

    /**
     * 创建一个订单号
     */
    function getOrderCode()
    {
        $order_code = '';
        for ($i = 1000; $i > 0; $i--) {
            $order_code = strtotime('now') . num_random(9);
            $transfer = \app\common\task\SaleOrderTask::count(['order_code' => $order_code]);
            if ($transfer->status['count'] == 0) {
                break;
            }
        }
        if ($i === 0) {
            return new \app\common\lib\Transfer('创建订单号失败');
        }
        return new \app\common\lib\Transfer('ok', true, compact('order_code'));
    }
    /**
     * 创建一个订单号
     */
    function getHelpfulCode()
    {
        $order_code = '';
        for ($i = 1000; $i > 0; $i--) {
            $order_code = strtotime('now') . num_random(9);
            $transfer = \app\common\task\HelpfulListTask::count(['order_code' => $order_code]);
            if ($transfer->status['count'] == 0) {
                break;
            }
        }
        if ($i === 0) {
            return new \app\common\lib\Transfer('创建订单号失败');
        }
        return new \app\common\lib\Transfer('ok', true, compact('order_code'));
    }
    /**
     * 创建一个订单号
     */
    function getAdoptCode()
    {
        $order_code = '';
        for ($i = 1000; $i > 0; $i--) {
            $order_code = strtotime('now') . num_random(9);
            $transfer = \app\common\task\AdoptionOrderTask::count(['order_number' => $order_code]);
            if ($transfer->status['count'] == 0) {
                break;
            }
        }
        if ($i === 0) {
            return new \app\common\lib\Transfer('创建订单号失败');
        }
        return new \app\common\lib\Transfer('ok', true, compact('order_code'));
    }
    /**
     * 获取token
     */
    function getAccessToken()
    {
        $appid = \think\Config::get('wechat_pay.appid');
        $appsecret = \think\Config::get('wechat_pay.appsecret');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        // 微信返回的信息
        $returnData = curlHttp($url);
        $resData['accessToken'] = $returnData['access_token'];
        $resData['expiresIn'] = $returnData['expires_in'];
        $resData['time'] = date("Y-m-d H:i", time());

        $res = $resData;
        return $res;
    }
    /**
     * 获取ticket
     */
    function getJsApiTicket($accessToken)
    {

        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&&type=jsapi";
        // 微信返回的信息
        $returnData = curlHttp($url);
        $resData['ticket'] = $returnData['ticket'];
        $resData['expiresIn'] = $returnData['expires_in'];
        $resData['time'] = date("Y-m-d H:i", time());
        $resData['errcode'] = $returnData['errcode'];

        return $resData;
    }

    function curlHttp($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($curl);
        curl_close($curl);
        return json_decode($res,true);
    }

    // 获取签名
    function getSignPackage($url)
    {
        // 获取token
        $token = getAccessToken();
        // 获取ticket
        $ticketList = getJsApiTicket($token['accessToken']);
        $ticket = $ticketList['ticket'];
        // 该url为调用jssdk接口的url
        // 生成时间戳
        $timestamp = time();
        // 生成随机字符串
        $nonceStr = createNoncestr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序 j -> n -> t -> u
        $arrdata = array("timestamp" => $timestamp, "noncestr" => $nonceStr, "url" => $url, "jsapi_ticket" => $ticket);
        ksort($arrdata);
        $paramstring = "";
        foreach ($arrdata as $key => $value) {
            if (strlen($paramstring) == 0)
                $paramstring .= $key . "=" . $value;
            else
                $paramstring .= "&" . $key . "=" . $value;
        }
        $signature = sha1($paramstring);
        $signPackage = array(
            "appId" => \think\Config::get('wechat_pay.appid'),
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
        );

        // 返回数据给前端
        return $signPackage;
    }

    // 创建随机字符串
    function createNoncestr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
