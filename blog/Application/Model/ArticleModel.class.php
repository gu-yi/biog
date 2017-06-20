<?php
namespace Model;

class ArticleModel extends \Core\Model
{
    //获取总记录数
    public function getCount()
    {
        $sql="select count(*) from article";
      return  $this->mypdo->fetchColumn($sql);
    }
    //获取所有文章数据
    public function getAll($whereArr=array(),$limtArr=array())
    {
        //组合where 条件
        $wherestr=' where 1=1 ';
        if (isset($whereArr['cid'])){
            $wherestr.=" and a.cid in ({$whereArr['cid']})";
        }
        if (isset($whereArr['uid'])){
            $wherestr.=" and a.uid ={$whereArr['uid']}";
        }

        //$where=$cidStr?"where a.cid in ($cidStr)":'';
        //组装limit条件
        if (isset($limtArr['startno'])){
            $limitstr=" limit {$limtArr['startno']},{$limtArr['pagesize']}";
        }else{
            $limitstr='';
        }
        $sql="select a.*,b.name as categoryname  from article as a left join
              category as b on a.cid=b.id $wherestr order by a.id desc $limitstr";

        return $this->mypdo->fetchAll($sql);
    }
   /* public function getAll($cidStr='')
    {


//        $sql='select * from article';
//        return $this->mypdo->fetchAll($sql);
        $where=$cidStr?"where a.cid in ($cidStr)":'';
        $sql="select a.*,b.name as categoryname  from article as a left join 
category as b on a.cid=b.id $where order by a.id desc ";
        //echo $sql;die;
        return $this->mypdo->fetchAll($sql);
    }*/
    public function delete($id)
    {
        $sql="delete from article where id =$id";
        return $this->mypdo->exec($sql);
    }
    /**
     * 添加方法
     */
    public function add($uid,$cid,$image, $title,$author,$description,$keywords, $content,$isTuijian, $display)
    {
       $sql="insert into article (uid,cid, title,image,author,description,keywords, content,isTuijian, display) value ($uid,$cid, '$title','$image','$author','$description','$keywords', '$content','$isTuijian', '$display')";
       //echo $sql;die;
       return $this->mypdo->exec($sql);
    }
    /**
     * 跟新方法 显示数据
     */
    public function getJionAll()
    {
        $sql="select a.*,b.name as categoryname  from article as a left join category as b on a.cid=b.id  ";
        return $this->mypdo->fetchAll($sql);
    }
    //获取一条数据
    public function getrow($id){
        $sql="select article.* ,category.name as categoryname from article left join category on article.cid=category.id where article.id =$id";
        //echo $sql;die;
        return $this->mypdo->fetchRow($sql);
    }

    /**
     * 跟新数据
     * @param $id 修改id
     * @param $cid
     * @param $title
     * @param $author
     * @param $description
     * @param $keywords
     * @param $content
     * @param $isTuijian
     * @param $display
     * @return mixed
     */
    public function update($uid,$id,$cid,$image, $title,$author,$description,$keywords, $content,$isTuijian, $display)
    {
        //拼接image语句
        $imagestr='';
        if ($image){
            $imagestr.=" image='{$image}', ";
        }

        $sql="update article set uid=$uid,cid=$cid, title='$title', ".$imagestr." author='$author',description='$description',keywords='$keywords', content='$content',isTuijian=$isTuijian, display=$display where id=$id";
        return $this->mypdo->exec($sql);
    }

    /**跟新评论数
     * @param $aid
     * @return mixed
     */
    function setComment($aid)
    {
        $sql="update article set comment=comment+1 where id=$aid";
       return  $this->mypdo->exec($sql);
    }

    /**点赞处理
     * @param $id
     * @return mixed
     */
    function setZan($id)
    {
        $sql="update article set zan=zan+1 where id=$id";
        return  $this->mypdo->exec($sql);
    }
    /**
     * 阅读量处理
     */
    function setClick($id)
    {
        $sql="update article set click=click+1 where id=$id";
        return  $this->mypdo->exec($sql);
    }
}

