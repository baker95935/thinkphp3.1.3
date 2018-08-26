<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action 
{
    public function toupiaos()
    {
    	$shop_id=1234;//这里定义SHOPID
    	
    	$itemList=array(
    		1=>'选项一',
    		2=>'选项二',
    		3=>'选项三',
    		4=>'选项四',
    		5=>'选项五',
    		6=>'选项六',
    	);	
    	$this->assign('itemList', $itemList);
    	//思路整理，获取选项的ID
    	//然后统计，各个选项的数量
    	
    	//获取总数
    	$voteCount = M('vote_brand')->where('shop_id= '.$shop_id)->count();
 
    	$data=array();
    	foreach($itemList as $k=>$v) {
    		$data[$k]['count']=$voteInfo = M('vote', null)->where('item_id='.$k)->count();
    		$data[$k]['ratio']=round($data[$k]['count']/$voteCount,2);
    		$data[$k]['name']=$itemList[$k].$data[$k]['count']."次";
    	}
    	$realData=array();
    	$data['percent'] = array(
    		array('item' => $data[1]['name'],'count' => $data[1]['count'],'percent'=>$data[1]['ratio']),
    		array('item' => $data[2]['name'],'count' => $data[2]['count'],'percent'=>$data[2]['ratio']),
    		array('item' => $data[3]['name'],'count' => $data[3]['count'],'percent'=>$data[3]['ratio']),
    		array('item' => $data[4]['name'],'count' => $data[4]['count'],'percent'=>$data[4]['ratio']),
    		array('item' => $data[5]['name'],'count' => $data[5]['count'],'percent'=>$data[5]['ratio']),
    		array('item' => $data[6]['name'],'count' => $data[6]['count'],'percent'=>$data[6]['ratio']),
    	);
    	$data['percent'] = json_encode($data['percent']);
    	$this->assign('data', $data);
     
    	//获取当前的用户ID
    	session_start();
    	$user=array('id'=>14,'username'=>'baker');
    	$this->assign('user',$user);
    	
    	//获取当前用户的选项
    	$itemInfo=array();
    	$itemInfo=M('vote_brand')->where("uid='".$user['id']."' and shop_id= ".$shop_id)->find();
    	$this->assign('itemInfo',$itemInfo);
    	
    	$this->display();
    }
    
    public function vote()
    {
    	session_start();
    	$user=array('id'=>14,'username'=>'baker');
    	$data=array();
    	$data['create_time']=time();
    	$data['ip_addr']=$_SERVER['REMOTE_ADDR'];
    	$data['item_id']=$_POST['vote'];
    	$data['shop_id']=$_POST['shop_id'];
    	$data['item_value']=1;
    	$data['uid']=$user['id'];
    	
    	//校验下是否已投
    	$count=M('vote_brand')->where('uid='.$data['uid']." and shop_id= ".$data['shop_id'])->count();
    	if($count>0) {
    		echo 2;exit;
    	}
    	
    	$res=M('vote_brand')->add($data);
 
    	if($res){
			echo 1;exit;
		}else{
			echo 0;exit;
		}
    }
}