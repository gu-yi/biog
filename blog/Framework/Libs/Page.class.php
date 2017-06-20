<?php
namespace Libs;

//分页类
class Page
{
    private $datatotal;//总记录数
    private $pagesize;//每页显示记录数
    private $pageno;//当前页
    private $pagetotal;//总页数
    private $startno;//开始记录数
    private $prevno;//上一页
    private $nextno;//下一页
    //private $
    //获取没有权限的私有属性
    function __get($name)
    {
        return $this->$name;
    }

    //初始化变量
    function __construct($datatotal,$pagesize=5)
    {
        $this->datatotal=$datatotal;
        $this->pagesize=$pagesize;
        $this->pageno=$this->getpageno();
        $this->pagetotal=$this->getpagetotal();
        $this->startno=$this->startno();
        $this->nextno=$this->nextno();
        $this->prevno=$this->prevno();


    }
    //获取当前页
    function getpageno()
    {
        return isset($_GET['pageno'])?$_GET['pageno']:1;
        //return
    }
    //总页数
    function getpagetotal()
    {
        return ceil($this->datatotal/$this->pagesize);
    }
    //每页开始的记录
    function startno()
    {
        return ($this->pageno-1)*$this->pagesize+1;
    }
    //上一页
    function prevno()
    {
        $prevno=$this->pageno<=1?1:$this->pageno-1;
        return $prevno;
    }
    //下一页
    function nextno()
    {
        $nextno=$this->pageno>=1?$this->pagetotal:$this->pagetotal+1;
        return $nextno;
    }
    //跳转
    /*function tiao(){
    $i=1;
  return $n= <<<tiao


<select onchange="window.location.href=this.value">
while($i;$i<=$this->pagetotal;$i++){
  <option value=""$this->createUrl(,$condition)".$i" if($this->pageno==$i) selected>$i</option>
}
</select>
<input type="text"  value="  $this->pageno" id="go" size="2">
<input type="button"  value="跳转" onclick="window.location.href='"$this->createUrl(,$condition)".'+document.getElementById('go').value">
tiao;
}*/
    //创建分页连接
    private  function createUrl($pageno,$condition)
    {
        $url='index.php?p='.PLATFORM_NAME.'&c='.CONTROLLER_NAME.'&a='.ACTION_NAME.'&pageno='.$pageno;
        foreach ($condition as $key=>$value){
            //参数连接
            $url.='&'.$key.'='.$value;
        }
        return $url;
    }

//显示分页
    function show($condition=array()){


        $pagehtml='';
      $pagehtml.="当前一共有 $this->datatotal 条记录，当前每页显示 $this->pagesize 条记录，
       总共$this->pagetotal 页，当前是第$this->pageno 页，从第 $this->startno 条记录开始！";
          $pagehtml.="&nbsp<a href='".$this->createUrl(1,$condition)."'>首页</a>&nbsp";
          $pagehtml.="&nbsp<a href='".$this->createUrl($this->prevno,$condition)." '>上一页</a>&nbsp";
          $pagehtml.="&nbsp<a href='".$this->createUrl($this->nextno,$condition)."'>下一页</a>&nbsp";
          $pagehtml.="&nbsp<a href='".$this->createUrl($this->pagetotal,$condition)."'>尾页</a>&nbsp";
          //$pagehtml.="$this->tiao";
      /*$pagehtml.="<select onchange='window.location.href=this.value'>";
            for($i=1;$i<=$this->pagetotal;$i++){
                //$pagehtml.="<option value='"$this->createUrl(,$condition)".'".$i.">".$i."</option>";
              $pagehtml.="<option value='"$this->createUrl(,$condition)".".$i."' >".$i."</option>";
          }
                
          $pagehtml.="</select>";*/
          $pagehtml.="<input type='text'  value= {$this->pageno} id='goo' size='2'>
    <input type='button'  value='跳转' onclick=window.location.href='".$this->createUrl("document.getElementById('goo').value",$condition)."'>";

          return $pagehtml;

   }
}