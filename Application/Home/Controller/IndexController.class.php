<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

    
	//系统首页
    public function index(){
        $link ='http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/Admin/Public/login';

//        file_get_contents($link, false, $context);
        header("Location:".$link); 
    }
    
    /**
     * 页面链接
     */
    public function page(){
        $Sweep = D('Sweep');
        $wake_link = $_GET['wake_link'];
        $id = $_GET['sid'];
        $id || p("id:400");
//        if(!$id){
//            $id = 1;
//        }
        $Sweep->where(array('id'=>$id))->setInc('click_time');
//        p($id);

        $ip = get_client_ip();
        $add['ip'] = $ip;
        $add['ip2long']=ip2long($ip);
        
        $date = date('Ymd');
        $nowtime = time();
        
        $cookie = md5($date.$add['ip2long']);
        
//        if(!cookie('fullyeetally')){

//            $value=md5($date.$add['ip2long']);

//            $overTime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-$nowtime;
//            //$overtime = strtotime(date('Y-m-d 00:00:00',strtotime('+1 day')))-time();

//
//            cookie("fullyeetally",$value,$overTime);
//            
//        }
//        
//        $fullyeetally=cookie('fullyeetally');
        


        $add['cookie']=$cookie;
        $where['cookie']=$cookie;
        $add['date']=$date;
        $add['time']=$nowtime;
        $add['uri']=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $add['referer']=$_SERVER['HTTP_REFERER'];
        $add['sid'] = $id;
        $where['sid'] = $id;
        //p($where);
        $tallydata_=D('Tallydata');
        $fres = $tallydata_->where($where)->field('id')->find();
        if(!$fres){
            $tallydata_->add($add);
            $Sweep->where(array('id'=>$id))->setInc('uv');
        }
        
        if($wake_link){
            header("Location:".$wake_link);
            exit;
        }

        $abc =  $Sweep->where(array('id'=>$id))->find();
        
//   p($abc);
//        $ip =  $_SERVER['REMOTE_ADDR'];
//        echo $ip;echo '<br/>';
//        $postdate = time();
//
//        print_r($postdate);echo '<br/>';
//        if($postdate >= 0 ) {
//            if (!isset($_SESSION)) {
//                session_start();
//            }
//            if (!isset($_SESSION['counter'])) {
//                $_SESSION['counter'] = 1; //计数器设为1.
//            } else {
//                $_SESSION['counter']++;
//            }
//            $i = $_SESSION['counter'];
//            echo $i . '<br/>';
//        }
//         $index->add(array('click_time'=>$i));
//        p($abc);
//        $category = D('Category')->getTree();
//        $lists    = D('Document')->lists(null);
//
//        $this->assign('category',$category);//栏目
//        $this->assign('lists',$lists);//列表
//        $this->assign('page',D('Document')->page);//分页
//        p($abc);

         $this->assign('abc',$abc);
         $this->display();
    }

//    获取当前ip,并记录时间
//    public function clk(){
//
//    }

}