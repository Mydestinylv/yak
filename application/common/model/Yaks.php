<?php

namespace app\common\model;

use app\common\lib\Transfer;
use app\common\task\AdoptionOrderTask;
use app\common\task\HerdsmanTask;
use app\common\task\PastureTask;
use app\common\task\YaksTask;
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
        $array = [1 => '食用认养', 0 => '投资认养'];
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

    public function getPastureNameAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = PastureTask::valueByWhere(['id'=>$value],'pasture_name');
        return $array->data['pasture_name'];
    }

    public function getHerdsmanNameAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = HerdsmanTask::valueByWhere(['id'=>$value],'name');
        return $array->data['name'];
    }

    public function getAdoptionStatusStrAttr($value)
    {
        $array = AdoptionOrderTask::valueByWhere(['yaks_id'=>$value],'adoption_status');
        $arrays = [1=>'生长中',2=>'待屠宰', 3=>'屠宰中', 4=>'屠宰完毕', 5=>'配送中', 6=>'已收货'];
        if(!isset($arrays[$array->data['adoption_status']])||empty($arrays[$array->data['adoption_status']])){
            return '未认养';
        }
        return $arrays[$array->data['adoption_status']];
    }

    public function getAdoptionStatusAttr($value)
    {
        $arrays = [1=>'生长中',2=>'待屠宰', 3=>'屠宰中', 4=>'屠宰完毕', 5=>'配送中', 6=>'已收货'];
        return $arrays[$value];
    }
    public function getAdoptionIdAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = AdoptionOrderTask::valueByWhere(['yaks_id'=>$value],'id');
        return $array->data['id'];
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

    /*
     * 一对一关联查询未领养牦牛牧场信息
     * */
    public function geth()
    {
        return $this->hasOne('Herdsman','id','pasture_id')->field('*');
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
            $info = self::with('details,adopt,geth')
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

    public static function GetTypeManage($params,$herdsman_id)
    {
        $is_manage = $params['is_manage'];
        try{
            $transfer = AdoptionOrderTask::find(['adoption_status'=>['<>',1]],'GROUP_CONCAT(yaks_id) as yaks_id');
            if(!$transfer->status){
                return new Transfer('查询失败');
            }
            $where['id'] = ['in',explode(',',$transfer->data['yaks_id'])];
            $where['herdsman_id'] = $herdsman_id;
            $list = YaksTask::select($where,'*,pasture_id as pasture_name');
            if(!$list->status){
                return new Transfer('查询失败');
            }
            $list = to_array($list->data);
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        return ['data'=>$list,'code'=>200];
    }

    /*
     * 获取牦牛详情
     * */

    public static function GetYakDetails($params)
    {
        $id = $params['yaks_id'];
        try{
            $info = self::with('adopt')
                ->field('*,is_adoption as confirm,yaks_sex as invest_type,YEAR( FROM_DAYS( DATEDIFF( NOW( ), yaks_birthday))) AS age')
                ->where('id',$id)
                ->find();
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        return ['data'=>$info,'code'=>200];
    }
}
