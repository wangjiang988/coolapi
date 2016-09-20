<?php
/**
 * 权限管理
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2015-2016 wj (###)
 * @license    ###
 * @link       ###
 * @since      File available since Release v1.1
 */
defined('CoolAPI') or exit('Access Invalid!');

class goodsControl extends SystemControl{
	 
	public function __construct(){
		parent::__construct();
	}

	
	/**
	 *  根据分类ID得到商品分类及分类下商品
	 */
	public function getGoodsByCategoryOp(){
	    $id         =  isset($_GET['id'])?$_GET['id']:$_POST['id'];
	    Validator::has($id,'id');
	    Validator::isNumber($id,'int','id');
	    
	    $model      =  Model('category');
	    $category   =  $model->getCategoryById($id);
	    if(empty($category)) ajaxReturn('没有这个类别,或者该类别已下架',203);
	    $model_goods=  Model('goods');
        $goodsList  =  $model_goods->getGoodsListByCategory($category,10);
        if($goodsList){
            ajaxReturn(L('200'),200,$goodsList,$model_goods->getPager(),$category);
        }else{
            ajaxReturn("该类目下暂无商品",200,$goodsList,$model_goods->getPager(),$category);
        }
	}
	
	/**
	 * 商品详情
	 */
	
	public function getGoodsOp()
	{
	    $id         =  isset($_GET['id'])?$_GET['id']:$_POST['id'];
	    Validator::has($id,'id');
	    Validator::isNumber($id,'int','id');
	    
	    $model      =  Model('goods');
	    $goods      =  $model->getGoodsById($id);
	    if(empty($goods)) ajaxReturn('没有这个商品,或者该商品已下架',203);
	    
	    $category   =  Model('category')->getCategoryById($goods['cate_id']);
	    if(empty($category)) ajaxReturn('没有这个类别,或者该类别已下架',203);
	    ajaxReturn(L('E200'),200,$goods,NULL,$category);
	}
	
	/**
	 * 得到热销产品
	 * 
	 */
	public function getHotGoodsListOp()
	{
	    $model_goods=  Model('goods');
	    $goodsList  =  $model_goods->getHotGoodsList(10); //每页显示10个
	    
	    if(empty($goodsList)) ajaxReturn(L('E203'),203);
	    ajaxReturn(L('E200'),200,$goodsList,$model_goods->getPager());
	}
	
	/**
	 * 商品查询
	 */
	
	public function searchOp()
	{
	    $keywords        =  isset($_GET['keywords'])?$_GET['keywords']:$_POST['keywords'];
	    Validator::has($keywords,'keywords');
	    
	    $model           =  Model('goods');
	    $goodsList       =  $model->search($keywords);
	    
	    if(empty($goodsList)) ajaxReturn('查询无结果',203);
	    ajaxReturn(L('E200'),200,$goodsList,$model->getPager());
	}
	
	
	/**
	 * 辅助字段插入
	 * 接受字段 type,goods_id,content,price
	 */
	public function addGoodsInfoOp()
	{
	    $post      =  $this->getRequest()->post;
	    
	    //判断是否重复提交表单,防止csrf;
	    if(isset($post['token']))
	    {
	        $this->checkToken($post['token']);
	    }else{
	        ajaxReturn(L('E600'),600);
	    }
	    
	    $type  =  isset($_GET['type'])?$_GET['type']:$_POST['type'];
	    
	    Validator::has($type,'type');
	    
	    if(!in_array($type , array('crafts','detail','material'))){
	        ajaxReturn('type类型不合法',300);
	    }
	    
	    $data              =  array();
	    $data['goods_id']  =  Validator::isNumber($post['goods_id'],'int','goods_id');
	    $data['content']   =  Validator::encode(Validator::has($post['content'],'content'));
	    $data['price']     =  Validator::isNumber($post['price'],'all','price');
	    
	    $id   =  Model($type)->insert($data);  
	    
	    if($id)
	        ajaxReturn(L('E200'),200,array('id'=>$id,'type'=>$type));
	    else
	        ajaxReturn(L('E603'),603);
	}
	
	/**
	 * 根据goods_id 得到商品的定制信息
	 */
	
	public function getGoodsInfoOp()
	{
	    $id         =  isset($_GET['goods_id'])?$_GET['goods_id']:$_POST['goods_id'];
	    Validator::isNumber($id,'int','goods_id');
	    
	    $model      =  Model('goods');
	    $goods      =  $model->getGoodsById($id,'id,goods_name,goods_stock,goods_img,goods_price,goods_custom,custom_gift,cate_id');
	    if(empty($goods)) ajaxReturn('没有这个商品,或者该商品已下架',203);
	    $goods['crafts']   =  Model('crafts')->where(array('goods_id'=>$id))->select();
	    $goods['material'] =  Model('material')->where(array('goods_id'=>$id))->select();
	    $goods['detail']   =  Model('detail')->where(array('goods_id'=>$id))->select();
	    $category          =  Model('category')->getCategoryById($goods['cate_id']);
	    if(empty($category)) ajaxReturn('没有这个类别,或者该类别已下架',203);
	    ajaxReturn(L('E200'),200,$goods,NULL,$category);
	}
    
	 
}