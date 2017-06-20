<?php
namespace Controller\Admin;



use Libs\UploadFile;
use Model\ArticleModel;
use Model\CategoryModel;

class ArticleController extends \Controller\Admin\BaseConstroller
{
    /**
     * 显示文章
     */
    function listAction()
    {
        $listModel=new ArticleModel();
        //如果不是超级管理员yu则显示用户自己文章
        if ($_SESSION['userinfo']['username'] != 'yu'){
            $where=array('uid'=>$_SESSION['userinfo']['id']);
        }else{
            $where='';
        }
        $listData=$listModel->getAll($where);
        $this->smarty->assign('listData',$listData);
        $this->smarty->display('list.html');
    }

    /**
     * 增加方法
     */
    function addAction()
    {
        if (IS_POST){
            //图片上传
            //若上传了图片调用上传方法
            $image='';
            if (!empty($_FILES['image']['name'])){
                $uploadObj=new UploadFile();
                $image=$uploadObj->upload($_FILES['image']);
                $uploadMessage=$uploadObj->getMessage();
                if (!empty($uploadMessage)){
                    $this->error($uploadMessage[0], 'index.php?p=admin&c=article&a=add');
                }
            }

            //获取数据
            $cid=$_POST['cid'];
            $title=$_POST['title'];
            $author=$_POST['author'];
            $description=$_POST['description'];
            $keywords=$_POST['keywords'];
            $content=$_POST['content'];
            $isTuijian=$_POST['isTuijian'];
            $display=$_POST['display'];
            $uid=$_SESSION['userinfo']['id'];//获取用户id
            $obj=new ArticleModel();
            $rs=$obj->add($uid,$cid, $image,$title,$author,$description,$keywords, $content,$isTuijian, $display);
            if ($rs){
                $this->success('插入成功','index.php?p=admin&c=article&a=list',1);
            }else{
                $this->error('插入失败','index.php?p=admin&c=article&a=add',2);
            }

        }else{
            //显示分类
            $addModel=new CategoryModel();
            $addData=$addModel->getAll();
            //默认--树形格式化数据-树形显示分类栏
            $addData=$addModel->getTree2($addData);
            $this->smarty->assign('addData',$addData);
            $this->smarty->display('add.html');

        }


    }

    /**
     * 删除方法
     */
    function deleteAction()
    {
       $id=$_GET['id'];
       //echo $id;die;
        $deleteModel=new ArticleModel();

        if ($deleteModel->delete($id)){
            $this->success('删除成功','index.php?p=admin&c=article&a=list',1);
    }else{
            $this->error('删除失败','index.php?p=admin&c=article&a=list',2);
        }
    }

    /**
     * 跟新方法
     */
    function updateAction()
    {


        if (IS_POST){
           //var_dump($_FILES['image']);die;
            $image='';
            if (!empty($_FILES['image']['name'])){
                $uploadObj=new UploadFile();
                $image=$uploadObj->upload($_FILES['image']);
                $uploadMessage=$uploadObj->getMessage();
                if (!empty($uploadMessage)){
                    $this->error($uploadMessage[0], 'index.php?p=admin&c=article&a=add');
                }
            }
            $uid=$_SESSION['userinfo']['id'];//获取用户id
            $id=(int)$_POST['id'];
            $cid=(int)$_POST['cid'];
            $title=$_POST['title'];
            $author=$_POST['author'];
            $description=$_POST['description'];
            $keywords=$_POST['keywords'];
            $content=$this->xssObj->purify($_POST['content']);
            //$content=$_POST['content'];
            $isTuijian=(int)$_POST['isTuijian'];
            $display=(int)$_POST['display'];
            $articleModel=new ArticleModel();
            $rs=$articleModel->update($uid,$id,$cid,$image, $title,$author,$description,$keywords, $content,$isTuijian, $display);
                if($rs){
                    $this->success('跟新成功','index.php?p=admin&c=article&a=list',1);
                }else{
                    $this->error('跟新失败',"index.php?p=admin&c=article&a=update&id=$id",1);
                }
        }else{


            $id=(int)$_GET['id'];
            //显示数据
            $articleModel=new ArticleModel();
            $info=$articleModel->getrow($id);
          //print_r($info);die;
            $uid=$_SESSION['userinfo']['id'];//获取用户id
            //找不到修改文章数据
            //数据用户不等于当前登录用户禁止处理
            if (empty($info)||$info['uid'] != $uid){
                $this->error('没有权限修改','index.php?p=admin&c=article&a=list',2);
            }
            $this->smarty->assign('info',$info);
            //显示树形导航
            $categoryModel=new CategoryModel();
            $listdata=$categoryModel->getAll();
            //格式化数据
            $listdata=$categoryModel->getTree2($listdata);
            $this->smarty->assign('listdata',$listdata);
            $this->smarty->display('update.html');
        }

    }
}