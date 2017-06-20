<?php
namespace Controller\Admin;

use Model\UserModel;

/**登录管理器
 * Class LoginController
 * @package Controller\Admin
 */
class LoginController extends \Controller\Admin\BaseConstroller
{
//unset($_SESSION['helloweba_math']);
    //生成验证码
    public function captchaAction(){
        //$obj=new \Libs\Codemath();
        //$obj->getCode(100,33);
        $obj=new \Libs\Codemath();

        $obj->getCode(100,33);
    }

    /**
     * 用户注册页
     */
   /* public function registerAction(){
        $this->smarty->display('register.html');
    }*/
    //登录页
    public function loginAction()
    {
        //进入登录页面面删除上次session;
        unset($_SESSION['helloweba_math']);
       /* //判断是否提交
        if (IS_POST){
            //判断验证码
            $code=$_POST['code'];//客户输入的验证码
            if (!\Libs\Captcha::checkVerify($code)){
                $this->error('验证码错误请重新登录','index.php?p=admin&c=login&a=login',2);
            }
            $username=$_POST['username'];
            $password=$_POST['password'];
            //echo $username;
            $obj=new UserModel();

            if ($userinfo=$obj->getUserinfo($username,$password)){
                //用户密码保存进session 生成令牌
                unset($userinfo['password']);
               $_SESSION['userinfo']=$userinfo;
                //登录成功转跳后台管理页面
                $this->success('登录成功','index.php?p=admin&c=index&a=index');
            }else{
                //登录失败跳登录页
               $this->error('登录失败','index.php?p=admin&c=login&a=login');
            }
        }else{*/

            $this->smarty->display('login.html');
        //}


    }

    /**
     * 提交到dologin处理方式
     */
    function dologinAction()
    {

       if (!empty($_POST)) {
           //验证验证码是否正确
         $code=$_POST['code'];
         //!\Libs\Captcha::checkVerify($code)

         if ($code!=$_SESSION['helloweba_math']){

             $this->error('验证码错误请重新输入','index.php?p=admin&c=login&a=login',2);
         }
         //密码处理

           if (empty($_POST['username'])||empty($_POST['password'])){
             $this->error('用户名密码不能为空','index.php?p=admin&c=login&a=login',2);
           }
           $username=$_POST['username'];
           $password=$_POST['password'];
           $obj=new UserModel();
           if($userinfo=$obj->getUserinfo($username,$password)){
               $_SESSION['userinfo']=$userinfo;
               $this->success('登录成功','index.php?p=admin&c=index&a=index',2);
           }else{
               $this->error('用户名密码错误','index.php?p=admin&c=login&a=login');
           }

       }else{
           $this->smarty->display('login.html');
       }
    }
}