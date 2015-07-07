<?php
$returnUrl = yii::app()->request->hostInfo.Yii::app()->user->returnUrl;
$cs=Yii::app()->getClientScript();
$baseUrl=Yii::app()->request->baseUrl;
$cs->registerCssFile($baseUrl.'/css/table.css');
$cs->registerScriptFile($baseUrl.'/js/jquery.fineuploader-3.7.0.min.js');

$msgTypeAry = array('text'=>'文本','news'=>'图文','image'=>'图片',);
?>
<div id="SystemWmenuEditstorePanel">
	<div style="text-align:center" >
		<form id="SystemWmenuEditstoreForm" method="post" action="">
			<table style="width:100%;text-align:center" cellspacing="0" summary="The technical specifications of the Apple PowerMac G5 series">
				<tr>
					<th scope="col" style="text-align:right;width:20%">名称</th>
					<th scope="col">操作项</th>
				</tr>
				<tr>
					<td style="text-align:right" class="row">用户事件：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-combobox" name="SystemWmenuEditstorestore" id="SystemWmenuEditstorestore" data-options='  
								valueField: "id",
								textField: "name",
								data: [{id:"subscribe",name:"关注"},{id:"click",name:"点击"},{id:"text",name:"接收文本"}],
								onSelect: function(record){
									if(record.id=="click"){
										$("#SystemWmenuEditstoreKeywordArea").hide()
										$("#SystemWmenuEditstoreMenuList").show();
									}else if("text"){
										$("#SystemWmenuEditstoreKeywordArea").show();
										$("#SystemWmenuEditstoreMenuList").hide();
									}else{
										$("#SystemWmenuEditstoreKeywordArea").hide();
										$("#SystemWmenuEditstoreMenuList").hide();
									}
								},
								onLoadSuccess:function(){
									$("#SystemWmenuEditstorestore").combobox("select", "<?php echo $wmenu["store"];?>");
									if("<?php echo $wmenu['store'];?>"=="click"){
										$("#SystemWmenuEditstoreMenuList").show();
									}
								}'>
						
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="row">消息类型：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-combobox" name="SystemWmenuEditstoreMsgtype" id="SystemWmenuEditstoreMsgtype" data-options='  
								valueField: "id",
								textField: "name",
								data: [{id:"text",name:"文本"},{id:"news",name:"图文"}],
								onSelect: function(record){
									if(record.id=="text"){
										$("#SystemWmenuEditstoreTextArea").show();
										$("#SystemWmenuEditstoreNewsArea").hide();
									}else if(record.id=="news"){
										$("#SystemWmenuEditstoreTextArea").hide();
										$("#SystemWmenuEditstoreNewsArea").show();
									}
								},
								onLoadSuccess:function(){
									$("#SystemWmenuEditstoreMsgtype").combobox("select", "<?php echo $wmenu["msgtype"];?>");
									
								}'>
					</td>
				</tr>
				<tr id="SystemWmenuEditstoreMenuList" style="display:none">
					<td style="text-align:right" class="row">菜单：</td>
					<td style="text-align:left" class="row">
						<input class="easyui-combobox" name="SystemWmenuEditstoreMenu" id="SystemWmenuEditstoreMenu" data-options='  
								valueField: "id",
								textField: "name",
								data: <?php echo $pmenu?>,
								onSelect: function(record){
									
								},
								onLoadSuccess:function(){
									$("#SystemWmenuEditstoreMenu").combobox("select", "<?php echo $wmenu["mid"];?>");
								}'>  
					</td>
				</tr>
				<tr id="SystemWmenuEditstoreKeywordArea" style="display:none">
					<td style="text-align:right" class="row">接收的关键字：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuEditstoreKeyword" name="SystemWmenuEditstoreKeyword" value="<?php echo $wmenu["keyword"];?>">如果用户发送的不是关键字的是需要进行统一进行回复时，请不要填写关键字

					</td>
				</tr>
				<tr id="SystemWmenuEditstoreTextArea" style="display:none">
					<td style="text-align:right" class="row">文本消息内容：</td>
					<td style="text-align:left" class="row">
						<textarea cols="50" rows="10" id="SystemWmenuEditstoreText" name="SystemWmenuEditstoreText"><?php echo $wmenu['content']?></textarea>
					</td>
				</tr>
				<tbody id="SystemWmenuEditstoreNewsArea" style="display:none">
				<tr>
					<td style="text-align:right" class="row">图文消息标题：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuEditstoreTitle" name="SystemWmenuEditstoreTitle" value="<?php echo $wmenu['title']?>">
					</td>
				</tr>

				<tr>
					<td style="text-align:right" class="row">图文消息描述：</td>
					<td style="text-align:left" class="row">
						<textarea cols="50" rows="10" id="SystemWmenuEditstoreDiscription" name="SystemWmenuEditstoreDiscription"><?php echo $wmenu['description']?></textarea>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="row">图文消息图片：</td>
					<td style="text-align:left;" class="row">
						<div id="SystemWmenuEditstoreSimgShowArea">
							<img src="<?php echo $baseUrl.$wmenu['picUrl']?>" id="SystemWmenuEditstoreSimgShow" width="100px">
						</div>
						<div id="SystemWmenuEditstoreSimgBut" style="width:120px">
							<div id="SystemWmenuEditstoreSimgProcessing" style="display:none">
								<img id="SystemWmenuEditstoreSimgShow" src="<?php echo $baseUrl?>/images/system/processing.gif" style="width: 20px;">
							</div>
							<div id="SystemWmenuEditstoreSimgButText" style="padding:10px 0 10px 0;"><a href="javascript:void(0)" class="easyui-linkbutton" >点击上传图片</a></div>
						</div>
						<input type="hidden" value="<?php echo $wmenu['picUrl']?>" name="SystemWmenuEditstoreSimg" id="SystemWmenuEditstoreSimg">
					</td>
				</tr>
				

				<tr>
					<td style="text-align:right" class="row">图文消息链接：</td>
					<td style="text-align:left" class="row">
						<input type="text" id="SystemWmenuEditstoreUrl2" name="SystemWmenuEditstoreUrl2" value="<?php echo $wmenu['url']?>">
					</td>
				</tr>
				</tbody>
				<tr>
					<td colspan="2" style="text-align:center;width:200px" class="row">
						<input type="hidden" value="<?php echo $wmenu['id']?>" name="SystemWmenuEditstoreID" id="SystemWmenuEditstoreID">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="systemWmenuEditstore.submitForm()">提交</a>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
	var systemWmenuEditstore = {
		init:function(){
			$("#SystemWmenuEditstorePanel").panel({
											height: parseInt($('#tt .panel').css('height')),
											title: '编辑微信事件',  
										});
			systemWmenuEditstore.createUploader('SystemWmenuEditstoreSimg');
			
		},
		submitForm:function(){	
			var formdata = {
				mid : $("input[name='SystemWmenuEditstoreMenu']").val(),
				store : $("input[name='SystemWmenuEditstorestore']").val(),
				msgtype : $("input[name='SystemWmenuEditstoreMsgtype']").val(),
				content : $("#SystemWmenuEditstoreText").val(),
				title : $("#SystemWmenuEditstoreTitle").val(),
				description : $("#SystemWmenuEditstoreDiscription").val(),
				picUrl : $("#SystemWmenuEditstoreSimg").val(),
				url : $("#SystemWmenuEditstoreUrl2").val(),
				keyword : $("#SystemWmenuEditstoreKeyword").val(),
				id : $("#SystemWmenuEditstoreID").val()
			}

			if(!systemWmenuEditstore.alertInfoMsg(formdata.id,'请求数据非法'))return false;

			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+'/system/wmenu/storeupdate',
				data:formdata,
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$.messager.alert('系统消息',data.msg);
						$('#tt').tabs('close','编辑微信事件').tabs("select","微信事件列表");
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
	
	systemWmenuEditstore.init();
//-->
</script>