<?php
/**
 * 用户逻辑层
*
*/
class GoodsModel extends Model
{
    
    public function __construct() {
        parent::__construct('goods');
    }
    
    
    
    //根据ID 找到用户
    public function getGoodsById($id,$field="*")
    {
        $param = array($this->get_pk()=>$id,'state'=>'1');
        $goods  =   $this->field($field)->where($param)->find();
        $goods['goods_img']  = fixUploadPath( $goods['goods_img']);
        return $goods;
    }
    /**
     * 得到热销产品
     */
    public function getHotGoodsList($pagesize=10){
        $list   = $this->where(array('promotion'=>'1','state'=>'1'))->page($pagesize)->limit('')->select();
        foreach ($list as $key => $value) {
            $list[$key]['goods_img'] = fixUploadPath($value['goods_img']) ;
        }
        return $list;
    }
    
    /**
     * 根据类别找到商品列表
     */
    
    public function getGoodsListByCategory($category,$pagesize=10)
    {
        $list   = $this->where(array('cate_id'=>$category['id'],'state'=>'1'))->page($pagesize)->limit('')->select();
        foreach ($list as $key => $value) {
            $list[$key]['goods_img'] = fixUploadPath($value['goods_img']) ;
        }
        return $list;
    }
    
    /**
     * 返回查询结果
     * @param unknown $keyword
     */
    public function search($keyword, $field="*",$pagesize =10)
    {
//         $where   =  "(goods_name like '%{$keyword}%' or details like '%{$keyword}%') and state ='1' "; 
        $where   =  "(goods_name like '%{$keyword}%') and state ='1' "; 
        $result  =  $this->field($field)->where($where)->page($pagesize)->select();
        foreach ($result as $k =>$goods)
        {
            $result[$k]['goods_img']    =    fixUploadPath($goods['goods_img']);
        }
        return $result;
    }

}