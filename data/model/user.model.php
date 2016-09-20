<?php
/**
 * 用户逻辑层
*
*/
class userModel extends Model
{
    
    public function __construct() {
        parent::__construct('user');
    }
    
    
   public function getUserInfo($condition)
   {
       return $this->where($condition)->find();
   }
    
    //根据ID 找到用户
    public function getUserByID($id)
    {
        $param = array('id'=>$id);
        return $this->where($param)->find();
    }
    
}