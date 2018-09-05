<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 10:06
 */

namespace Admin\Controller;
use User\Api\UserApi as UserApi;

class BaihuiController  extends AdminController {
//    吸粉首页
    public function index(){
//        $uid = UID;

        $index = D('Sweep');
        $sid = I('sid',1);
        $aaa = $index->order('id asc')->select();
//       $ip =  $_SERVER['REMOTE_ADDR'];
//        $User = M("test");
//        $User->->setInc('num');

        foreach($aaa as  $key=>$val) {
            $link ='http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/Home/Index/page&sid='.$val['id'];
            $aaa[$key]['name']=$val['name'];
            $aaa[$key]['pic']=$val['pic'];
            $aaa[$key]['micro_signal']=$val['micro_signal'];
            $aaa[$key]['intro']=$val['intro'];
            $aaa[$key]['code']=$val['code'];
            $aaa[$key]['link']=$link;
            $aaa[$key]['wake_link']=$val['wake_link'];
            $aaa[$key]['click_time']=$val['click_time'];
        }
//  p($aaa);
        $this->assign('abc',$aaa);
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
    /*
* 图片上传
*/
    public function pics(){
        ob_end_clean();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('png','jpg');// 设置附件上传类型
        $upload->saveName  =  array('uniqid',date(YMD));
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
       // p ($info);
//        $urll= $_SERVER['SERVER_NAME'];
//        echo  "http://".$urll ."/Uploads/".date('Y-m-d/').$info['download']['savename'];
        echo "/Uploads/".$info['download']['savename'];
    }
    //    修改吸粉内容
    public function  edit_index(){
        if(IS_POST){
            $secondpage = D('Sweep');
            $data=postFil(array('id','pic','name','wake_link','intro','code','micro_signal','limit_uv'));
            if(!$data['limit_uv'])$data['limit_uv']=null;
            if(!$data['wake_link'])$data['wake_link']=null;
            //p($data);
//            $asd = I('wake_link');
//            $data['wake_link']='http://'.$_SERVER['HTTP_HOST'].$asd;

//            p($data);
            $up = $secondpage->where(array('id'=>$data['id']))->save($data);
            if($up){
                $this->success('添加成功！', U('index'));
            }else{
                $this->error('添加失败',U('index'));
            }
        }else{
            $secondpage = D('Sweep');
            $id = $_GET['id'];
            $data = array('id'=>$id);
            $sky =  $secondpage->where($data)->find();

            $this->assign("vo",$sky);
            $this->display();
        }
    }
//    添加吸粉
    //     添加三级页面内容
    public function add_index(){
        if(IS_POST){
            $threepage = D('Sweep');
            $data=postFil(array('pic','name','wake_link','intro','code','micro_signal'));;
            $data['ctime'] = NOW_TIME;


            $asp =  $threepage -> add($data);
            if($asp){
                $this->success('添加成功！', U('index'));
            }else{
                $this->error('添加失败！', U('index'));
            }
        }else{
            $this->display();
        }
    }

    //    删除吸粉内容
    public  function  del_index(){
        $news = D('Sweep');
        $id = I('id');
        $asp =  $news ->where(array('id'=>$id))-> delete();
        $this->success('删除成功！', U('index'));
    }


}