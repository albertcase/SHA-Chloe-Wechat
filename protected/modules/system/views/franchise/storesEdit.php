<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');
?>
<div id="SystemFranchiStoresEditPanel">
	<div style="text-align:center" >
		<form id="SystemFranchiStoresEditForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				<tr>
					<td style="text-align:right" class="row">所属分类：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-combobox" name="SystemFranchiStoresEditCityCombobox" id="SystemFranchiStoresEditCityCombobox" data-options='  
								valueField: "id",
								textField: "cname",
								data: <?php echo $cityList;?>,
								onSelect: function(record){
									$("#SystemFranchiStoresEditStreetCombobox").combobox("setValue", ""); 
								},
								onLoadSuccess:function(){
									$("#SystemFranchiStoresEditCityCombobox").combobox("setValue", "<?php echo $storesMsg["tid"];?>");
								}'>
					</td>
				</tr>
				
				<tr>
					<td style="text-align:right;" class="row">图片：</td>
					<td style="text-align:left;" class="row">
						<div id="SystemFranchiStoresEditSimgShowArea">
							<img src="<?php echo $storesMsg['url']?>" id="SystemFranchiStoresEditSimgShow">
						</div>
						<div id="SystemFranchiStoresEditSimgBut" style="width:120px">
							<div id="SystemFranchiStoresEditSimgProcessing" style="display:none">
								<img id="SystemFranchiStoresEditSimgShow" src="<?php echo $baseUrl?>/images/system/processing.gif" style="width: 20px;">
							</div>
							<div id="SystemFranchiStoresEditSimgButText" style="padding:10px 0 10px 0;"><a href="javascript:void(0)" class="easyui-linkbutton" >点击上传图片</a></div>
						</div>
						<input type="hidden" value="<?php echo $storesMsg['url']?>" name="SystemFranchiStoresEditSimg" id="SystemFranchiStoresEditSimg">
					</td>
				</tr>

				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<input type="hidden" value="<?php echo $storesMsg['id']?>" name="SystemFranchiStoresEditID" id="SystemFranchiStoresEditID">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemFranchiStoresEdit.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemFranchiStoresEdit = {
		init:function(){
			$("#SystemFranchiStoresEditPanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '编辑图片',  
										});
			systemFranchiStoresEdit.createUploader('SystemFranchiStoresEditSimg');
		},
		submitForm:function(){
			var city = $("input[name='SystemFranchiStoresEditCityCombobox']").val();
			
			var img = $("#SystemFranchiStoresEditSimg").val();
			
			var id = $("#SystemFranchiStoresEditID").val();

			if(!systemFranchiStoresEdit.alertInfoMsg(city,'请选择城市'))return false;
			if(!systemFranchiStoresEdit.alertInfoMsg(img,'请上传图片'))return false;

			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/franchise/storesUpdate',
				data:{"city":city,"id":id,"img":img},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$.messager.alert('系统消息',data.msg);
						$('#tt').tabs('close','编辑图片').tabs("select","图片列表");
						$('#systemFranchiStoresDatagrid').datagrid('reload');
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		},
		checkCheckBoxVal:function(obj){
			return $("#"+obj).attr("checked") ? $("#"+obj).val()+',' : '';
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
		}
	}
	
	systemFranchiStoresEdit.init();
//-->
</script>