<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/21
 * Time: 16:32
 */

namespace Admin\Controller;
use User\Api\UserApi as UserApi;



class WeixiuController  extends AdminController {
   public function index(){
       $index = D(Index);
       $abc = $index -> select();
       $this->assign('abc',$abc);
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


//     添加首页内容
    public function add_index(){
        if(IS_POST){
            $news = D(Index);
            $data=postFil(array('title','intro','pic'));
            $data['create_time'] = NOW_TIME;
            $asp =  $news -> add($data);
            if($asp){
                $this->success('添加成功！', U('index'));
            }else{
                $this->error('添加失败！', U('add_index'));
            }
        }else{
            $this->display();
        }
    }

    //     添加二级页面内容
    public function add_ocontent(){
        if(IS_POST){
            $secondpage = D(Secondpage);
            $data=postFil(array('sec_head','sec_title','sec_intro','storeimg1','storeimg2','storeimg3'));
            $data['sec_ctime'] = NOW_TIME;
            $asp =  $secondpage -> add($data);
            if($asp){
                $this->success('添加成功！', U('ocontent'));
            }else{
                $this->error('添加失败！', U('add_ocontent'));
            }
        }else{
            $this->display();
        }
    }

    //     添加三级页面内容
    public function add_olist(){
        if(IS_POST){
            $threepage = D(Threepage);
            $data=postFil(array('three_head','three_title','three_intro','three_storeimg1','three_storeimg2','three_storeimg3','three_storeimg4'));
            $data['ctime'] = NOW_TIME;
            $asp =  $threepage -> add($data);
            if($asp){
                $this->success('添加成功！', U('olist'));
            }else{
                $this->error('添加失败！', U('add_olist'));
            }
        }else{
            $this->display();
        }
    }

//    修改三级页面内容
    public function  edit_olist(){
        if(IS_POST){
            $threepage = D(Threepage);
            $data=postFil(array('three_head','three_title','three_intro','three_storeimg1','three_storeimg2','three_storeimg3','three_storeimg4','id'));
//           p($data);
            $up = $threepage->where(array('id'=>$data['id']))->save($data);
            if($up){
                $this->success('添加成功！', U('olist'));
            }else{
                $this->error('添加失败',U('edit_olist'));
            }
        }else{
            $threepage = D(Threepage);
            $id = $_GET['id'];
            $data = array('id'=>$id);
            $sky =  $threepage->where($data)->find();
            $this->assign(vo,$sky);
            $this->display();
        }

    }

//    修改二级页面内容
    public function  edit_ocontent(){
        if(IS_POST){
            $secondpage = D(Secondpage);
            $data=postFil(array('sec_head','sec_title','sec_intro','storeimg1','storeimg2','storeimg3','id'));;
            $up = $secondpage->where(array('id'=>$data['id']))->save($data);
            if($up){
                $this->success('添加成功！', U('ocontent'));
            }else{
                $this->error('添加失败',U('edit_ocontent'));
            }
        }else{
            $secondpage = D(Secondpage);
            $id = $_GET['id'];
            $data = array('id'=>$id);
            $sky =  $secondpage->where($data)->find();
//            p($sky);
            $this->assign(vo,$sky);
            $this->display();
        }

    }

//    修改首页内容
    public function  edit_index(){
        if(IS_POST){
            $news = D(Index);
            $data=postFil(array('id','title','intro','pic'));
            $up = $news->where(array('id'=>$data['id']))->save($data);
            if($up){
                $this->success('添加成功！', U('index'));
            }else{
                $this->error('添加失败',U('index'));
            }
        }else{
            $news = D(Index);
            $id = $_GET['id'];
            $data = array('id'=>$id);
            $sky =  $news->where($data)->find();
            $this->assign(vo,$sky);
            $this->display();
        }
    }

    //    删除首页内容
    public  function  del_index(){
        $news = D(Index);
        $id = I('id');
        $asp =  $news ->where(array('id'=>$id))-> delete();
        $this->success('删除成功！', U('index'));
    }
    //    删除二级页面内容
    public  function  del_ocontent(){
        $secondpage = D(Secondpage);
        $id = I('id');
        $asp =  $secondpage ->where(array('id'=>$id))-> delete();
        $this->success('删除成功！', U('ocontent'));
    }
    //    删除三级页面内容
    public  function  del_olist(){
        $threepage = D(Threepage);
        $id = I('id');
        $asp =  $threepage ->where(array('id'=>$id))-> delete();
        $this->success('删除成功！', U('olist'));
    }
//  二级页面列表
    public function ocontent(){
        $secondpage = D(Secondpage);
        $abc1 = $secondpage -> select();
//        p($abc1);
        $this->assign('abc1',$abc1);
        $this->display();
    }

    //  三级页面列表
    public function olist(){
        $threepage = D(Threepage);
        $abc1 = $threepage -> select();
//        p($abc1);
        $this->assign('abc1',$abc1);
        $this->display();
    }


}