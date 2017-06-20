<?php
namespace Controller\Home;

use Libs\Page;
use Model\ArticleModel;
use Model\CategoryModel;

class IndexController extends \Controller\Home\BaseConstroller
{
    function indexAction()
    {
      //var_dump($_SESSION['userinfo']);die;
        //显示文章数据并加载视图
        $articleModel=new ArticleModel();
        //分页
        $datatotal=$articleModel->getCount();
        //echo $datatotal;die;
        //实例化分页类
        $pageObj=new Page($datatotal,4);

        $listDataArticle=$articleModel->getAll(array(),array('startno'=>$pageObj->startno,'pagesize'=>$pageObj->pagesize));

        $this->smarty->assign('listDataArticle',$listDataArticle);
        $this->smarty->assign('pager',$pageObj->show());


        //获取分类显示数据
        $CategoryModel=new CategoryModel();
        $listDataCategory=$CategoryModel->getAll();
        $listDataCategory=$CategoryModel->getTree2($listDataCategory);
        $this->smarty->assign('listDataCategory',$listDataCategory);
        $this->smarty->display('index.html');
    }

}