<?php
namespace Controller\Admin;

/**
 * 后台管理页面
 * Class IndexController
 * @package Controller\Admin
 */
class IndexController extends \Controller\Admin\BaseConstroller
{   //加载后台首页
    function indexAction()
    {
        $this->smarty->display('index.html');
    }
    //欢迎页面
    function welcomeAction()
    {
      $this->smarty->display('welcome.html');
    }
}