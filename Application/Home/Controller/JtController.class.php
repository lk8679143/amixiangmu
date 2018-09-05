<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 10:15
 */

namespace Home\Controller;
use OT\DataDictionary;


class JtController  extends HomeController {
   public function index(){
       $this->display();
   }


//    public function ad()
//    {
//        $aid = I('aid', 100);
//        $User = M("Sweep");
//        $User->where("id=>$aid")->setInc('num');
//        if ($aid == 100) {
//        }
//        header("http://engine.tuibench.com/index/activity?appKey=2Z9DHhqcyxZGrNnyGxRs3p8ruzeG&adslotId=9063");
//       }
//    }
}