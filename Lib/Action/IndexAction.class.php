<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action 
{
    public function index()
    {
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
    	$voteCount = M('vote', null)->count();
 
    	$data=array();
    	foreach($itemList as $k=>$v) {
    		$data[$k]['count']=$voteInfo = M('vote', null)->where('item_id='.$k)->count();
    		$data[$k]['ratio']=round($data[$k]['count']/$voteCount,2);
    		$data[$k]['name']=$itemList[$k].$data[$k]['count']."次";
    	}
    	var_dump($data);
    	$this->assign('data', $data);
     
    	//获取当前的用户ID
    	session_start();
    	$user=array('id'=>1,'username'=>'baker');
    	$this->assign('user',$user);
    	
    	//获取当前用户的选项
    	$itemInfo=M('vote', null)->where("uid='".$user['id']."'")->find();
    	$this->assign('itemInfo',$itemInfo);
    	
    	$this->display();
    }
    
    public function vote()
    {
    	session_start();
    	$user=array('id'=>1,'username'=>'baker');
    	$data=array();
    	$data['create_time']=time();
    	$data['ip_addr']=$_SERVER['REMOTE_ADDR'];
    	$data['item_id']=$_POST['vote'];
    	$data['item_value']=1;
    	$data['uid']=$user['id'];
    	
    	$res=M('vote',null)->add($data);
 
    	if($res){
			echo 1;
		}else{
			echo 0;
		}
    }
}