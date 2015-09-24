<table id="systemServiceDatagrid" class="easyui-datagrid" title="门店服务"
		data-options="
			iconCls: 'icon-edit',
			singleSelect: true,
			toolbar: '#systemServiceDatagridTb',
			url: '<?php echo Yii::app()->request->baseUrl; ?>/system/franchise/servicelist',
			onClickRow: systemServiceOnClickRow,
			pagination: true,
			pageSize:50,
			autoRowHeight:true,
			rownumbers: true,
			animate: true,
			onLoadSuccess:function(){$('#systemServiceDatagrid').datagrid('resize',{height:parseInt($('#tt .panel').css('height'))});}
		">
	<thead>
		<tr>
			<th data-options="field:'id',width:70,
							formatter:function(value,row){
								return '<a href=\'javascript:void(0)\' class=\'easyui-linkbutton\' onclick=openTab(\'编辑门店服务\',\'/franchise/ServiceEdit?id='+row.id+'\')>编辑</a> | <a href=\'javascript:void(0)\' class=\'easyui-linkbutton\' onclick=systemServiceDelete('+row.id+')>删除</a>';
			}">操作</th>
			<th data-options='field:"name",width:100'>名称</th>	
			<th data-options='field:"img",width:200,
							formatter:function(value,row){
								return "<img src=\""+BASEUSER+"/"+row.img+"\" height=\"57px\">";
							}
					'>图片</th>
			<th data-options='field:"num",width:100'>排序</th>	
			
		</tr>
	</thead>
</table>

<div id="systemServiceDatagridTb" style="height:auto">
	<div style="margin-bottom:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="openTab('添加门店服务','/franchise/ServiceAdd')">新增</a>
	</div>
</div>

<script type="text/javascript">
	var systemServiceDelete = function (id){
			$.messager.confirm('系统消息', '确认删除该条信息吗？', function(r){
				if (r){
					$.ajax({
						type:"POST",
						global:false,
						url:BASEUSER+'/system/franchise/DeleteService',
						data:{"id":id},
						dataType:"JSON",
						success:function(data){					
							if(data.code==1){						
								$.messager.alert('系统消息',data.msg);
								$('#systemServiceDatagrid').datagrid('reload');
							}else{
								$.messager.alert('系统消息',data.msg,'error');
							}
						}
					});
				}else{
					return false;
				}
			});
			
		}
	var systemServiceEditIndex = undefined;
	var systemServiceEndEditing = function (){
		if (systemServiceEditIndex == undefined){
			return true;
		}
		if ($('#systemServiceDatagrid').datagrid('validateRow', systemServiceEditIndex)){
						
			$('#systemServiceDatagrid').datagrid('endEdit', systemServiceEditIndex);

			var BrandInfo = [];
			BrandInfo.id = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['id'];
			BrandInfo.name = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['name'];
			BrandInfo.t1 = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['t1'];
			BrandInfo.t2 = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['t2'];
			BrandInfo.t3 = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['t3'];
			BrandInfo.cid = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['cid'];
			BrandInfo.aid = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['aid'];
			BrandInfo.edate = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['edate'];
			BrandInfo.schooling = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['schooling'];
			BrandInfo.duty = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['duty'];
			BrandInfo.qualifications = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['qualifications'];
			BrandInfo.status = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['status'];
			
			systemServiceSave(BrandInfo,systemServiceEditIndex);
			systemServiceEditIndex = undefined;

			return true;
		} else {
			return false;
		}
	}
	var systemServiceOnClickRow = function (index,data){	
		if (systemServiceEditIndex != index){
			if (systemServiceEditIndex == undefined){
				$('#systemServiceDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemServiceEditIndex = index;
			} else {				
				$('#systemServiceDatagrid').datagrid('refreshRow', systemServiceEditIndex).datagrid('endEdit', systemServiceEditIndex);
				$('#systemServiceDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemServiceEditIndex = index;
			}
			var cid = $('#systemServiceDatagrid').datagrid('getRows')[systemServiceEditIndex]['cid'];
			$("#systemServiceAreaCombobox").combobox("reload",BASEUSER+"/system/franchise/arealistForStreet?cid="+cid);
		}
	}
	var systemServiceAppend = function (){
		if (systemServiceEndEditing()){
			$('#systemServiceDatagrid').datagrid('appendRow',{status:'显示'});
			
			systemServiceEditIndex = $('#systemServiceDatagrid').datagrid('getRows').length-1;
			$('#systemServiceDatagrid').datagrid('selectRow', systemServiceEditIndex)
					.datagrid('beginEdit', systemServiceEditIndex);
		}
	}
	var systemServiceRemove = function (){
		if (systemServiceEditIndex == undefined){return}
		$('#systemServiceDatagrid').datagrid('cancelEdit', systemServiceEditIndex)
				.datagrid('deleteRow', systemServiceEditIndex);
		systemServiceEditIndex = undefined;
	}
	var systemServiceAccept = function (){
		systemServiceEndEditing();
	}
	var systemServiceReject = function(){
		$('#systemServiceDatagrid').datagrid('rejectChanges');
		systemServiceEditIndex = undefined;
	}
	var systemServiceGetChanges = function (){
		var rows = $('#systemServiceDatagrid').datagrid('getChanges','updated');
		alert(rows.length+' rows are changed!');
	}
	var systemServiceSave = function (BrandInfo,editIndex){
		if(BrandInfo.id){
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/recruitment/positionupdate",
				data:{"name":BrandInfo.name,"t1":BrandInfo.t1,"t2":BrandInfo.t2,"t3":BrandInfo.t3,"id":BrandInfo.id,"cid":BrandInfo.cid,"aid":BrandInfo.aid,"edate":BrandInfo.edate,"schooling":BrandInfo.schooling,"duty":BrandInfo.duty,"qualifications":BrandInfo.qualifications,"status":BrandInfo.status},
				dataType:"JSON",
				success:function(data){
					if(data.code==1){
						$('#systemServiceDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
						$('#systemServiceDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}
				}
			});
		}else{
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/recruitment/positionadd",
				data:{"name":BrandInfo.name,"t1":BrandInfo.t1,"t2":BrandInfo.t2,"t3":BrandInfo.t3,"cid":BrandInfo.cid,"aid":BrandInfo.aid,"edate":BrandInfo.edate,"schooling":BrandInfo.schooling,"duty":BrandInfo.duty,"qualifications":BrandInfo.qualifications,"status":BrandInfo.status},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$('#systemServiceDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
						$('#systemServiceDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}
				}
			});
		}
	}

	var systemServiceSearch = function (){
		$('#systemServiceDatagrid').datagrid('load',{
			department: $("#systemServiceDepartmentForSearch").combotree('getValue'),
			permissions: $("#systemServicePermissionsForSearch").combobox('getValue'),
			BrandName:$("#systemServiceNameForSearch").val()
		});
	}

	$(document).ready(function(){
		
	});
</script>