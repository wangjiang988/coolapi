<?php
 
/**
 * 验证类
 * 
 * @use Validator::has($post['detailed_address'],'detailed_address'); // 前面几个是参数，最后一个是参数名
 */
class Validator {

    public static function __callStatic($method, $param)/*{{{*/
    {
         Language::read('error');  //TODO;
         if(!is_array($param))
             ajaxReturn('验证参数没有传入','600');
         else { 
             $paramName   =  '';
             $count       =  count($param);
             if($count ==1) $code =   self::$method($param[0]);
             elseif($count ==2){
                 $paramName = $param[1];
                 $code =   self::$method($param[0]);
             }
             elseif($count == 3){
                 $paramName = $param[2];
                 $code =   self::$method($param[0],$param[1]);
             }
             elseif($count == 4) {
                 $paramName = $param[3];
                 $code =   self::$method($param[0],$param[1],$param[2]);
             }
             else ajaxReturn('没有该验证方法','601'); //TODO  这里代码需要优化
         }
         
         if($code == 200) return $param[0];
         else  ajaxReturn($paramName.':'.L('E'.$code),$code);
    }
    
    public static function encode($str)
    {
        return htmlspecialchars($str);
    }
    
    /**
     * 是否为空值
     */
    private static function isEmpty($str){
        $str = trim($str);
        return !empty($str) ? 200 : 301;
    }
    
    /**
     * 是否设置
     */
    private static function has($str){
        return isset($str) ? 200 : 302;
    }
    
    
    /** 
     * 数字验证 
     * param:$flag : int是否是整数，float是否是浮点型 
     */        
    private static function isNumber($str,$flag = 'float'){  
        self::isEmpty($str);
        if(strtolower($flag) == 'int'){  
            return ((string)(int)$str === (string)$str) ? 200 : 303;  
        }elseif(strtolower($flag) == 'float'){  
            return ((string)(float)$str === (string)$str) ? 200 : 304;  
        }else{
            if(is_numeric($str))
                return 200;
            else return 313;
        }
    }   
    /*
     * 函数名称：isPhone
     * 简要描述：检查输入的是否为电话
     * 输入：string
     * 输出：boolean
     */
 
    private static function isPhone($val) {
        self::isEmpty($val);
        //eg: xxx-xxxxxxxx-xxx | xxxx-xxxxxxx-xxx ...
        if (preg_match("/^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/", $val))
            return 200;
        return 305;
    }
 
    /*
     * 函数名称：isMobile
     * 简要描述：检查输入的是否为手机号
     * 输入：string
     * 输出：boolean
     */
 
    private static function isMobile($val) {
        self::isEmpty($val);
        //该表达式可以验证那些不小心把连接符“-”写出“－”的或者下划线“_”的等等
        if (preg_match("/^1[3458][0-9]{9}$/", $val))
            return 200;
        return 306;
    }
 
    /*
     * 函数名称：isPostcode
     * 简要描述：检查输入的是否为邮编
     * 输入：string
     * 输出：boolean
     */
 
    private static function isPostcode($val) {
        self::isEmpty($val);
        if (preg_match("/^[0-9]{4,6}$/", $val))
            return 200;
        return 307;
    }
 
    /*
     * 函数名称：isEmail
     * 简要描述：邮箱地址合法性检查
     * 输入：string
     * 输出：boolean
     */
 
//     private static function isEmail($val, $domain = "") {
//         self::isEmpty($val);
//         if (!$domain) {
//             if (preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val)) {
//                 return 200;
//             } else
//                 return 308;
//         }
//         else {
//             if (preg_match("/^[a-z0-9-_.]+@" . $domain . "$/i", $val)) {
//                 return 200;
//             } else
//                 return 308;
//         }
//     }
 
//end func
 
    /*
     * 函数名称：isName
     * 简要描述：姓名昵称合法性检查，只能输入中文英文数字
     * 输入：string
     * 输出：boolean
     */
 
    private static function isName($val) {
        self::isEmpty($val);
//         if (preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val)) {//2008-7-24
        if (preg_match("/^[\x{4e00}-\x{9fa5}\w-]+$/u", $val)) {//2008-7-24
            return 200;
        }
        return 309;
    }
 
//end func
 
    /*
     * 函数名称:isDomain($Domain)
     * 简要描述:检查一个（英文）域名是否合法
     * 输入:string 域名
     * 输出:boolean
     */
 
    private static function isDomain($Domain) {
        if (!eregi("^[0-9a-z]+[0-9a-z\.-]+[0-9a-z]+$", $Domain)) {
            return FALSE;
        }
        if (!eregi("\.", $Domain)) {
            return FALSE;
        }
 
        if (eregi("\-\.", $Domain) or eregi("\-\-", $Domain) or eregi("\.\.", $Domain) or eregi("\.\-", $Domain)) {
            return FALSE;
        }
 
        $aDomain = explode(".", $Domain);
        if (!eregi("[a-zA-Z]", $aDomain[count($aDomain) - 1])) {
            return FALSE;
        }
 
        if (strlen($aDomain[0]) > 63 || strlen($aDomain[0]) < 1) {
            return FALSE;
        }
        return TRUE;
    }
 
    /*
     * 函数名称:isNumberLength($theelement, $min, $max)
     * 简要描述:检查字符串长度是否符合要求
     * 输入:mixed (字符串，最小长度，最大长度)
     * 输出:boolean
     */
 
    private static function isNumLength($val, $min, $max) {
        $theelement = trim($val);
        if (ereg("^[0-9]{" . $min . "," . $max . "}$", $val))
            return 200;
        return 310;
    }
 
    /*
     * 函数名称:isNumberLength($theelement, $min, $max)
     * 简要描述:检查字符串长度是否符合要求
     * 输入:mixed (字符串，最小长度，最大长度)
     * 输出:boolean
     */
 
    public static function isEngLength($val, $min, $max) {
        $theelement = trim($val);
        if (ereg("^[a-zA-Z]{" . $min . "," . $max . "}$", $val))
            return TRUE;
        return FALSE;
    }
 
    /*
     * 函数名称：isEnglish
     * 简要描述：检查输入是否为英文
     * 输入：string
     * 输出：boolean
     */
 
    public static function isEnglish($theelement) {
        if (ereg("[\x80-\xff].", $theelement)) {
            return FALSE;
        }
        return TRUE;
    }
 
    /*
     * 函数名称：isChinese
     * 简要描述：检查是否输入为汉字
     * 输入：string
     * 输出：boolean
     */
 
    public static function isChinese($sInBuf) {
        $iLen = strlen($sInBuf);
        for ($i = 0; $i < $iLen; $i++) {
            if (ord($sInBuf{$i}) >= 0x80) {
                if ((ord($sInBuf{$i}) >= 0x81 && ord($sInBuf{$i}) <= 0xFE) && ((ord($sInBuf{$i + 1}) >= 0x40 && ord($sInBuf{$i + 1}) < 0x7E) || (ord($sInBuf{$i + 1}) > 0x7E && ord($sInBuf{$i + 1}) <= 0xFE))) {
                    if (ord($sInBuf{$i}) > 0xA0 && ord($sInBuf{$i}) < 0xAA) {
//有中文标点
                        return FALSE;
                    }
                } else {
//有日文或其它文字
                    return FALSE;
                }
                $i++;
            } else {
                return FALSE;
            }
        }
        return TRUE;
    }
 
    /*
     * 函数名称：isDate
     * 简要描述：检查日期是否符合0000-00-00
     * 输入：string
     * 输出：boolean
     */
 
    public static function isDate($sDate) {
        if (ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$", $sDate)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
 
    /*
     * 函数名称：isTime
     * 简要描述：检查日期是否符合0000-00-00 00:00:00
     * 输入：string
     * 输出：boolean
     */
 
    public static function isTime($sTime) {
        if (ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$", $sTime)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
 
    /*
     * 函数名称:isMoney($val)
     * 简要描述:检查输入值是否为合法人民币格式
     * 输入:string
     * 输出:boolean
     */
 
    public static function isMoney($val) {
        if (ereg("^[0-9]{1,}$", $val))
            return TRUE;
        if (ereg("^[0-9]{1,}\.[0-9]{1,2}$", $val))
            return TRUE;
        return FALSE;
    }
 
    /*
     * 函数名称:isIp($val)
     * 简要描述:检查输入IP是否符合要求
     * 输入:string
     * 输出:boolean
     */
 
    public static function isIp($val) {
        return (bool) ip2long($val);
    }
 
}