<?php
namespace Home\Controller;
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class SpreadController extends HomeController {
    
    //http://biao.yezhong_weixiu.com/index.php?s=/home/Spread/page
    public function page(){
//        $ip = get_client_ip();
//        p($ip);
        $res = D('Sweep')->select();


//        $num = array_rand($res,1);

//if($res[$num]['uv'] >= $res[$num]['limit_uv']){
//    unset($res[$num]);
//    p($res);
//}

        do{
            if($num){
                unset($res[$num]);
            }
            $num = array_rand($res,1);
            
            if($res[$num]['limit_uv']){
                if($res[$num]['uv'] >= $res[$num]['limit_uv']){
                    $do = 1;
                }else{
                    $do = 0;
                }
            }else{
                $do = 0;
            }
        }while ($do);
        

    
        if($res[$num]['wake_link']){
            //p($res[$num]['wake_link']);
            $link ='http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/Home/Index/page&sid='.$res[$num]['id'].'&wake_link='.$res[$num]['wake_link'];
            header("Location:".$link); 
        }else{
                    //p($res[$num]);
            $link ='http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/Home/Index/page&sid='.$res[$num]['id'];
    //        file_get_contents($link, false, $context);
            header("Location:".$link); 
        }
    }
    
    
    /**
     * 定时任务删除昨天往后的访问记录
     */
    public function deltally(){
        $date = date('Ymd');
        $where['date'] = array('lt',$date);
        $res = D('Tallydata')->where($where)->delete();
    }
    
    public function save(){
        $add['ip']=ip2long(get_client_ip());
        if(!cookie('fullyeetally')){
            $value=md5(microtime().$add['ip'].rand());
            $overTime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-time();
            cookie("fullyeetally",$value,time()+$overTime);
        }
        $fullyeetally=cookie('fullyeetally');
        //p($fullyeetally);
        $add['cookie']=$fullyeetally;
        $add['date']=date('Y-m-d');
        $add['time']=time();
        $add['uri']=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $add['referer']=$_SERVER['HTTP_REFERER'];
        print_r($add);
        $tallydata_=D('Tallydata');
        $tallydata_->create($add);
        $tallydata_->add();

    }

    public function saveData()
    {
        $ip =ip2long(get_client_ip());
        $tally_=D('Tally');
        $tallydata_=D('Tallydata');
        $nowDate=date('Y-m-d',time()-3600*24);
        $condition['date'] = $nowDate;
        $condition['school'] = $school;
        
        $now['date']=$nowDate;
        $now['iptotal']=$this->gototal($nowDate,'ip');
        p($now);
        $now['pvtotal']=$tallydata_->where($condition)->count('tdid');
        $now['dltotal']=$this->gototal($nowDate,'cookie');
        $now['school']=$school;

        if($tally=$tally_->where(array('date'=>$nowDate))->find()){
            return;
            /*$tally_->where($condition)
                ->save(array(
                    'iptotal'=>$now['iptotal'],
                    'pvtotal'=>$now['pvtotal'],
                    'dltotal'=>$now['dltotal']
                ));*/
        }else{
            $tally_->create($now);
            $tally_->add();
        }
        $timeDel=time()-3600*24*50;
//        $tallydata_->query("delete from `tallydate` where `time`<$timeDel");
        $tallydata_->where('time<"'.$timeDel.'"')->delete();
//        echo 'Success'.date('Y-m-d H:i:s');
    }

    function gototal($nowDate,$a)
    {
        $tallydata_=D('Tallydata');
        $condition2['date'] = $nowDate;
        $now['iptotal']=$tallydata_->distinct(true)
            ->field($a)
            ->where($condition2)
            ->select();
//        var_dump(count($now['iptotal']));
        return count($now['iptotal']);
    }
}