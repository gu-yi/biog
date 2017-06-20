<?php
namespace Model;

class CategoryModel extends \Core\Model
{
    function getrow($id)
    {
        $sql="select * from category where id=$id";
        return $this->mypdo->fetchRow($sql);
    }
    /**
     * 获取数据
     * @return mixed
     */

    function getAll()
    {
       return $this->mypdo->fetchAll('select*from category order by sort');
    }
    function isson($id)
    {
        $sql="select * from category where pid=$id";
        return $this->mypdo->fetchRow($sql);
    }

    /**
     * 插入数据
     * @param $pid
     * @param $sort
     * @param $name
     * @return mixed
     */
    function insert($pid,$sort,$name)
    {   $time=time();
        $sql="insert into category value (null,$pid,'$name',$sort,$time,$time,display)";
        //echo $sql;die;
       return $this->mypdo->exec($sql);
    }

    /**
     * 删除方法
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
        $sql="delete from category where id=$id";
        //echo $sql;die;
        return $this->mypdo->exec($sql);
    }
    function update($name,$sort,$time,$id,$pid)
    {
        $sql="update category set pid=$pid,name='$name',sort=$sort,update_time=$time where id=$id";
        return $this->mypdo->exec($sql);
    }
    /**
     * 无限极递归分类（返回多维数组）
     * @param  array $data 所有分类
     * @param  int   $pid  默认pid=0 表示顶级分类
     * @return array       返回新数据组
     */
    function getTree($data,$pid=0)
    {
        //创建新的数组存放有序的分类数据
        $arr=array();
        //循环遍历数组
        foreach($data as $v){
            //默认pid=0则获取下面所有分类
            if ($v['pid']==$pid){
             //获取当前飞来的数据
                $v['son']=$this->getTree($data,$v['id']);
                $arr[]=$v;
            }
        }
        //返回数组；
        return $arr;

    }
    public $categroyTree=array();
    function getTree2($data,$pid=0,$lever=0)
    {
        //保存有规则分类
        //static  $arr;
        //循环
        foreach ($data as $v){
            //默认查找顶级分类
            if ($v['pid']==$pid){
                $v['lever']=$lever;
                $this->categroyTree[]=$v;
                //获取当前父元素所有子元素
                $this->getTree2($data,$v['id'],$lever+1);
            }
        }
        return $this->categroyTree;
    }
}