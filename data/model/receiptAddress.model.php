<?php
/**
 * 用户逻辑层
*
*/
class ReceiptAddressModel extends Model
{
    
    public function __construct() {
        parent::__construct('receipt_address');
    }
    
    
    //根据openID 找到地址列表
    public function getAddresListByOpenId($openid,$pagesize)
    {
        
        $param = array('openid'=>$openid);
        return $this->where($param)->page($pagesize)->limit('')->select();
    }
    
    public function getByID($id)
    {
        $param    =  array('id'=>$id);
        $address  =   $this->where($param)->find();
        if(!empty($address)){
            $address['province']  =   Model('province')->getById($address['province']);
            $address['city']  =   Model('city')->getById($address['city']);
            $address['area']  =   Model('district')->getById($address['area']);
        }
        return $address;
    }
    
    public function getDefaultAddress($loginUser)
    {
        $param     =   array('openid'=>$loginUser['openid'],'default_state'=>'1');
        return $this->where($param)->find();
    }
    
    public function addAddress($address)
    {
        $id =  $this->insert($address);
        return array('id'=>$id);
    }
    
    public function modifyAddress($address)
    {
        $result =  $this->update($address);
        return array('result'=>$result);
    }
    
    
    public function setDefaultById($id,$loginUser)
    {
        //先删除掉之前的默认地址，然后将再设置当前地址为默认地址
        $where  =  array('openid'=>$loginUser['openid']);
        $update =  array('default_state'=>'0');
        $ret    =  $this->where($where)->update($update);
        if(!$ret) ajaxReturn('设置失败',603);
        $update2=  array('default_state'=>'1');
        $where2 =  array('openid'=>$loginUser['openid'],'id'=>$id);
        $ret2   =  $this->where($where2)->update($update2);
        if(!$ret2) ajaxReturn('设置失败',603);
        return $ret2;
    }
}