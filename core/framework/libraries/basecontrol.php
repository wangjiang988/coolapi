<?php
/**
 * @author wangjiang
 * 控制器基类
 */

class BaseControl
{
    private $request;
    
    private $post;
    
    private $get;
    
    public function __construct()
    {
        $request = new Request();
        $this->setRequest($request);
        $this->get = $request->getGet();
        $this->post= $request->getPost();
    }
    
    public function setRequest($request)
    {
        $this->request  =   $request;
    }
    
    
    public function getRequest()
    {
        return $this->request;
    }
    
    
    
}