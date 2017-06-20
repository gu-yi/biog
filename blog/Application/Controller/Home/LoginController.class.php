<?php
namespace Controller\Home;

use Model\UserModel;

class LoginController extends \Core\Controller
{
    function loginAction()
    {
        if (!empty($_POST)){
           //print_r($_POST);// [] => ee [edtPassWord] => tt [btnPost] => 登录 [username] => [password] => [action] => check [module] => Privilege )
            //获取用户名密码
            $edtUserName=$_POST['edtUserName'];
            $edtPassWord=$_POST['edtPassWord'];
            //从数据库取出数据进行比较判断
            $userobj=new UserModel();
            if ($info=$userobj->getUserinfo($edtUserName,$edtPassWord)){
                unset($info['password']);
                $_SESSION['userinfo']=$info;
                //判断是否保存密码  存到cookie中（只存id，防止xss)
                //echo $_POST['chkRemember'];die;
                if (!empty($_POST['chkRemember'])){
                    $time=time()+24*60*60*10;//记住用户10天
                    setcookie('id',$info['id'],$time,'/');//记住用户id
                    $userinfo_key = md5($info['id'].$info['username']);
                    setcookie('userinfo_key',$userinfo_key,$time,'/');

                    //var_dump($_COOKIE);die;
                }
                $this->success('登录成功','index.php?p=home&c=index&a=index',1);
            }else{
                $this->error('登录失败用户名密码错误','index.php?p=home&c=login&a=login',2);
            }
        }else{
            $this->smarty->display('login.html');
        }


    }

}