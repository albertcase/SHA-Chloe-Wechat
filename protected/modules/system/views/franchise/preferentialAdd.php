<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');
?>
<div id="SystemFranchiPreferentialAddPanel">
	<div style="text-align:center" >
		<form id="SystemFranchiPreferentialAddForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				<tr>
					<td style="text-align:right" class="row">城市：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-combobox" name="SystemFranchiPreferentialAddCityCombobox" id="SystemFranchiPreferentialAddCityCombobox" data-options='  
								valueField: "id",
								textField: "cname",
								data: <?php echo $cityList;?>'>
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="row">优惠名称：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-validatebox" type="text" name="SystemFranchiPreferentialAddName" id="SystemFranchiPreferentialAddName" data-options="required:true" />  
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="row">副标题</td>
					<td style="text-align:left" class="row">
						<input class="easyui-validatebox" rows="5" cols="50" name="SystemFranchiPreferentialAddF_title" id="SystemFranchiPreferentialAddF_title" data-options="required:true" value="">
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">生效日期：</td>
					<td style="text-align:left;" class="row">
						<input id="SystemFranchiPreferentialAddSdate" name="SystemFranchiPreferentialAddSdate" type="text" class="easyui-datebox" required="required" value=""></input>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">失效日期：</td>
					<td style="text-align:left;" class="row">
						<input id="SystemFranchiPreferentialAddEdate" name="SystemFranchiPreferentialAddEdate" type="text" class="easyui-datebox" required="required" value=""></input>
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="row">优惠内容：(50字内)</td>
					<td style="text-align:left" class="row">
						<textarea class="easyui-validatebox" rows="5" cols="50" maxlength=50 name="SystemFranchiPreferentialAddContent" id="SystemFranchiPreferentialAddContent" data-options="required:true" ></textarea> 
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">图片：<br>高宽(131px*131px)</td>
					<td style="text-align:left;" class="row">
						<div id="SystemFranchiPreferentialAddSimgShowArea">
							<img src="" id="SystemFranchiPreferentialAddSimgShow" width="1px">
						</div>
						<div id="SystemFranchiPreferentialAddSimgBut" style="width:120px">
							<div id="SystemFranchiPreferentialAddSimgProcessing" style="display:none">
								<img id="SystemFranchiPreferentialAddSimgShow" src="<?php echo $baseUrl?>/images/processing.gif" style="width: 20px;">
							</div>
							<div id="SystemFranchiPreferentialAddBimgButText" style="padding:10px 0 10px 0;"><a href="javascript:void(0)" class="easyui-linkbutton" >点击上传图片</a></div>
						</div>
						<input type="hidden" value="" name="SystemFranchiPreferentialAddSimg" id="SystemFranchiPreferentialAddSimg">
					</td>
				</tr>				
				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemFranchiPreferentialAdd.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemFranchiPreferentialAdd = {
		init:function(){
			$("#SystemFranchiPreferentialAddPanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '添加门店优惠信息',  
										});
			systemFranchiPreferentialAdd.createUploader('SystemFranchiPreferentialAddSimg');
		},
		submitForm:function(){
			var city = $("input[name='SystemFranchiPreferentialAddCityCombobox']").val();
			var name = $("#SystemFranchiPreferentialAddName").val();
			var f_title = $("#SystemFranchiPreferentialAddF_title").val();
			var content = $("#SystemFranchiPreferentialAddContent").val();
			var sdate = $("input[name='SystemFranchiPreferentialAddSdate']").val();
			var edate = $("input[name='SystemFranchiPreferentialAddEdate']").val();
			var img = $("#SystemFranchiPreferentialAddSimg").val();

			if(!systemFranchiPreferentialAdd.alertInfoMsg(city,'请选择城市'))return false;			
			if(!systemFranchiPreferentialAdd.alertInfoMsg(name,'请填写优惠名称'))return false;
			if(!systemFranchiPreferentialAdd.alertInfoMsg(f_title,'请填写副标题'))return false;
			if(!systemFranchiPreferentialAdd.alertInfoMsg(content,'请填写内容'))return false;
			if(!systemFranchiPreferentialAdd.alertInfoMsg(img,'请选择优惠图片'))return false;

			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/franchise/preferentialAdd',
				data:{"img":img,"city":city,"name":name,"f_title":f_title,"content":content,"sdate":sdate,"edate":edate},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$.messager.alert('系统消息',data.msg);
						$('#tt').tabs('close','编辑门店优惠信息').tabs("select","门店优惠信息");
						$('#systemFranchiPreferentialDatagrid').datagrid('reload');
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
				$("#"+obj+"Show").attr('src', BASEUSER+"/"+xhr.uploadName).css("width","200px");
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
	
	systemFranchiPreferentialAdd.init();
//-->
</script>