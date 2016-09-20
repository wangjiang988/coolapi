<?php
/**
 * 购物车
*
*/
class ShopCartModel extends Model
{
    
    public function __construct() {
        parent::__construct('shop_cart');
    }
    
    
    //根据openID 找到列表
    public function getProductsFromCartByOpenId($openid,$pagesize)
    {
    
       $param = array('openid'=>$openid);
    
        return $this->where($param)->page($pagesize)->limit('')->select();
    }
    
    public function addToCart($info){
        $id  =  $this->insert($info);
        return array('id'=>$id);
    }
    
    /**
     * 修改字段
     * @name $name 字段名
     * @name $value 修改后的值
     */
    public function editField($where , $update)
    {
        return  $this->where($where)->update($update);
    }
}