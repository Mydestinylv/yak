<?php

namespace app\common\model;

use think\Db;
use think\Model;
use traits\model\SoftDelete;

class HelpfulProject extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getHelpfulProjectStatusAttr($value)
    {
        $array = [1 => '正常', 2 => '已截止'];
        return $array[$value];
    }
    public function getHelpfulTypeAttr($value)
    {
        $array = [1 => '疾病帮扶', 2 => '贫困帮扶'];
        return $array[$value];
    }

    public static function GetHelpfulProject($params){
        try{
            $list = self::field("id,project_title,project_content,project_cover,helpful_project_status,end_time")
                ->where('helpful_type',$params['helpful_type'] == 1 ? 1 : 2);
            $limit=!empty($params['limit'])?$params['limit']:10;
            $list=$list->paginate($limit,false,[
                "page"=>!empty($params['page'])?$params['page']:1
            ])->each(function($item, $key){
                $item['help_info'] = Db::name('helpful_list')
                    ->field('COUNT(`id`) AS num,SUM(`helpful_price`) AS money')
                    ->where('helpful_project_id',$item['id'])
                    ->find();
                return $item;
            });
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        $list_items=$list->items();
        if(empty($list_items)){
            return ['data'=>[],'count'=>0,'code'=>200];
        }
        return ['data'=>$list_items,'count'=>$list->total(),'code'=>200];
    }

}
