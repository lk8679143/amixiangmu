<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/21
 * Time: 16:16
 */

namespace Home\Controller;
use OT\DataDictionary;



class WeixiuController extends HomeController {
    public function content(){
        $secondpage = D(Secondpage);
        $abc =  $secondpage->order('id desc')->limit(0,3)->select();
        $this->assign('abc',$abc);
        $this->display();
    }
    public function olist(){
        $threepage = D(Threepage);
        $abc =  $threepage->order('id desc')->limit(0,3)->select();
        $this->assign('abc',$abc);
        $this->display();
    }
   public function bgcol(){
       header("Content-type:text/html;charset=utf-8");
       $bg = D(Bgcolor);
       $index = $bg->order('id desc')->limit(0,1)->select();
//       p($index);
       $stp =  json_encode($index);
       print_r($stp);
//       $this->assign('abc',$index);
//       $this->display();
   }
    public function test(){

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


    //     添加测试页面内容
    public function test1(){
        if(IS_POST){
            $news = D(Index);
            $data=postFil(array('pic'));
            $data['create_time'] = NOW_TIME;
            $asp =  $news -> add($data);
            if($asp){
                $this->success('添加成功！', U('test1'));
            }else{
                $this->error('添加失败！', U('test1'));
            }
        }else{
            $this->display();
        }
    }
}