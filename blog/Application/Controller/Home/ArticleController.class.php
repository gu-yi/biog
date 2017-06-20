<?php
namespace Controller\Home;

use Model\ArticleModel;
use \Model\CategoryModel;
use Model\CommentModel;

class ArticleController extends \Controller\Home\BaseConstroller
{
    function listAction()
    {
        //显示导航数据
        //获取分类显示数据
        $CategoryModel=new CategoryModel();
        $listDataCategory=$CategoryModel->getAll();
        $listDataCategory=$CategoryModel->getTree2($listDataCategory);
        $this->smarty->assign('listDataCategory',$listDataCategory);

        //显示文章列表数据 根据id
        $cid=(int)$_GET['cid'];
        $CategoryModel->categroyTree=array();//上面调用清空
        $sonArr=$CategoryModel->getTree2($listDataCategory,$cid);
        //循环取出所有子级id
        $ids[]=$cid;
        foreach ($sonArr as $son){
            $ids[]=$son['id'];
        }
        $idsStr=implode(',',$ids);
        $articleModel=new ArticleModel();
        //分页
        $datatotal=$articleModel->getCount();
        //实例化分页类
        $pageObj=new \Libs\Page($datatotal,4);
        $listDataArticle=$articleModel->getAll($idsStr,array('startno'=>$pageObj->startno,'pagesize'=>$pageObj->pagesize));
        $this->smarty->assign('pager',$pageObj->show(array('cid'=>$cid)));
        $this->smarty->assign('listDataArticle',$listDataArticle);
        $this->smarty->display('list.html');


    }
    function detailAction()
    {
    //echo $_SERVER['HTTP_REFERER'];die;

        //显示导航数据
        //获取分类显示数据
        $CategoryModel=new CategoryModel();
        $listDataCategory=$CategoryModel->getAll();
        $listDataCategory=$CategoryModel->getTree2($listDataCategory);
        $this->smarty->assign('listDataCategory',$listDataCategory);
        //显示详细数据
        $id=(int)$_GET['id'];
        $articleModel=new ArticleModel();
        $info=$articleModel->getrow($id);
        $this->smarty->assign('info',$info);
        //显示评论
        $commentModel=new CommentModel();
        $commentdada=$commentModel->getAll($id);
        $commentdada=$commentModel->getTree($commentdada);
        $this->smarty->assign('commentdada',$commentdada);
       //阅读量跟新
        $urlstr='http://www.blog.com/index.php?p=home&c=article&a=detail&id='.$id;
        if ($_SERVER['HTTP_REFERER']!=$urlstr){
            $articleModel->setClick($id);
        }


        $this->smarty->display('detail.html');

    }

    /**
     * 点赞处理
     */
    function zanAction()
    {
        $id=$_GET['id'];
        // 调用赞加一
        $articleModel=new ArticleModel();
        $articleModel->setZan($id);
       // $this->smarty->display('detail.html');
       header("location:index.php?p=home&c=article&a=detail&id=$id");
    }

}