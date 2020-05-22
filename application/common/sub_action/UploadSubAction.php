<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;

class UploadSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = img_upload($param['file']);
        if ($transfer === false) {
            return new Transfer('上传失败');
        }
        return new Transfer('', true, ['file_url'=>$transfer]);
    }
}
