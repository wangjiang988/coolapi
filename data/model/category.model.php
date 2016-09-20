<?php
/**
 * 用户逻辑层
*
*/
class categoryModel extends Model
{
    
    public function __construct() {
        parent::__construct('category');
    }
    
    
    
    public function  getAll($field = '*')
    {
        $categories   =  $this->where(array('parent_cate'=>'0','state'=>1))->order('id asc')->select();
        if(empty($categories)) ajaxReturn('表中记录为空',203);
        $list         =  array();
        $upload_path  =    UPLOAD_SITE_URL;
        foreach ($categories as $cat)
        {
            $cat['cate_url']   =   $upload_path.$cat['cate_img'];
            $list[]           =   $cat;
        }
        return $list;
    }
    
    
    //根据ID找到类别
    public function getCategoryById($id)
    {
        $category =  $this->where(array($this->get_pk()=>$id,'state'=>'1'))->find();
        $category['cate_img']  = fixUploadPath( $category['cate_img']);
        return $category;
    }
    
    //根据categoryList
}