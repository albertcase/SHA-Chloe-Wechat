<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');
$cs->registerScriptFile($baseUrl.'/js/ckeditor/ckeditor.js');
$cs->registerScriptFile($baseUrl.'/js/ckfinder/ckfinder.js');
?>
<div id="systemServiceEditPanel">
	<div style="text-align:center" >
		<form id="systemServiceEditForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">名称：</td>
					<td style="text-align:left;" class="row">
						<input type="text" name="systemServiceEditName" id="systemServiceEditName" value="<?php echo $rsMsg['name']?>">
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">图片：<br>(高宽32px*32px)</td>
					<td style="text-align:left;" class="row">
						<div id="systemServiceEditImgShowArea">
							<img src="<?php echo $rsMsg['img']?>" id="systemServiceEditImgShow" width="200px">
						</div>
						<div id="systemServiceEditImgBut" style="width:120px">
							<div id="systemServiceEditImgProcessing" style="display:none">
								<img id="systemServiceEditImgShow" src="<?php echo $baseUrl?>/images/processing.gif" style="width: 20px;">
							</div>
							<div id="systemServiceEditImgButText" style="padding:10px 0 10px 0;"><a href="javascript:void(0)" class="easyui-linkbutton" >点击上传图片</a></div>
						</div>
						<span id="imgWidth"></span>
						<input type="hidden" name="systemServiceEditImg" id="systemServiceEditImg"  value="<?php echo $rsMsg['img']?>">
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">名称：</td>
					<td style="text-align:left;" class="row">
						<input type="text" name="systemServiceEditNum" id="systemServiceEditNum" value="<?php echo $rsMsg['num']?>">
					</td>
				</tr>	
				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<input type="hidden" name="systemServiceEditId" id="systemServiceEditId" value="<?php echo $rsMsg['id']?>">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemServiceEdit.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemServiceEdit = {
		init:function(){
			$("#systemServiceEditPanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '编辑门店服务',  
										});
			systemServiceEdit.createUploader('systemServiceEditImg');
			
		},
		submitForm:function(){
			var id=$("#systemServiceEditId").val();
			var name = $("#systemServiceEditName").val();
			var img = $("#systemServiceEditImg").val();
			var num = $("#systemServiceEditNum").val();

			if(!systemServiceEdit.alertInfoMsg(name,'请填写名称'))return false;
			if(!systemServiceEdit.alertInfoMsg(img,'请上传图片'))return false;
			if(!systemServiceEdit.alertInfoMsg(num,'请填写排序'))return false;
			//if(!systemServiceEdit.alertInfoMsg(keywords,'请填写任职资格'))return false;


			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/franchise/Serviceupdate',
				data:{"id":id,"name":name,"img":img,"num":num},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$.messager.alert('系统消息',data.msg);
						$('#tt').tabs('close','编辑门店服务').tabs("select","门店服务");
						$('#systemServiceDatagrid').datagrid('reload');
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		},
		createUploader:function (obj){
			$('#'+obj+'ShowArea').fineUploader({
				uploaderType: 'basic',
				multiple: false,
				debug: true,
				autoUpload: true,
				button: $("#"+obj+'But'),
				request: {
					endpoint: BASEUSER+'/system/home/upload'
				}
			}).on('progress',function(id, fileName, loaded, total){
				$("#"+obj+"ButText").hide();
				$("#"+obj+"Processing").show();
			}).on('complete',function(id, fileName, responseJSON,xhr){
				$("#"+obj+"Show").attr('src', BASEUSER+"/"+xhr.uploadName).css("width","200px");;
				$("#"+obj).val(xhr.uploadName);
				$("#"+obj+"ButText").show();
				$("#"+obj+"Processing").hide();
			}).on('upload',function(id, fileName){
				//alert('upload');
			}).on('submit', function(event, id, name) {
				// alert('onsubmit');//$(this).fineUploader('setParams', {'param1': 'val1'});
			}).on('error',function(id, name, errorReason, xhr){
				alert(xhr)
			});
		},
		alertInfoMsg:function(val,msg){
			if(!val){
				$.messager.alert('系统消息',msg,'info');
				return false;
			}else{
				return true;
			}
		}
	}
	
	systemServiceEdit.init();
//-->
</script>