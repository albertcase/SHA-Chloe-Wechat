<?php
class TempController extends SystemController
{
	public function actionIndex()
	{
		$weixin = new Weixin();
		$access_token = $weixin->getAccessToken();
		$url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=' . $access_token;
		$data = file_get_contents($url);
		$data = json_decode($data, true);
		$news_count = $data['news_count'];exit;
		$url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $access_token;
		$post_data = array('type' => 'news', 'offset' => '0', 'count'=>'20');	
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
		$output = curl_exec($ch);
		curl_close($ch);
		print $output;
		exit;
	}

	public function actionList()
	{
		if(isset($_POST)){
			$temp = new Temp();
			print $temp->list($_POST);
			Yii::app()->end();
		}
		echo json_encode(array('code' => '3', 'msg' => '参数错误'));
		Yii::app()->end();
	}

	public function actionEdit($id)
	{
		$temp = new Temp();
		$data = $temp->getDataById($id);
		$this->render('edit', array('data' => $data));
	}

	public function actionUpdate()
	{
		if(isset($_POST)){
			$temp = new Temp();
			print $temp->update($_POST);
			Yii::app()->end();
		}
		echo json_encode(array('code' => '3', 'msg' => '参数错误'));
		Yii::app()->end();
	}
	
	public function actionAdd()
	{
		if(isset($_POST) && !empty($_POST)){
			$temp = new Temp();
			print $temp->storesAdd($_POST);
			Yii::app()->end();
		}else{
			$this->render('add');
		}
	}

	public function actionStoresDelete()
	{
		if(isset($_POST) && !empty($_POST)){
			$temp = new Temp();
			print $temp->delete($_POST);
			Yii::app()->end();
		}else{
			echo json_encode(array('code'=>'3','msg'=>'参数错误'));
			Yii::app()->end();
		}
	}
	

}