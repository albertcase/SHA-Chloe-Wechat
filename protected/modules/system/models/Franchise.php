<?php 
/**
 * 
 * 管理系统后台门店处理Model
 * @author TomHe
 *
 */
class Franchise
{
	private $_db = NULL;
	
	public function __construct()
	{
		$this->_db = Yii::app()->db;	
	}

	public function applylist($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50; 
		$search = isset($data['city'])&&$data['city']!='' ? " and D.cid = '".$data['city']."'" : ''; 
		$search .= isset($data['date'])&&$data['date']!='' ? " and D.sdate = '".$data['date']."'" : '';
		$search .= isset($data['time'])&&$data['time']!='' ? " and D.stime = '".$data['time']."'" : ''; 	 				
		$offset = ($page-1)*$rows;
		$where = '1';
		

		$sqlCount = "SELECT count(A.id) FROM trio_franchise_apply A, trio_franchise_city B,trio_franchise_area C,trio_sys_affiliate D WHERE $where $search AND D.cid=B.id AND D.aid=C.id and A.applyId=D.id order by A.id desc limit $offset,$rows";
		$menuCount = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT A.*,B.name AS cname,C.name AS aname,D.address as daddress,D.sdate as dsdate,D.stime as dstime FROM trio_franchise_apply A, trio_franchise_city B,trio_franchise_area C,trio_sys_affiliate D WHERE $where $search AND D.cid=B.id AND D.aid=C.id and A.applyId=D.id order by A.id desc limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$sqltotal= "SELECT sum(A.num) FROM trio_franchise_apply A, trio_franchise_city B,trio_franchise_area C,trio_sys_affiliate D WHERE $where $search AND D.cid=B.id AND D.aid=C.id and A.applyId=D.id";
		$totalCount = $this->_db->createCommand($sqltotal)->select()->queryScalar();
		$menuAll = array("total"=>$menuCount,"rows"=>$menuAll,"num"=>$totalCount ? $totalCount : 0);
		return json_encode($menuAll);
	}

	public function cityListForEdit($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;  		
		$offset = ($page-1)*$rows;
		$where = '1';
		

		$sqlCount = "SELECT count(id) AS num FROM same_type WHERE $where";
		$menuCount = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT * FROM same_type WHERE $where limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$menuAll = array("total"=>$menuCount,"rows"=>$menuAll);
		return json_encode($menuAll);
	}

	public function cityListForcombobox()
	{
		$sql = "SELECT id, name AS cname FROM same_type where status=1";
		$pAll = $this->_db->createCommand($sql)->select()->queryAll();		
		return json_encode($pAll);
	}

	public function dateListForcombobox($cid)
	{
		$sql = "SELECT DISTINCT (sdate) AS date FROM `trio_sys_affiliate` where cid='".$cid."' ORDER BY date";
		$pAll = $this->_db->createCommand($sql)->select()->queryAll();		
		return json_encode($pAll);
	}

	public function positionListForcombobox()
	{
		$sql = "SELECT DISTINCT(name) as pname FROM `trio_sys_position`";
		$pAll = $this->_db->createCommand($sql)->select()->queryAll();		
		return json_encode($pAll);
	}


	public function timeListForcombobox($cid,$date)
	{
		$sql = "SELECT DISTINCT (stime) AS time FROM `trio_sys_affiliate` where cid='".$cid."' and sdate='".$date."' ORDER BY time";
		$pAll = $this->_db->createCommand($sql)->select()->queryAll();		
		return json_encode($pAll);
	}

	public function cityadd($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "INSERT INTO same_type SET name=:name, status=:status";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindParam(':status',$data['status'],PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function cityupdate($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "UPDATE same_type SET name=:name, status=:status WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);			
			$command->bindParam(':status',$data['status'],PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function citystatus($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$ids = explode(",", $data['ids']);
			$sysUserName = Yii::app()->user->sysUserName;
			for($i=0;$i<count($ids);$i++){
				$sql = "UPDATE same_type SET uid=:uid, uname=:uname, status=0 WHERE id=:id";
				$command = $this->_db->createCommand($sql);
				$command->bindParam(':id',$ids[$i],PDO::PARAM_INT);		
				$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
				$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
				$command->execute();
			}
			
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function areastatus($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$ids = explode(",", $data['ids']);
			$sysUserName = Yii::app()->user->sysUserName;
			for($i=0;$i<count($ids);$i++){
				$sql = "UPDATE trio_franchise_area SET uid=:uid, uname=:uname, status=0 WHERE id=:id";
				$command = $this->_db->createCommand($sql);
				$command->bindParam(':id',$ids[$i],PDO::PARAM_INT);		
				$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
				$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
				$command->execute();
			}
			
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}



	public function AreaListForEdit($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;  		
		$offset = ($page-1)*$rows;
		$where = 'cid in (select id from trio_franchise_city where status=1)';
		

		$sqlCount = "SELECT count(id) AS num FROM trio_franchise_area WHERE $where";
		$menuCount = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT A.*,B.name AS cname FROM trio_franchise_area A LEFT JOIN trio_franchise_city B ON A.cid=B.id WHERE $where limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$menuAll = array("total"=>$menuCount,"rows"=>$menuAll);
		return json_encode($menuAll);
	}
	
	public function AreaListForStreet($cid,$aid=null)
	{
		$sql = "SELECT id, name AS aname, cid FROM trio_franchise_area WHERE cid=:cid ";
		$command = $this->_db->createCommand($sql);
		$command->bindParam(':cid',$cid,PDO::PARAM_STR);
		$pAll = $command->select()->queryAll();
		if($aid){
			for($i=0;$i<count($pAll);$i++){
				if($pAll[$i]['id']==$aid){
					$pAll[$i]['selected'] = true;
				}
			}
		}
		return json_encode($pAll);
	}

	public function AreaListByid($id)
	{
		$sql = "SELECT * FROM trio_franchise_area WHERE id=:id ";
		$command = $this->_db->createCommand($sql);
		$command->bindParam(':id',$id,PDO::PARAM_STR);
		$pAll = $command->select()->queryRow();
		return json_encode($pAll);
	}

	public function areaadd($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "INSERT INTO trio_franchise_area SET cid=:cid, name=:name, uid=:uid, uname=:uname, status=:status, repair=:repair, bak=:bak";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':cid',$data['cid'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
			$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
			$command->bindParam(':status',$data['status'],PDO::PARAM_STR);
			$command->bindParam(':repair',$data['repair'],PDO::PARAM_STR);
			$command->bindParam(':bak',$data['bak'],PDO::PARAM_STR);
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

	public function areaupdate($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "UPDATE trio_franchise_area SET cid=:cid, name=:name, uid=:uid, uname=:uname, status=:status, repair=:repair, bak=:bak WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$command->bindParam(':cid',$data['cid'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
			$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
			$command->bindParam(':status',$data['status'],PDO::PARAM_STR);
			$command->bindParam(':repair',$data['repair'],PDO::PARAM_STR);
			$command->bindParam(':bak',$data['bak'],PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function streetListForStores($aid,$sid=null)
	{
		$sql = "SELECT id, name AS sname FROM trio_franchise_street WHERE aid=:aid ";
		$command = $this->_db->createCommand($sql);
		$command->bindParam(':aid',$aid,PDO::PARAM_STR);
		$pAll = $command->select()->queryAll();	
		if($sid){
			for($i=0;$i<count($pAll);$i++){
				if($pAll[$i]['id']==$sid){
					$pAll[$i]['selected'] = true;
				}
			}
		}
		return json_encode($pAll);
	}

	public function streeListForEdit()
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;  		
		$offset = ($page-1)*$rows;
		$where = '1';
		

		$sqlCount = "SELECT count(id) AS num FROM trio_franchise_street WHERE $where";
		$menuCount = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT A.id,A.name,A.uname,A.createtime,B.name AS cid,C.name AS aid FROM trio_franchise_street A, trio_franchise_city B,trio_franchise_area C WHERE $where AND A.cid=B.id AND A.aid=C.id limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$menuAll = array("total"=>$menuCount,"rows"=>$menuAll);
		return json_encode($menuAll);

	}


	public function streetadd($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "INSERT INTO trio_franchise_street SET cid=:cid, aid=:aid, name=:name, uid=:uid, uname=:uname";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':aid',$data['aid'],PDO::PARAM_STR);
			$command->bindParam(':cid',$data['cid'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
			$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
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

	public function streetupdate($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "UPDATE trio_franchise_street SET cid=:cid, aid=:aid, name=:name, uid=:uid, uname=:uname WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$command->bindParam(':aid',$data['aid'],PDO::PARAM_STR);
			$command->bindParam(':cid',$data['cid'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
			$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function storesList($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;
		$search = isset($data['search']) ? $data['search'] : '';
		$offset = ($page-1)*$rows;
		$where = '1';
		
		if($search){
			$where .= " AND A.name like '%".$search."%' ";
		}
		

		$sqlCount = "SELECT count(id) AS num FROM same_pic A WHERE $where";
		$count = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT A.*,B.name FROM `same_pic` A, same_type B WHERE $where AND A.tid=B.id limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$menuAll = array("total"=>$count,"rows"=>$menuAll);
		return json_encode($menuAll);
	}

	public function getStoresById($id)
	{
		$sql="SELECT * FROM same_pic where id=".$id;
		$rs=$this->_db->createCommand($sql)->select()->queryRow();
		return $rs;
	}

	public function storesUpdate($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$root = YiiBase::getPathOfAlias('webroot');
			if(strstr($data['img'],'temp')){
				$img = $root.$data['img'];				
				$newImg = '/upload/img/'.date('Ymd').'/'.basename($img);

				$folder = '/upload/img/'.date("Ymd").'/';
				if(!is_dir($root.$folder)){        	
					if(!mkdir($root.$folder, 0777, true))	
					{	
						throw new Exception('创造文件夹失败...');
					}
					chmod($root.$folder,0777);
				}
				rename($img, $root.$newImg);
			}else{
				$newImg = $data['img'];
			}
			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "UPDATE same_pic SET tid=:tid, url=:url WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$command->bindParam(':tid',$data['city'],PDO::PARAM_STR);
			$command->bindParam(':url',$data['img'],PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function storesAdd($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$root = YiiBase::getPathOfAlias('webroot');
			if(strstr($data['img'],'temp')){
				$img = $root.$data['img'];				
				$newImg = '/upload/img/'.date('Ymd').'/'.basename($img);

				$folder = '/upload/img/'.date("Ymd").'/';
				if(!is_dir($root.$folder)){        	
					if(!mkdir($root.$folder, 0777, true))	
					{	
						throw new Exception('创造文件夹失败...');
					}
					chmod($root.$folder,0777);
				}
				rename($img, $root.$newImg);
			}else{
				$newImg = $data['img'];
			}
			$sql = "INSERT INTO same_pic SET tid=:tid, url=:url";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':tid',$data['city'],PDO::PARAM_STR);
			$command->bindParam(':url',$newImg,PDO::PARAM_STR);
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

	public function storesDelete($data)
	{
		$sql = "DELETE FROM same_pic WHERE id=".$data['id'];
		$rs = $this->_db->createCommand($sql)->execute();
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function preferentialList($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;  		
		$search = isset($data['search']) ? $data['search'] : '';
		$offset = ($page-1)*$rows;
		$where = '1';
		
		if($search){
			$where .= " AND B.name like '%".$search."%' ";
		}
		

		$sqlCount = "SELECT count(id) AS num FROM trio_franchise_preferential B WHERE $where";
		$count = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT B.id, B.name, B.f_title, B.img, B.sdate, B.edate, B.uname, B.createtime, A.name AS cid FROM trio_franchise_city A, trio_franchise_preferential B WHERE $where AND B.cid=A.id ORDER BY B.id DESC limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();
		$menuAll = array("total"=>$count,"rows"=>$menuAll);
		return json_encode($menuAll);
	}

	public function getPreferentialById($id)
	{
		$sql="SELECT * FROM trio_franchise_preferential where id=".$id;
		$rs=$this->_db->createCommand($sql)->select()->queryRow();
		return $rs;
	}

	public function stroesListForPreferential($sid,$ssid=null)
	{
		$sql = "SELECT id, name AS sname FROM trio_franchise_stroes WHERE sid=:sid ";
		$command = $this->_db->createCommand($sql);
		$command->bindParam(':sid',$sid,PDO::PARAM_STR);
		$pAll = $command->select()->queryAll();
		if($ssid){
			for($i=0;$i<count($pAll);$i++){
				if($pAll[$i]['id']==$ssid){
					$pAll[$i]['selected'] = true;
				}
			}
		}
		return json_encode($pAll);
	}

	public function preferentialUpdate($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$root = YiiBase::getPathOfAlias('webroot');
			if(strstr($data['img'],'temp')){
				$img = $root.$data['img'];				
				$newImg = '/upload/img/'.date('Ymd').'/'.basename($img);

				$folder = '/upload/img/'.date("Ymd").'/';
				if(!is_dir($root.$folder)){        	
					if(!mkdir($root.$folder, 0777, true))	
					{	
						throw new Exception('创造文件夹失败...');
					}
					chmod($root.$folder,0777);
				}
				rename($img, $root.$newImg);
			}else{
				$newImg = $data['img'];
			}

			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "UPDATE trio_franchise_preferential SET cid=:cid, name=:name, f_title=:f_title, content=:content, sdate=:sdate, edate=:edate, img=:img, uid=:uid, uname=:uname WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$command->bindParam(':cid',$data['city'],PDO::PARAM_STR);
			$command->bindParam(':f_title',$data['f_title'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindParam(':content',$data['content'],PDO::PARAM_STR);
			$command->bindParam(':sdate',$data['sdate'],PDO::PARAM_STR);
			$command->bindParam(':edate',$data['edate'],PDO::PARAM_STR);
			$command->bindParam(':img',$newImg,PDO::PARAM_STR);
			$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
			$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
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

	public function preferentialAdd($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$root = YiiBase::getPathOfAlias('webroot');
			if(strstr($data['img'],'temp')){
				$img = $root.$data['img'];				
				$newImg = '/upload/img/'.date('Ymd').'/'.basename($img);

				$folder = '/upload/img/'.date("Ymd").'/';
				if(!is_dir($root.$folder)){        	
					if(!mkdir($root.$folder, 0777, true))	
					{	
						throw new Exception('创造文件夹失败...');
					}
					chmod($root.$folder,0777);
				}
				rename($img, $root.$newImg);
			}else{
				$newImg = $data['img'];
			}

			$sysUserName = Yii::app()->user->sysUserName;
			$sql = "INSERT INTO trio_franchise_preferential SET cid=:cid, name=:name, f_title=:f_title, content=:content, sdate=:sdate, edate=:edate, img=:img, uid=:uid, uname=:uname";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':cid',$data['city'],PDO::PARAM_STR);
			$command->bindParam(':f_title',$data['f_title'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindParam(':content',$data['content'],PDO::PARAM_STR);
			$command->bindParam(':sdate',$data['sdate'],PDO::PARAM_STR);
			$command->bindParam(':edate',$data['edate'],PDO::PARAM_STR);
			$command->bindParam(':img',$newImg,PDO::PARAM_STR);
			$command->bindValue(':uid',Yii::app()->user->sysUserId,PDO::PARAM_STR);
			$command->bindParam(':uname',$sysUserName,PDO::PARAM_STR);
			$command->execute();
		}catch(Exception $e){
			$result['code'] = 0;
			$result['msg']  = '系统服务错误';
			return json_encode($result);
		}
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function preferentialDelete($data)
	{
		$sql = "DELETE FROM trio_franchise_preferential WHERE id=".$data['id'];
		$rs = $this->_db->createCommand($sql)->execute();
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	public function servicelist($data)
	{
		$page = isset($data['page']) ? intval($data['page']) : 1;  
		$rows = isset($data['rows']) ? intval($data['rows']) : 50;  		
		$offset = ($page-1)*$rows;
		$where = '1';
		

		$sqlCount = "SELECT count(id) AS num FROM trio_service WHERE $where";
		$menuCount = $this->_db->createCommand($sqlCount)->select()->queryScalar();

		$sql = "SELECT * FROM trio_service WHERE $where  order by num asc,id desc limit $offset,$rows";
		$command = $this->_db->createCommand($sql);		
		$menuAll = $command->select()->queryAll();

		$menuAll = array("total"=>count($menuCount),"rows"=>$menuAll);
		return json_encode($menuAll);
	}

	public function serviceadd($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$Img = $this->renameUploadFile($data['img'],'img');
			$sql = "INSERT INTO trio_service SET name=:name, img=:img,num=:num";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindParam(':img',$Img,PDO::PARAM_STR);
			$command->bindParam(':num',$data['num'],PDO::PARAM_STR);
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
	
	public function serviceupdate($data)
	{
		$result = array('code'=>'','msg'=>'');
		try{
			$Img = $this->renameUploadFile($data['img'],'img');
			$sql = "UPDATE trio_service SET name=:name, img=:img,num=:num WHERE id=:id";
			$command = $this->_db->createCommand($sql);
			$command->bindParam(':id',$data['id'],PDO::PARAM_STR);
			$command->bindParam(':name',$data['name'],PDO::PARAM_STR);
			$command->bindParam(':img',$Img,PDO::PARAM_STR);
			$command->bindParam(':num',$data['num'],PDO::PARAM_STR);
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

	public function getservice($id)
	{	
		$sql="SELECT * FROM trio_service  WHERE  id=".$id;
		$rs=$this->_db->createCommand($sql)->select()->queryRow();
		return $rs;

	}

	public function serviceDelete($data){
		$sql = "DELETE FROM trio_service WHERE id=".$data['id'];
		$rs = $this->_db->createCommand($sql)->execute();
		$result['code'] = 1;
		$result['msg']  = '操作成功';
		return json_encode($result);
	}

	protected function renameUploadFile($fliePath,$type)
	{
		$root = YiiBase::getPathOfAlias('webroot');
		if(strstr($fliePath,'temp')){
			$img = $root.$fliePath;				
			$newImg = '/upload/'.$type.'/'.date('Ymd').'/'.basename($img);

			$folder = '/upload/'.$type.'/'.date("Ymd").'/';
			if(!is_dir($root.$folder)){        	
				if(!mkdir($root.$folder, 0777, true))	
				{	
					throw new Exception('创造文件夹失败...');
				}
				chmod($root.$folder,0777);
			}
			rename($img, $root.$newImg);
		}else{
			$newImg = $fliePath;
		}
		return $newImg;
	}

}