<?php

namespace app\common\model;



class Article extends App
{
    //
    
    public function getIsVerifyAttr($value)
    {
        $status = [0=>'未审核',1=>'已审核'];
        return $status[$value];
    }
    
    public function getCreatedAttr($value)
    {
        return date('Y-m-d', $value);
    }
    
    public function setCreatedAttr($value)
    {
        return strtotime($value);
    }
    
}
