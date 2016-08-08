<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');
?>
<div id="SystemFranchiPreferentialEditPanel">
	<div style="text-align:center" >
		<form id="SystemFranchiPreferentialEditForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				<tr>
					<td style="text-align:right" class="row">城市：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-combobox" name="SystemFranchiPreferentialEditCityCombobox" id="SystemFranchiPreferentialEditCityCombobox" data-options='  
								valueField: "id",
								textField: "cname",
								data: <?php echo $cityList;?>,
								onLoadSuccess:function(){
									$("#SystemFranchiPreferentialEditCityCombobox").combobox("setValue", "<?php echo $preferentialMsg["cid"];?>");
								}'>
					</td>
				</tr>				
				<tr>
					<td style="text-align:right" class="row">优惠名称：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-validatebox" type="text" name="SystemFranchiPreferentialEditName" id="SystemFranchiPreferentialEditName" data-options="required:true" value="<?php echo $preferentialMsg["name"];?>" />  
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="row">副标题</td>
					<td style="text-align:left" class="row">
						<input class="easyui-validatebox" rows="5" cols="50" name="SystemFranchiPreferentialEditF_title" id="SystemFranchiPreferentialEditF_title" data-options="required:true" value="<?php echo $preferentialMsg["f_title"];?>">
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="row">优惠内容：(50字内)</td>
					<td style="text-align:left" class="row">
						<textarea class="easyui-validatebox" rows="5" cols="50" maxlength=50 name="SystemFranchiPreferentialEditContent" id="SystemFranchiPreferentialEditContent" data-options="required:true" ><?php echo $preferentialMsg["content"];?></textarea> 
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">生效日期：</td>
					<td style="text-align:left;" class="row">
						<input id="SystemFranchiPreferentialEditSdate"  name="SystemFranchiPreferentialEditSdate" type="text" class="easyui-datebox" required="required" value="<?php echo $preferentialMsg['edate']?>"></input>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">失效日期：</td>
					<td style="text-align:left;" class="row">
						<input id="SystemFranchiPreferentialEditEdate" name="SystemFranchiPreferentialEditEdate" type="text" class="easyui-datebox" required="required" value="<?php echo $preferentialMsg['edate']?>"></input>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">图片：<br>高宽(131px*131px)</td>
					<td style="text-align:left;" class="row">
						<div id="SystemFranchiPreferentialEditSimgShowArea">
							<img src="<?php echo $baseUrl.$preferentialMsg['img']?>" id="SystemFranchiPreferentialEditSimgShow" width="200px">
						</div>
						<div id="SystemFranchiPreferentialEditSimgBut" style="width:120px">
							<div id="SystemFranchiPreferentialEditSimgProcessing" style="display:none">
								<img id="SystemFranchiPreferentialEditSimgShow" src="<?php echo $baseUrl?>/images/processing.gif" style="width: 20px;">
							</div>
							<div id="SystemFranchiPreferentialEditBimgButText" style="padding:10px 0 10px 0;"><a href="javascript:void(0)" class="easyui-linkbutton" >点击上传图片</a></div>
						</div>
						<input type="hidden" value="<?php echo $preferentialMsg['img']?>" name="SystemFranchiPreferentialEditSimg" id="SystemFranchiPreferentialEditSimg">
					</td>
				</tr>				
				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<input type="hidden" value="<?php echo $preferentialMsg['id']?>" name="SystemFranchiPreferentialEditID" id="SystemFranchiPreferentialEditID">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemFranchiPreferentialEdit.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemFranchiPreferentialEdit = {
		init:function(){
			$("#SystemFranchiPreferentialEditPanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '编辑门店详细信息',  
										});
			systemFranchiPreferentialEdit.createUploader('SystemFranchiPreferentialEditSimg');
		},
		submitForm:function(){
			var city = $("input[name='SystemFranchiPreferentialEditCityCombobox']").val();
			var name = $("#SystemFranchiPreferentialEditName").val();
			var f_title = $("#SystemFranchiPreferentialEditF_title").val();
			var content = $("#SystemFranchiPreferentialEditContent").val();
			var sdate = $("input[name='SystemFranchiPreferentialEditSdate']").val();
			var edate = $("input[name='SystemFranchiPreferentialEditEdate']").val();
			var img = $("#SystemFranchiPreferentialEditSimg").val();
			var id = $("#SystemFranchiPreferentialEditID").val();
			

			if(!systemFranchiPreferentialEdit.alertInfoMsg(city,'请选择城市'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(name,'请填写优惠名称'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(f_title,'请填写副标题'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(content,'请填写内容'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(sdate,'请填生效日期'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(edate,'请填失效日期'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(img,'请选择优惠图片'))return false;
			if(!systemFranchiPreferentialEdit.alertInfoMsg(id,'数据非法提交'))return false;

			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/franchise/preferentialUpdate',
				data:{"img":img,"city":city,"id":id,"name":name,"f_title":f_title,"content":content,"sdate":sdate,"edate":edate},
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
				$("#"+obj+"Show").attr('src', BASEUSER+"/"+xhr.uploadName);
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
	
	systemFranchiPreferentialEdit.init();
//-->
</script>