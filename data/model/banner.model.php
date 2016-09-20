<?php
/**
 * 用户逻辑层
*
*/
class bannerModel extends Model
{
    
    public function __construct() {
        parent::__construct('banner');
    }
    
    
    
    //根据ID 找到用户
    public function  getAll($field="*")
    {
        $banners      =  $this->order('id asc')->select();
        if(empty($banners)) ajaxReturn('表中记录为空',203);
        $list         =  array();
        $upload_path     =    UPLOAD_SITE_URL;
        foreach ($banners as $banner)
        {
            $goods    =  Model('goods')->getGoodsById($banner['goods_id']);
            if($goods) {
                $banner['ban_url']   =   $upload_path.$banner['ban_img'];
                $list[]              =   $banner;
            }
        }
        return $list;
    }
    
    
    //
}