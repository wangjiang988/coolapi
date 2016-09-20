<?php
/**
 * @author wj
 * Request 类
 */


class Request
{
    
    private $post;
    
    private $get;
    
    private $method;
    
    private $userAgent;
    
    
    public function __construct()
    {
        $this->get   =  $this->getGet();
        $this->post  =  $this->getPost();
    }
    
    public function __get($paramName)
    {
       if($paramName == 'post' ||  $paramName == 'get')
           return $this->$paramName;
       else
       return isset($this->get[$paramName])? $this->get[$paramName]:$this->post[$paramName];
    }
    
    /**
     * Return if the request is sent via secure channel (https).
     * @return boolean if the request is sent via secure channel (https)
     */
    public function getIsSecureConnection()
    {
        return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1)
        || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
    }
    
    
    /**
     * Returns the server name.
     * @return string server name, null if not available
     */
    public function getServerName()
    {
        return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null;
    }
    
    /**
     * Returns the server port number.
     * @return integer server port number, null if not available
     */
    public function getServerPort()
    {
        return isset($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : null;
    }
    
    /**
     * Returns the URL referrer.
     * @return string URL referrer, null if not available
     */
    public function getReferrer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }
    
    /**
     * Returns the user agent.
     * @return string user agent, null if not available
     */
    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }
    
    /**
     * Returns the user IP address.
     * @return string user IP address, null if not available
     */
    public function getUserIP()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }
    
    /**
     * Returns the user host name.
     * @return string user host name, null if not available
     */
    public function getUserHost()
    {
        return isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null;
    }
    
    /**
     * @return string the username sent via HTTP authentication, null if the username is not given
     */
    public function getAuthUser()
    {
        return isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
    }
    
    /**
     * @return string the password sent via HTTP authentication, null if the password is not given
     */
    public function getAuthPassword()
    {
        return isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;
    }
    
    
    public function getGet()
    {
        return $_GET;
    }
    
    public function getPost()
    {
        return $_POST;
    }
    
    /**
     * HTTP GET 请求
     * @param string $url 请求地址
     * @param array $data 请求数据
     * @param null $cookie COOKIE
     * @param null $cookiefile COOKIE 请求所用的COOKIE文件位置
     * @param null $cookiesavepath 请求完成的COOKIE保存位置
     * @param bool $encode 是否对请求参数进行 urlencode 处理
     * @return mixed
     * @throws Exception
     */
    public static function get($url, $data = array(), $cookie = null, $cookiefile = null,$cookiesavepath = null, $encode = true)
    {
        //初始化句柄
        $ch = curl_init();
        //处理GET参数
        if(count($data)>0){
            $query = $encode?http_build_query($data):urldecode(http_build_query($data));
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
        }else{
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36');
        //设置cookie
        if (isset($cookie)) curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        //设置cookie请求文件
        if (isset($cookiefile)){
            if(!is_file($cookiefile)) throw new Exception('Cookie文件不存在');
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
        }
        //设置cookie保存路径
        if(isset($cookiesavepath)) curl_setopt($ch,CURLOPT_COOKIEJAR,$cookiesavepath);
        //执行请求
        $resp = curl_exec($ch);
        //关闭句柄，释放资源
        curl_close($ch);
        return $resp;
    }
    
    /**
     * HTTP POST 请求
     * @param string $url 请求地址
     * @param array $data 请求数据
     * @param null $cookie 请求COOKIE
     * @param null $cookiefile 请求时cookie文件位置
     * @param null $cookiesavepath 请求完成的COOKIE保存位置
     * @return string
     * @throws Exception
     */
    public static function post($url, $data = array(), $cookie = null, $cookiefile = null,$cookiesavepath = null)
    {
        //初始化请求句柄
        $ch = curl_init();
        //参数设置
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36');
        //cookie设置
        if (isset($cookie)) curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        //请求cookie设置
        if (isset($cookiefile)){
            if(!is_file($cookiefile)) throw new Exception('Cookie文件不存在');
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
        }
        //设置cookie保存路径
        if(isset($cookiesavepath)) curl_setopt($ch,CURLOPT_COOKIEJAR,$cookiesavepath);
        $resp=curl_exec($ch);
        curl_close($ch);
        return $resp;
    }
    
    
}