<?php
namespace Libs;
/**
 * 文件上传类
 */
class UploadFile
{
    /**
     * 保存文件上传信息
     * @var array
     */
    private $message=array();


    /**
     * 图片名称
     * @var
     */
    private $imageName;
    public function getMessage()
    {
        //return $this->message;
        return $this->message;
    }
    /**
     * 文件上传
     * @param $files
     * @return bool
     */
    public function upload($files){
        //是否存在错误存在直接返回
        if (!$this->checkError($files['error'])){
            return false;
        }
        //类型是否存在错误存在直接返回
        if (!$this->checkType($files['type'])){
            return false;
        }
        //文件大小是否存在错误存在直接返回
            if (!$this->checkSize($files['size'])){
            return false;
        }
        //上传文件
        $this->moveUploadFile($files['tmp_name'],$this->getNewFile($files['name']));
            return $this->imageName;
    }

    /**
     * 生成唯一文件路径名称
     * @param $fileName
     */
    public function getNewFile($fileName)
    {
        $this->imageName=time().rand(100,900).strrchr($fileName,'.');
        //新文件路径
        $fileNewPath='./Public/upload/'.$this->imageName;
        return $fileNewPath;
    }

    /**
     * 判断上传是否崔仔错误
     * @param $errorCode
     */
    public function checkError($errorCode)
    {
        //没有错误直接返回
      if (!$errorCode) {
          return true;
      }
      //有错误收集错误信息
        switch ($errorCode){
            case 1:
                $this->message[]='上传文件必须小于'.ini_get('upload_max_filesize');
                break;
            case 2:
                $this->message[]='上传文件超过表单最大值';
                break;
            case 3:
                $this->message[]='上传文件部分上传';
                break;
            case 4:
                $this->message[]='没有上传文件';
                break;
            case 6:
                $this->message[]='找不到临时文件';
                break;
            case 7:
                $this->message[]='文件写入失败';
                break;
            default:
                $this->message[]='上传文件未知错误';
        }
        return false;
    }

    /**
     * 判断上传文件类型是否正确
     * @param $fileType
     * @return bool
     */
    private function checkType($fileType)
    {
        $allowType=array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
        if (!in_array($fileType, $allowType)) {
            $this->message[] = '只能上传【'.implode( ',', $allowType).'】类型数据';
            return false;
        }
        return true;
    }

    /**
     * 判断文件大小是否符合要求
     * @param $fileSize
     * @return bool
     */
    private function checkSize($fileSize)
    {
        if ($fileSize>1024*1024*2){
            $this->message[]='文件不能超过2M';
            return false;
        }
        return true;
    }
    /**
     * 上传文件方法
     * @param  string $fileTempName 原来文件地址
     * @param  string $fileNewPath  新文件地址
     * @return bool
     */
    private function moveUploadFile($fileTempName, $fileNewPath)
    {
        //5、上传文件，语法：move_uploaded_file(临时文件，新文件地址)
        if (move_uploaded_file($fileTempName, $fileNewPath)) {
            $this->message =array(); //上传成功清空
        } else {
            $this->message[] = '上传失败';
        }
        return true;
    }
}
