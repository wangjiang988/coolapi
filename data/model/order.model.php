<?php
/**
 * 用户逻辑层
*
*/
class OrderModel extends Model
{
    
    public function __construct() {
        parent::__construct('order');
    }
    
    
    
    //根据openID 找到order列表
    public function getOrderListByOpenId($openid,$pagesize,$field = '*')
    {
        
        $param = array('openid'=>$openid);
        
        return $this->field($field)->where($param)->page($pagesize)->limit('')->select();
    }
    
    //根据用户openid,订单ID 得到用户订单
    public function getUserOrderById($order_id , $loginUser)
    {
        $where  =   array(
            'order_id'    =>   $order_id,
            'openid'      =>   $loginUser['openid'],
        );
        
        $order =  $this->where($where)->select();
        
        foreach ($order as $k => $o)
        {
            if(empty($o['preview_url']))
            {
                $goods   =   Model('goods')->getById($o['goods_id']);
                if($goods)
                    $order[$k]['preview_url']   = fixUploadPath($goods['result']['goods_img']);
            }
        }
        
        if(is_array($order)  &&  count($order) == 1) 
            return $order[0];
        else{
            return $order;
        }
    }
    
}