<?php

class ApiController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionList()
	{
		$sql = "select id,name from same_type";
		$typeList = Yii::app()->db->createCommand($sql)->queryAll();
		$sql2 = "select tid,url from same_pic where tid in (select id from same_type)";
		$picList = Yii::app()->db->createCommand($sql2)->queryAll();
		for ($i=0;$i<count($picList);$i++) {
			for ($j=0;$j<count($typeList);$j++) {
				if ($typeList[$j]['id'] == $picList[$i]['tid']) {
					$typeList[$j]['list'][]=$picList[$i];
				}
			}
		}
		echo json_encode($typeList);exit;
		$store = Yii::app()->db->createCommand($sql)->queryRow();
		$this->render('store', array('store' => $store));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}