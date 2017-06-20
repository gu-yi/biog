<?php
namespace Controller\Admin;

use Libs\UploadFile;
use Model\UserModel;

/**登录管理器
 * Class LoginController
 * @package Controller\Admin
 */
class LoginController extends \Controller\Admin\BaseConstroller
{

    //注册页
    function enrollAction()
    {
        if (IS_POST){
            $avatar='';
            if (!empty($_FILES['avatar']['name'])){
                $uploadObj=new UploadFile();
                $avatar=$uploadObj->upload($_FILES['avatar']);
                $uploadMessage=$uploadObj->getMessage();
                if (!empty($uploadMessage)){
                    $this->error($uploadMessage[0], 'index.php?p=admin&c=login&a=enroll');
                }
            }
            //获取提交的数据
            $username=$_POST['username'];
            $password=md5($_POST['password']);
            $yanpassword=md5($_POST['yanpassword']);

            //获取数据库中的用户名 现有用户名如果已经注册 不容许再注册
            $userModel=new UserModel();
            $datausername=$userModel->show();
            //var_dump($datausername);die;
            $userArr=array();
            foreach ($datausername as $row){
                $userArr[]=$row['username'];
            }
            //print_r($userArr);die;
            if (in_array($username,$userArr)){
                $this->error('用户名已经被注册','index.php?p=admin&c=login&a=enroll',2);
            }
            if ($password == $yanpassword){

                $rs=$userModel->add($username,$password,$avatar);
                if ($rs){
                    $this->success('注册成功','index.php?p=admin&c=login&a=login');
                }
            }else{
                $this->error('两次输入密码不一致','index.php?p=admin&c=login&a=enroll');
            }
        }else{
            $this->smarty->display('enroll.html');
        }


    }
    //退出方法
    function loginoutAction(){
        //删除session
        session_destroy();
        //调转登录页
        $this->success('退出成功','index.php?p=admin&c=login&a=login',2);
    }
    //生成验证码
   /* public function captchaAction(){
        $obj=new \Libs\Codemath();
        $obj->getCode(100,33);
    }*/
    public function captchaAction(){
        //$obj=new \Libs\Codemath();
        //$obj->getCode(100,33);
        $obj=new \Libs\Codemath();
        $obj->getCode(100,33);
    }
    //登录页
    public function loginAction()
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
                //密码不保存进session
                unset($userinfo['password']);
                $_SESSION['userinfo']=$userinfo;
                //用户名保存进cookie
                setcookie('username',$userinfo['username']);
                //保存客户信息
                $last_login_ip=ip2long($_SERVER['SERVER_ADDR']);
                $obj->updateUserinfo($last_login_ip ,$userinfo['login_count']+1,time() ,$userinfo['id']);

                $this->success('登录成功','index.php?p=admin&c=index&a=index',2);
            }else{
                $this->error('用户名密码错误','index.php?p=admin&c=login&a=login');
            }

        }else{
            $this->smarty->display('login.html');
        }

    }
}