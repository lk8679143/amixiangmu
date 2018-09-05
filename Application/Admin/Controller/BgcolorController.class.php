<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:13
 */

namespace Admin\Controller;
use User\Api\UserApi as UserApi;


class BgcolorController  extends AdminController {

//   背景首页
    function  bg(){
        $bg = D(Bgcolor);
        $index = $bg->order('id desc')->select();
//       p($index);
        $this->assign('abc',$index);
        $this->display();
    }
    /*
       * 图片上传
       */
    public function pic(){
        ob_end_clean();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->saveName  =  array('uniqid',date(YMD));
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
//        echo $info;
//        $urll= $_SERVER['SERVER_NAME'];
//        echo  "http://".$urll ."/Uploads/".date('Y-m-d/').$info['download']['savename'];
        echo "/Uploads/".date('Y-m-d/').$info['download']['savename'];
    }
//    添加背景
    function add_bg(){
        header("Content-type:text/html;charset=utf-8");
        if(IS_POST){
            $bg = D(Bgcolor);
            $data=postFil(array('title','bg_instr','background','title'));
//            p($data);
            $data['ctime'] = NOW_TIME;
            $asp =  $bg -> add($data);
            if($asp){
                $this->success('添加成功！', U('bg'));
            }else{
                $this->error('添加失败！', U('add_bg'));
            }
        }else{
            $this->display();
        }
    }
//    编辑图片信息
function edit_bg(){
    if(IS_POST){
        header("Content-type:text/html;charset=utf-8");
        $bg = D(Bgcolor);
        $data=postFil(array('id','title','bg_instr','background'));
//        p($data);
        $up = $bg->where(array('id'=>$data['id']))->save($data);
        if($up){
            $this->success('添加成功！', U('bg'));
        }else{
            $this->error('添加失败',U('bg'));
        }
    }else{
        $bg = D(Bgcolor);
        $id = $_GET['id'];
        $data = array('id'=>$id);
        $sky =  $bg->where($data)->find();
        $this->assign(vo,$sky);
        $this->display();
    }
}
//    删除背景图片
  function del_bg(){
      $bg = D(Bgcolor);
      $id = I('id');
      $asp =  $bg ->where(array('id'=>$id))-> delete();
      $this->success('删除成功！', U('bg'));
  }
}