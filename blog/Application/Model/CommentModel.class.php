<?php
namespace Model;

use Core\Model;

/**
 * 评论模型
 * Class CommentModel
 * @package Model
 */
class CommentModel extends Model
{
    /**
     * 廷加评论方法
     * @param $content 内容
     * @param $aid 文章id
     * @param $uid 用户id
     * @param $pid 父级id
     * @return mixed
     */
   public function insert($content,$aid,$uid,$pid)
   {
       $time=time();
       $sql="insert into comment (content,aid,uid,pid,updated_time,created_time) value ('$content',$aid,$uid,$pid,$time,$time)";
       return $this->mypdo->exec($sql);

   }

    /**
     * 显示数据方法
     * @return mixed
     */
   public function getAll($id)
   {
      $sql="select comment.*,user.username,user.avatar from comment left join user on comment.uid=user.id where comment.aid=$id";
      return $this->mypdo->fetchAll($sql);
   }

    /**
     * 评论树
     * @var array
     */
   public $commenttree=array();
    public function getTree($data,$pid=0,$level=0)
    {
        foreach ($data as $row){
            if ($row['pid']==$pid){
                $row['level']=$level;
                $this->commenttree[]=$row;
                $this->getTree($data,$row['id'],$level+1);
            }

        }
        return $this->commenttree;
    }
}