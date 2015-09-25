<?php
class FranchiseController extends SystemController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCity()
	{
		$this->render('city');
	}

	public function actionCitylist()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$cityJson = $franchise->cityListForEdit($_POST);
			echo $cityJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionCityadd()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$cityJson = $franchise->cityadd($_POST);
			echo $cityJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionCityupdate()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$cityJson = $franchise->cityupdate($_POST);
			echo $cityJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}
	
	/**
	  * 区域
	*/
	public function actionArealist()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$areaJson = $franchise->AreaListForEdit($_POST);
			echo $areaJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionArealistForStreet($cid,$aid=null)
	{
		$franchise = new Franchise();
		$areaJson = $franchise->AreaListForStreet($cid,$aid);
		echo $areaJson;
		Yii::app()->end();
	}

	public function actionArealistByid($id)
	{
		$franchise = new Franchise();
		$areaJson = $franchise->AreaListByid($id);
		echo $areaJson;
		Yii::app()->end();
	}

	public function actionArea()
	{
		$franchise = new Franchise();
		$cityList = $franchise->cityListForcombobox();
		$this->render('area',array('cityList'=>$cityList));
	}

	public function actionAreaadd()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$areaJson = $franchise->areaadd($_POST);
			echo $areaJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionAreaupdate()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$areason = $franchise->areaupdate($_POST);
			echo $areason;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionAreaStatus()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$areason = $franchise->areastatus($_POST);
			echo $areason;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionCityStatus()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$areason = $franchise->citystatus($_POST);
			echo $areason;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionStreet()
	{
		$franchise = new Franchise();
		$cityList = $franchise->cityListForcombobox();
		$this->render("street",array('cityList'=>$cityList));
	}

	public function actionStreetListForStroes($aid,$sid=null)
	{
		$franchise = new Franchise();
		$streetListJson = $franchise->streetListForStores($aid,$sid);
		echo $streetListJson;
		Yii::app()->end();
	}

	public function actionStreetlist()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$streeListJson = $franchise->streeListForEdit($_POST);
			echo $streeListJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionStreetadd()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$streetJson = $franchise->streetadd($_POST);
			echo $streetJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionStreetupdate()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$streetJson = $franchise->streetupdate($_POST);
			echo $streetJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionStores()
	{
		$this->render("stores");
	}

	public function actionStoresList()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$storesList = $franchise->storesList($_POST);
			echo $storesList;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionStoresEdit($id)
	{
		$franchise = new Franchise();
		$storesMsg = $franchise->getStoresById($id);
		$cityList = $franchise->cityListForcombobox();
		$this->render('storesEdit',array('storesMsg'=>$storesMsg,'cityList'=>$cityList));
	}

	public function actionStoresUpdate()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$storesJson = $franchise->storesUpdate($_POST);
			echo $storesJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}
	
	public function actionStoresAdd()
	{
		if(isset($_POST) && !empty($_POST)){
			$franchise = new Franchise();
			$rs = $franchise->storesAdd($_POST);
			echo $rs;
		}else{
			$franchise = new Franchise();
			$cityList = $franchise->cityListForcombobox();
			$this->render('storesAdd',array('cityList'=>$cityList));
		}
	}

	public function actionStoresDelete()
	{
		if(isset($_POST) && !empty($_POST)){
			$franchise = new Franchise();
			$rs = $franchise->storesDelete($_POST);
			echo $rs;
			Yii::app()->end();
		}else{
			echo json_encode(array('code'=>'3','msg'=>'参数错误'));
			Yii::app()->end();
		}
	}

	public function actionPreferential()
	{
		$this->render("preferential");
	}

	public function actionPreferentialList()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$preferentialList = $franchise->preferentialList($_POST);
			echo $preferentialList;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionPreferentialEdit($id)
	{
		$franchise = new Franchise();
		$preferentialMsg = $franchise->getPreferentialById($id);
		$cityList = $franchise->cityListForcombobox();
		$this->render('preferentialEdit',array('preferentialMsg'=>$preferentialMsg,'cityList'=>$cityList));
	}

	public function actionStroesListForPreferential($sid,$ssid=null)
	{
		$franchise = new Franchise();
		$stroesListJson = $franchise->stroesListForPreferential($sid,$ssid);
		echo $stroesListJson;
		Yii::app()->end();
	}

	public function actionPreferentialUpdate()
	{
		if(isset($_POST)){
			$franchise = new Franchise();
			$preferentialJson = $franchise->preferentialUpdate($_POST);
			echo $preferentialJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionPreferentialAdd()
	{
		if(isset($_POST) && !empty($_POST)){
			$franchise = new Franchise();
			$rs = $franchise->preferentialAdd($_POST);
			echo $rs;
		}else{
			$franchise = new Franchise();
			$cityList = $franchise->cityListForcombobox();
			$this->render('preferentialAdd',array('cityList'=>$cityList));
		}
	}

	public function actionPreferentialDelete()
	{
		if(isset($_POST) && !empty($_POST)){
			$franchise = new Franchise();
			$rs = $franchise->preferentialDelete($_POST);
			echo $rs;
			Yii::app()->end();
		}else{
			echo json_encode(array('code'=>'3','msg'=>'参数错误'));
			Yii::app()->end();
		}
	}

	public function actionService()
	{
		$this->render('service');
	}

	public function actionServicelist()
	{
		if(isset($_POST)){
			$sysuser = new Franchise();
			$sysuserJson = $sysuser->servicelist($_POST);
			echo $sysuserJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionServiceAdd()
	{
		
		$this->render('serviceadd');
	}

	public function actionAddService()
	{
		if(isset($_POST)){
			$sysuser = new Franchise();
			$sysuserJson = $sysuser->serviceadd($_POST);
			echo $sysuserJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionServiceEdit($id)
	{		
		$sysuser = new Franchise();
		$rsMsg = $sysuser->getservice($id);
		$this->render('serviceedit',array('rsMsg'=>$rsMsg));
	}

	public function actionServiceupdate()
	{
		if(isset($_POST)){
			$sysuser = new Franchise();
			$sysuserJson = $sysuser->serviceupdate($_POST);
			echo $sysuserJson;
			Yii::app()->end();
		}
		echo json_encode(array('code'=>'3','msg'=>'参数错误'));
		Yii::app()->end();
	}

	public function actionDeleteService()
	{
		if(isset($_POST) && !empty($_POST)){
			$sysuserJson = new Franchise();
			$rs = $sysuserJson->serviceDelete($_POST);
			echo $rs;
			Yii::app()->end();
		}else{
			echo json_encode(array('code'=>'3','msg'=>'参数错误'));
			Yii::app()->end();
		}
	}
	

}