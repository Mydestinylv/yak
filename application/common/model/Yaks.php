<?php

namespace app\common\model;

use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class Yaks extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';


    public function getIsAdoptionAttr($value)
    {
        $array = [1 => '未认养', 2 => '已认养'];
        return $array[$value];
    }
    public function getYaksTypeAttr($value)
    {
        $array = [1 => '食用认养', 2 => '投资认养'];
        return $array[$value];
    }
    public function getYaksSexAttr($value)
    {
        $array = [0 => '母', 1 => '公'];
        return $array[$value];
    }

    public function getInvestTypeAttr($value)
    {
        $array = [0 => '投资认养', 1 => '食用认养'];
        return $array[$value];
    }

    /*
     * 一对一关联查询未领养牦牛牧场信息
     * */
    public function adopt()
    {
        return $this->hasOne('Pasture','id','pasture_id')->field('id,pasture_name,pasture_address');
    }

    /*
     * 一对一关联查询未领养牦牛牧场信息
     * */
    public function details()
    {
        return $this->hasOne('VideoSurveillance','pasture_id','pasture_id')->field('id,pasture_id,viewing_address,surveillance_name');
    }

    public static function GetAdoptYaks($params){
        try{
            $list = self::with('adopt')
                ->field("*,YEAR( FROM_DAYS( DATEDIFF( NOW( ), yaks_birthday))) AS age")
                ->where('yaks_sex',$params['invest_type'] == 1 ? 1 : 0)
                ->where('is_adoption',1);
            $limit=!empty($params['limit'])?$params['limit']:10;
            $list=$list->paginate($limit,false,[
                "page"=>!empty($params['page'])?$params['page']:1
            ]);
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        $list_items=$list->items();
        if(empty($list_items)){
            return ['data'=>[],'count'=>0,'code'=>200];
        }
        return ['data'=>$list_items,'count'=>$list->total(),'code'=>200];
    }

    /*
     * 认领牦牛详情查询
     * */
    public static function GetYaksDetails($params)
    {
        $id = $params['yaks_id'];
        try{
            $info = self::with('details')
                ->field('*,is_adoption as confirm,yaks_sex as invest_type,YEAR( FROM_DAYS( DATEDIFF( NOW( ), yaks_birthday))) AS age')
                ->where('id',$id)
                ->find();
            if($info['confirm']!=1) return ['data'=>'该牦牛不是未认养状态！','code'=>400];
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        return ['data'=>$info,'code'=>200];
    }

    /*
     * 判断当前牦牛是否被认养
     * */
    public static function IsAdopt($params)
    {
        $id = $params['yaks_id'];
        try{
            $info = self::field('id,yaks_name,is_adoption as confirm')
                ->where('id',$id)
                ->find();
            if($info['confirm']!=1) return ['data'=>'该牦牛不是未认养状态！','code'=>400];
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        return ['data'=>$info,'code'=>200];
    }
}
