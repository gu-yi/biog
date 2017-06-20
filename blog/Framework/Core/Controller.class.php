<?php
namespace Core;

/**
 * 基础控制器
 */
class Controller
{


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->initSession();//调用开启session方法
        $this->initSmarty();//初始化smarty
        $this->initXss();   //初始化xss过滤器
    }

    /**
     * @var存放Xss过滤器
     */
    protected $xssObj;
    /**
     * 初始化过滤器
     */
    private function initXss()
    {
        //echo '实例化';die;
        //$this->xssObj=new \HTMLPurifier();
        $this->xssObj = new \HTMLPurifier();
    }

    /**
     * 开启session方法
     */
    function initSession()
    {
        session_start();
    }

    /**
     * 存放smarty实例
     * @var object
     */
    protected $smarty;

    /**
     * 初始化smarty
     */
    public function initSmarty()
    {
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(VIEW_PATH.PLATFORM_NAME.DS.CONTROLLER_NAME.DS);
        $this->smarty->setCompileDir(APP_PATH . DS . 'View_c');
    }


    /**
     * 操作成功跳转方法
     * @param string  $into    提示信息
     * @param string  $url     跳转地址
     * @param int    $time    等待时间
     */
    public function success($info, $url, $time = 3)
    {
        $this->jump($info, $url, 'success', $time);
    }

    /**
     * 操作失败跳转方法
     * @param string  $into    提示信息
     * @param string  $url     跳转地址
     * @param int    $time    等待时间
     */
    public function error($info, $url, $time = 3)
    {
        $this->jump($info, $url, 'error', $time);
    }

    /**
     * 跳转方法
     * @param string $into    提示信息
     * @param string $url     跳转地址
     * @param string $state   操作状态
     * @param int    $time    等待时间
     */
    public function jump($into, $url = '', $state = 'success', $time = 999999999999999)
    {
        if (!$url) {
            //如果没有输入调转地址则默认调转首页
            header('location: index.php');
        }
        echo <<<STR
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="refresh" content="{$time};URL={$url}">
<title>提示页面</title>
<style type="text/css">
#img{text-align:center;margin-top:50px;margin-bottom:20px;}
.info{text-align:center;font-size:24px;font-family:'微软雅黑';font-weight:bold;}
#success{color:#060;}
#error{color:#F00;}
</style>
</head> 
<body>
    <div id="img"><img src="/Public/common/image/{$state}.png" width="160" height="200" /></div>
    <div id='{$state}' class="info">{$into}，{$time}秒以后跳转</div>
</body>
</html>
STR;
        exit;
    }
}