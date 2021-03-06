<?php

namespace app\common\model;

use think\Db;
use think\Exception;
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

    /*
     * 查询最新的状态为需要帮扶的一个记录
     * */

    public static function GetOneHelpful()
    {
        try{
            $list = self::where('helpful_project_status',1)
                ->field('id,project_title,project_content,project_cover,helpful_project_status,end_time')
                ->order('create_time desc')
                ->limit(1)
                ->select();
            $list[0]['help_info'] = Db::name('helpful_list')
                ->field('COUNT(`id`) AS num,SUM(`helpful_price`) AS money')
                ->where('helpful_project_id',$list[0]['id'])
                ->find();
            return ['code'=>200,'msg'=>$list[0]];
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }

    }

    /*
     * 查询帮扶详情
     * */
    public static function GetHelpfulDetails($params)
    {
        try{
            $info = self::where('id',$params['helpful_id'])->find();
            $help_list = HelpfulList::GetHelpDetails($params['helpful_id']);
            if($help_list['code']==400){
                return ['code'=>400,'msg'=>$help_list['msg']];
            }
            $info['help_list'] = $help_list['msg'];
            return ['code'=>200,'msg'=>$info];
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }

    }

}
