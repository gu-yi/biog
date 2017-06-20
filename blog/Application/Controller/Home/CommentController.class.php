<?php
namespace Controller\Home;

use Core\Controller;
use Model\ArticleModel;
use Model\CommentModel;

class CommentController extends Controller
{
    /**
     * 添加评论犯法
     */
    function addAction(){
        //获取数据插入数据库
        if (IS_POST){
            $content=$this->xssObj->purify($_POST['content']);
            $aid=$_POST['aid'];
            $pid=$_POST['pid'];
            $uid=$_SESSION['userinfo']['id'];
            if (!$uid){
                $this->error('请登录后评论','index.php?p=home&c=login&a=login',2);
            }
            $conmentModel=new CommentModel();
           $rs = $conmentModel->insert($content,$aid,$uid,$pid);
           if ($rs){
               $articleModel=new ArticleModel();
               $articleModel->setComment($aid);
               $this->success('评论成功','index.php?p=home&c=article&a=detail&id='.$aid,1);
           }else{
               $this->error('评论失败','index.php?p=home&c=article&a=detail&id='.$aid,1);
           }
        }
    }

}