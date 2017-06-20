<?php
namespace Controller\Admin;

use Model\CategoryModel;

/**
 * 分类控制器
 * Class CategoryController
 * @package Controller\Admin
 */
class CategoryController extends \Controller\Admin\BaseConstroller
    {
        //修改方法
        public function updateAction()
        {
            $id=(int)$_GET['id'];
            if (IS_POST){
                //=获取数据
                $name=$_POST['name'];
                $sort=$_POST['sort'];
                $pid=$_POST['pid'];
                $time=time();
                //判断1. 父级不能选择自己   当前ID 等于 当前PID  则是自己
                if ($id==$pid){
                    $this->error('父级不能自己',"index.php?p=admin&c=category&a=update&id=$id",2);
                }
                //判断2. 父级不能选择自己的子级
                //获取当前分类的全部子级
                $categoryModel=new CategoryModel();
                $updatedata=$categoryModel->getAll();
                //格式化数据，显示分类树 （获取分类ID为1的所有子级）
                $updatedata=$categoryModel->getTree2($updatedata,$id);
                //循环判断当前 $pid  是否等于  子级的ID
                //若没有下级不进行判断
                $rs=$categoryModel->isson($id);
                if ($rs){
                    foreach ($updatedata as $son){
                        if ($pid==$son['id']){
                            $this->error('父级ID不能是自己子级的id',"index.php?p=admin&c=category&a=update&id=$id",2);
                        }
                    }
                }


                $categoryModel=new CategoryModel();
                $rs=$categoryModel->update($name,$sort,$time,$id,$pid);
                if ($rs){
                    $this->success('修改成功','index.php?p=admin&c=category&a=list',1);
                }else{
                    $this->error('修改失败',"index.php?p=admin&c=category&a=update&id=$id",1);
                }

            }else{

                //$id=(int)$_GET['id'];
                //显示默认数据
                $categoryModel=new CategoryModel();
                $catedata=$categoryModel->getAll();
                //树形格式化分类栏
                $catedata=$categoryModel->getTree2($catedata);
                //var_dump($catedata);die;
                $this->smarty->assign('catedata',$catedata);
                //默认显示数据
                $info=$categoryModel->getrow($id);
                $this->smarty->assign('info',$info);

                $this->smarty->display('update.html');
            }

        }
        /**
         * 显示分类列表方法
         */
        public function listAction()
        {
            $obj=new CategoryModel();
            $data=$obj->getAll();
            //var_dump($data);die;
            $this->smarty->assign('data',$data);
            $this->smarty->display('list.html');
        }

    /**
     * 添加分类方法
     */
        public function addAction()
        {
            //处理提交数据
            if (IS_POST){

                $name=$_POST['name'];
                $sort=(int)$_POST['sort'];
                $pid=$_POST['pid'];
                    $categoryModel=new CategoryModel();
                    if($categoryModel->insert($pid,$sort,$name)){
                        $this->success('提交成功','index.php?p=admin&c=category&a=list',1);
                    }else{
                        $this->error('提交失败','index.php?p=admin&c=category&a=add',2);
                    }


            }else{
                //显示所有的类别
                $categoryModel=new CategoryModel();
                $listdata=$categoryModel->getAll();
                $listdata=$categoryModel->getTree2($listdata);
               // echo '<pre>';
                //var_dump($listdata);die;
                $this->smarty->assign('listdata',$listdata);
                $this->smarty->display('add.html');
            }

        }
        //分类的删除
        public function deleteAction()
        {
           $id=$_GET['id'];
           //echo $id;
           $categoryModel=new CategoryModel();
           if ($categoryModel->isson($id)){
               $this->error('存在子级删除失败','index.php?p=admin&c=category&a=list',2);
           }
           //$categoryModel->delete($id);
           if ( $categoryModel->delete($id)){
               $this->success('删除成功','index.php?p=admin&c=category&a=list',1);
            }else{
               $this->error('删除失败','index.php?p=admin&c=category&a=list',2);
           }


        }
    }