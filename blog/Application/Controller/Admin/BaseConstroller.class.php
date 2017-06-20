<?php
namespace Controller\Admin;

/**
 * Admin 下面公共加载类
 * Class BaseConstroller
 * @package Controller\Admin
 */
class BaseConstroller extends \Core\Controller
{
    function __construct()
    {
        //加载父类构造方法
    parent::__construct();
    //
    if (empty($_SESSION['userinfo']) && CONTROLLER_NAME!='Login'){
        $this->error('请登录后操作','index.php?p=Admin&c=login&a=login',1);
    }
    }

}