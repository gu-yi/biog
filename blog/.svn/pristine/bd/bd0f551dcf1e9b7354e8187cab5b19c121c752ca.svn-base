<?php
namespace Model;

/**用户模型
 * Class UserModel
 * @package Model
 */

class UserModel extends \Core\Model
{
    public function updateUserinfo($last_login_ip ,$login_count,$last_login_time ,$id)
    {
       $sql="update user set last_login_ip=$last_login_ip, login_count=$login_count, last_login_time=$last_login_time where id=$id";
        return $this->mypdo->exec($sql);
    }

    /**
     * 获取用户输入密码及用户名
     *
     * @param $username 用户名
     * @param $password密码
     * @return mixed
     */
public function getUserinfo($username,$password)
{   //防止sql注入
    $username=addslashes($username);
    $sql="select * from user where username='$username' and password='".md5($password)."'";
   return $this->mypdo->fetchRow($sql);
}
public function getUserByCookie()
{
    if (isset($_COOKIE['id']) && isset($_COOKIE['userinfo_key'])){
     $id=$_COOKIE['id'];
     $info=$this->mypdo->fetchRow("select * from user where id = $id");
        //if (empty($info['id'])) return false;
        if (md5($info['id'].$info['username']) == $_COOKIE['userinfo_key']){
            return $info;
        }
    }
    return false;
}
//添加用户
public function add($username,$password,$avatar='')
{
    $avatarstr='';
    if ($avatar){
        $avatarstr.=" '{$avatar}'";
    }else{
        $avatarstr = "''";
    }
    //$time=time();
    $sql="insert into user (username,password,avatar)value ('$username','$password',$avatarstr)";
   echo $sql;die;
    return $this->mypdo->exec($sql);
}
//取出用户名
public function show(){
    $sql="select username from user ";
    return $this->mypdo->fetchAll($sql);
}
}