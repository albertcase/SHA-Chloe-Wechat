<?php

class Temp{
	private $_db = NULL;
	
	public function __construct()
	{
		$this->_db = Yii::app()->db;	
	}

	public function list($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;
		$search = isset($data['search']) ? $data['search'] : '';
		$offset = ($page-1)*$rows;
		$where = '1';
		
		if($search){
			$where .= " AND title like '%".$search."%' ";
		}

		$sqlCount = "SELECT count(id) AS num FROM same_temp WHERE $where";
		$count = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT * FROM same_temp WHERE $where ORDER BY id DESC  limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$menuAll = array("total"=>$count,"rows"=>$menuAll);
		return json_encode($menuAll);
	}

	public function getDataById($id)
	{
		$sql="SELECT * FROM same_temp where id=".$id;
		$rs=$this->_db->createCommand($sql)->select()->queryRow();
		return $rs;
	}

	public function update($data)
	{
		$result = array('code'=>'','msg'=>'');
		$id = $data['id'];
		$pid = $data['pid'];
		$name = $data['name'];
		$event = $data['event'];
		$eventkey = $data['eventkey'];
		$eventurl = $data['eventurl'];

		if($event=='click'){
			$eventurl = '';
		}else{
			$eventkey = '';
		}

		try{
			$sql = "UPDATE same_temp SET pid=:pid,name=:name, event=:event,eventkey=:eventkey, eventurl=:eventurl WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$id,PDO::PARAM_INT);
			$command->bindParam(':pid',$pid,PDO::PARAM_STR);
			$command->bindParam(':name',$name,PDO::PARAM_STR);
			$command->bindParam(':event',$event,PDO::PARAM_STR);
			$command->bindParam(':eventkey',$eventkey,PDO::PARAM_STR);
			$command->bindValue(':eventurl',$eventurl,PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){print_r($e);
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function add($data)
	{
		$result = array('code'=>'','msg'=>'');	
		$pid = $data['pid'];	
		$name = $data['name'];
		$event = $data['event'];
		$eventkey = $data['eventkey'];
		$eventurl = $data['eventurl'];

		if($event=='click'){
			$eventurl = '';
		}else{
			$eventkey = '';
		}

		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "INSERT INTO same_temp SET pid=:pid,name=:name, event=:event,eventkey=:eventkey, eventurl=:eventurl";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':pid',$pid,PDO::PARAM_STR);
			$command->bindParam(':name',$name,PDO::PARAM_STR);
			$command->bindParam(':event',$event,PDO::PARAM_STR);
			$command->bindParam(':eventkey',$eventkey,PDO::PARAM_STR);
			$command->bindValue(':eventurl',$eventurl,PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){print_r($e);
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function delete($data)
	{
		$sql = "DELETE FROM same_temp WHERE id=".$data['id'];
		$this->_db->createCommand($sql)->execute();
		$result['code'] = 1;
		$result['msg']  = '删除成功';
		return json_encode($result);

	}


	
}