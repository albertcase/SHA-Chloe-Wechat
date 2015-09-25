<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');
?>
<div id="systemServiceAddPanel">
	<div style="text-align:center" >
		<form id="systemServiceAddForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">名称：</td>
					<td style="text-align:left;" class="row">
						<input type="text" name="systemServiceAddName" id="systemServiceAddName">
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">图片：<br>(高宽32px*32px)</td>
					<td style="text-align:left;" class="row">
						<div id="systemServiceAddImgShowArea">
							<img src="" id="systemServiceAddImgShow" width="1px">
						</div>
						<div id="systemServiceAddImgBut" style="width:120px">
							<div id="systemServiceAddImgProcessing" style="display:none">
								<img id="systemServiceAddImgShow" src="<?php echo $baseUrl?>/images/processing.gif" style="width: 20px;">
							</div>
							<div id="systemServiceAddImgButText" style="padding:10px 0 10px 0;"><a href="javascript:void(0)" class="easyui-linkbutton" >点击上传图片</a></div>
						</div>
						<span id="imgWidth"></span>
						<input type="hidden" name="systemServiceAddImg" id="systemServiceAddImg">
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">排序：(数字越小越靠前)</td>
					<td style="text-align:left;" class="row">
						<input type="text" name="systemServiceAddNum" id="systemServiceAddNum">
					</td>
				</tr>	
				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemServiceAdd.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemServiceAdd = {
		init:function(){
			$("#systemServiceAddPanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '添加门店服务',  
										});
			systemServiceAdd.createUploader('systemServiceAddImg');
			
		},
		submitForm:function(){
			var name = $("#systemServiceAddName").val();
			var img = $("#systemServiceAddImg").val();
			var num = $("#systemServiceAddNum").val();

			if(!systemServiceAdd.alertInfoMsg(name,'请填写名称'))return false;
			if(!systemServiceAdd.alertInfoMsg(img,'请上传图片'))return false;
			if(!systemServiceAdd.alertInfoMsg(num,'请填写排序'))return false;
			//if(!systemServiceAdd.alertInfoMsg(keywords,'请填写任职资格'))return false;


			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/franchise/AddService',
				data:{"name":name,"img":img,"num":num},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$.messager.alert('系统消息',data.msg);
						$('#tt').tabs('close','添加门店服务').tabs("select","门店服务");
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
	
	systemServiceAdd.init();
//-->
</script>