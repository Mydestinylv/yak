<?php

namespace app\common\task;

use app\common\lib\Transfer;
use think\Log;

class YaksTask
{
    protected static $model = 'app\common\model\Yaks';

    /**
     * 根据主键ID 获取数据
     * $id int 1
     * */
    public static function get($id)
    {
        $model = (self::$model)::get($id);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['id', 'model']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 根据条件 获取数据 (多条数据 只拿一条)
     * $where array ['name' => '1']
     * */
    public static function getByWhere($where)
    {
        $model = (self::$model)::get($where);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 根据主键 获取多条数据
     * $ids array [1, 2, 3]
     * */
    public static function  all($ids)
    {
        $model = (self::$model)::all($ids);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['ids', 'model']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 根据条件 获取多条数据
     * $where array ['name' => '1']
     * */
    public static function  allByWhere($where)
    {
        $model = (self::$model)::all($where);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 获取某个字段的值
     * $where array ['name' => '1'
     * */
    public static function valueByWhere($where, $field)
    {
        $model = (self::$model)::where($where)->value($field);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field']),
            ]);
            return new Transfer('查询数据失败');
        }
        return new Transfer('ok', true,[$field => $model]);
    }

    /**
     * 获取某一列的所有值
     * $where array ['name' => '1']
     * */
    public static function columnByWhere($where, $field)
    {
        $model = (self::$model)::where($where)->column($field);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field']),
            ]);
            return new Transfer('查询数据失败');
        }

        return new Transfer('ok', true, $model);
    }

    /**
     * select查询多条数据, 默认id正序
     * $where array ['name' => '1']
     * */
    public static function select($where, $field = '*', $order = 'id asc')
    {
        $model = (self::$model)::where($where)
            ->field($field)
            ->order($order)
            ->select();
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field', 'order']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * find查询单条数据, 默认id正序
     * $where array ['name' => '1']
     * */
    public static function find($where, $field = '*', $order = 'id asc')
    {
        $model = (self::$model)::where($where)
            ->field($field)
            ->order($order)
            ->find();
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field', 'order']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 统计条数
     * $where array ['name' => '1']
     * */
    public static function count($where)
    {
        $model = (self::$model)::where($where)
            ->count();
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model']),
            ]);
            return new Transfer('查询数据失败');
        }
        return new Transfer('ok', true, ['count' => $model]);
    }

    /**
     * 查询最大值
     * $where array ['name' => '1']
     * */
    public static function max($where, $field)
    {
        $model = (self::$model)::where($where)
            ->max($field);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field']),
            ]);
            return new Transfer('查询数据失败');
        }
        return new Transfer('ok', true, ['max' => $model]);
    }

    /**
     * 查询最小值
     * $where array ['name' => '1']
     * */
    public static function min($where, $field)
    {
        $model = (self::$model)::where($where)
            ->min($field);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field']),
            ]);
            return new Transfer('查询数据失败');
        }
        return new Transfer('ok', true, ['min' => $model]);
    }

    /**
     * 统计平均值
     * $where array ['name' => '1']
     * */
    public static function avg($where, $field)
    {
        $model = (self::$model)::where($where)
            ->avg($field);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field']),
            ]);
            return new Transfer('查询数据失败');
        }
        return new Transfer('ok', true, ['avg' => $model]);
    }

    /**
     * 统计总和
     * $where array ['name' => '1']
     * */
    public static function sum($where, $field)
    {
        $model = (self::$model)::where($where)
            ->sum($field);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field']),
            ]);
            return new Transfer('查询数据失败');
        }
        return new Transfer('ok', true, ['sum' => $model]);
    }

    /**
     * 新增
     * $data array ['name'  =>  '1','email' =>  'xxx@xxx.com']
     * */
    public static function save($data, $id = 'id')
    {
        $model = new self::$model();
        $status = $model->save($data);
        if ($status === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '新增数据失败',
                'attach' => compact(['data', 'status', 'id']),
            ]);
            return new Transfer('新增数据失败');
        }
        $id = $model->$id;
        return new Transfer('ok', true, ['id' => $id]);

    }

    /**
     * 更新
     * $data array ['name'  =>  '1','email' =>  'xxx@xxx.com']
     * save方法第二个参数为更新条件
     * */
    public static function update($data, $where)
    {
        $model = new self::$model();
        $status = $model->save($data, $where);
        if ($status === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '更新数据失败',
                'attach' => compact(['data', 'status', 'where']),
            ]);
            return new Transfer('更新数据失败');
        }
        return new Transfer('ok', true);
    }

    /**
     * 删除, 默认软删除
     * $where array ['name'  =>  '1']
     * */
    public static function delete($where, $status = false)
    {
        $model = (self::$model)::destroy($where, $status);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '删除数据失败',
                'attach' => compact(['status', 'model', 'where']),
            ]);
            return new Transfer('删除数据失败');
        }
        return new Transfer('ok', true);
    }

    /**
     * 分组查询
     * $where array  ['login_status' => 2]
     * $field string 'sum(login_status), id, token'
     * $group string 'id'
     * */
    public static function group($where, $field, $group)
    {
        $model = (self::$model)::where($where)
            ->field($field)
            ->group($group)
            ->select();
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '分组查询失败',
                'attach' => compact(['group', 'model', 'where', 'field']),
            ]);
            return new Transfer('分组查询失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 分页查询多条数据, 默认id正序
     * $where array ['name' => '1']
     * $order string 'id asc'
     * $paginate int 10
     * */
    public static function paginate($where, $field = '*', $order = 'id asc', $paginate = 0)
    {
        //读配置文件
        if (!$paginate) {
            $config = config('paginate');
            $paginate = $config['list_rows'];
        }
        $model = (self::$model)::where($where)
            ->field($field)
            ->order($order)
            ->paginate($paginate);
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '查询数据失败',
                'attach' => compact(['where', 'model', 'field', 'order', 'paginate']),
            ]);
            return new Transfer('查询数据失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }

    /**
     * 关联查询
     * $table array ['table name + alias','table name2 + alias2']
     * $join_file array ['file','file2']
     * $action array ['LEFT or RIGHT or INNER','LEFT or RIGHT or INNER']
     * $where array  ['login_status' => 2]
     * $field string 'sum(login_status), id, token'
     * $group string 'id'
     * */
    public static function Mjoin($table,$join_file,$action,$where, $field, $order = 'create_time',$select = 'paginate')
    {
        $model = (self::$model)::alias('a')
            ->join($table[0],$join_file[0],$action[0])
            ->join($table[1],$join_file[1],$action[1])
            ->where($where)
            ->field($field)
            ->order($order)
            ->$select();
        if ($model === false) {
            Log::alert([__CLASS__ . '  ' . __FUNCTION__,
                'failure_desc' => '关联查询失败',
                'attach' => compact(['table', 'model', 'where', 'field','join_file','action']),
            ]);
            return new Transfer('关联查询失败');
        }
        $model = to_array($model);
        return new Transfer('ok', true, $model == false ? [] : $model);
    }
}
