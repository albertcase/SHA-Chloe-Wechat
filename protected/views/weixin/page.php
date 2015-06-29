<h1><?php echo $rs['title'];?></h1>
<?php $imgary=explode("|",$rs['img']);
for($i=0;$i<count($imgary)-1;$i++){
	echo '<img src="'.Yii::app()->request->baseUrl.$imgary[$i].'"><br>';
}
?>
<?php echo $rs['content'];?>