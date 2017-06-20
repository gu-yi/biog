<?php
namespace Controller\Home;


/**
 * Home下面公共加载类
 * Class BaseConstroller
 * @package
 */
class BaseConstroller extends \Core\Controller
{
    function __construct()
    {
        //加载父类构造方法
    parent::__construct();

    if (empty($_SESSION['userinfo']) && !empty($_COOKIE['id'])){
        $userModel=new \Model\UserModel();
        $info=$userModel->getUserByCookie();
        if ($info){
            unset($info['password']);
            $_SESSION['userinfo']=$info;
        }
    }
    }

}