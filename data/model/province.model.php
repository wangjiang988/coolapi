<?php
/**
 * 用户逻辑层
*
*/
class ProvinceModel extends Model
{
    
    public function __construct() {
        parent::__construct('province');
    }
    
    
    
    //根据ID 找到用户
    public function getNameById($id)
    {
       $param = array($this->get_pk()=>$id);
        $info = $this->where($param)->find();
        return $info['ProvinceName'];
    }
    
}