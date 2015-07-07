<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');
?>
<div id="SystemWmenuAddstorePanel">
	<div style="text-align:center" >
		<form id="SystemWmenuAddstoreForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				
				<tr id="SystemWmenuAddstoreCountryArea">
					<td style="text-align:right" class="row">国家：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreCountry" name="SystemWmenuAddstoreCountry" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreCityArea">
					<td style="text-align:right" class="row">城市：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreCity" name="SystemWmenuAddstoreCity" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreNameArea">
					<td style="text-align:right" class="row">门店名称：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreName" name="SystemWmenuAddstoreName" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreAddressArea">
					<td style="text-align:right" class="row">门店地址：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreAddress" name="SystemWmenuAddstoreAddress" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreTelphoneArea">
					<td style="text-align:right" class="row">电话：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreTelphone" name="SystemWmenuAddstoreTelphone" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreOpenArea">
					<td style="text-align:right" class="row">营业时间：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreOpen" name="SystemWmenuAddstoreOpen" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreLatArea">
					<td style="text-align:right" class="row">经度：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreLat" name="SystemWmenuAddstoreLat" value="">
					</td>
				</tr>

				<tr id="SystemWmenuAddstoreLngArea">
					<td style="text-align:right" class="row">纬度：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuAddstoreLng" name="SystemWmenuAddstoreLng" value="">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemWmenuAddstore.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemWmenuAddstore = {
		init:function(){
			$("#SystemWmenuAddstorePanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '添加门店',  
										});                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
			systemWmenuAddstore.createUploader('SystemWmenuAddstoreSimg');
			
		},
		getstore:function(){
			var formdata = {
				sceneId : $("input[name='SystemWmenuAddstoreSceneId']").val()
			}
			if(!formdata.sceneId){
				$.messager.alert('系统消息',"请输入场景值",'error');
				return false;
			}
			if(formdata.sceneId<=0||formdata.sceneId>100000){
				$.messager.alert('系统消息',"场景值范围在1~100000之间",'error');
				return false;
			}
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/wmenu/getstore',
				data:formdata,
				dataType:"JSON",
				success:function(data){					
					$("#SystemWmenuAddstoreTicket").val(data.ticket);
					$("#SystemWmenuAddstoreImgArea img").attr("src","https://mp.weixin.qq.com/cgi-bin/showstore?ticket="+data.ticket)

				}
			});
			
		},
		submitForm:function(){			
			var formdata = {
				bak : $("#SystemWmenuAddstoreBak").val(),
				sceneId : $("input[name='SystemWmenuAddstoreSceneId']").val(),
				ticket : $("#SystemWmenuAddstoreTicket").val()
			}
			if(!formdata.bak){
				$.messager.alert('系统消息',"请输入二维码说明",'error');
				return false;
			}
			if(!formdata.ticket){
				$.messager.alert('系统消息',"请先生成二维码后再提交",'error');
				return false;
			}
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/wmenu/storeadd',
				data:formdata,
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$.messager.alert('系统消息',data.msg);
						$('#tt').tabs('close','添加二维码').tabs("select","二维码列表");
						$('#systemWmenustoreDatagrid').datagrid('reload');
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		},		
		alertInfoMsg:function(val,msg){
			if(!val){
				$.messager.alert('系统消息',msg,'info');
				return false;
			}else{
				return true;
			}
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
				$("#"+obj+"Show").attr('src', BASEUSER+"/"+xhr.uploadName);
				$("#"+obj).val(xhr.uploadName);
				$("#"+obj+"ButText").show();
				$("#"+obj+"Processing").hide();
			}).on('upload',function(id, fileName){
				//alert('upload');
			}).on('submit', function(store, id, name) {
				// alert('onsubmit');//$(this).fineUploader('setParams', {'param1': 'val1'});
			}).on('error',function(id, name, errorReason, xhr){
				alert(xhr)
			});
		},
	}
	
	systemWmenuAddstore.init();
//-->
</script>