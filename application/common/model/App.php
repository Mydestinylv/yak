<?php

namespace app\common\model;

use think\Model;

class App extends Model
{
    
    /**
    * init 事件调用 事件到对应方法中去写  这里保持不动即可
    */
    public static function  init()
    {
        self::event('before_insert', function($object) {
            return $object->beforeInsertCall();
        });
        
        self::event('after_insert', function($object) {
            return $object->afterInsertCall();
        });
        
        self::event('before_update', function($object) {
            return $object->beforeUpdateCall();
        });
        
        self::event('after_update', function($object) {
            return $object->afterUpdateCall();
        });
        
        self::event('before_write', function($object) {
            return $object->beforeWriteCall();
        });
        
        self::event('after_write', function($object) {
            return $object->afterWriteCall();
        });
        
        self::event('before_delete', function($object) {
            return $object->beforeDeleteCall();
        });
        
        self::event('after_delete', function($object) {
            return $object->afterDeleteCall();
        });
        
        self::event('before_restore', function($object) {
            return $object->beforeRestoreCall();
        });
        
        self::event('after_restore', function($object) {
            return $object->afterRestoreCall();
        });
    }
    /**
    * 新增前
    */
    protected function beforeInsertCall()
    {
    }
    
    /**
    * 新增后
    */
    protected function afterInsertCall()
    {
    }
    
    /**
    * 更新前
    */
    protected function beforeUpdateCall()
    { 
    }
    
    /**
    * 更新后
    */
    protected function afterUpdateCall()
    {  
    }
    
    /**
    * 写入前
    */
    protected function beforeWriteCall()
    {
    }
    
    /**
    * 写入后
    */
    protected function afterWriteCall()
    { 
    }
    
    /**
    * 删除前
    */
    protected function beforeDeleteCall()
    {   
    }
    
    /**
    * 删除后
    */
    protected function afterDeleteCall()
    {
    }
    
    /**
    * 恢复前
    */
    protected function beforeRestoreCall()
    {        
    }
    
    /**
    * 恢复后
    */
    protected function afterRestoreCall()
    {        
    }
    
    
}
