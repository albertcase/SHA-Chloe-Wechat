<table id="systemFranchisestreetDatagrid" class="easyui-datagrid" title="门店区域管理"
		data-options="
			iconCls: 'icon-edit',
			singleSelect: true,
			toolbar: '#systemFranchisestreetDatagridTb',
			url: '<?php echo Yii::app()->request->baseUrl; ?>/system/franchise/storesList',
			onClickRow: systemFranchisestreetOnClickRow,
			pagination: true,
			pageSize:50,
			autoRowHeight:true,
			rownumbers: true,
			animate: true,
			onLoadSuccess:function(){$('#systemFranchisestreetDatagrid').datagrid('resize',{height:parseInt($('#tt .panel').css('height'))});}
		">
	<thead>
		<tr>
			<th data-options='field:"cid",width:100,
					formatter:function(value,row){
						return row.cid;
					},
					editor:{
						type:"combobox",
						options:{
							valueField:"id",
							textField:"cname",
							data:<?php echo $cityList;?>,
							required:true,
							onSelect: function(record){
								$("#systemFranchiseStreetAreaCombobox").combobox("reload",BASEUSER+"/system/franchise/arealistForStreet?cid="+record.id).combobox("setValue", ""); 
							}
						}
					}'>所属城市</th>
			<th data-options='field:"aid",width:100,
					formatter:function(value,row){
						return row.aid;
					},
					editor:{
						type:"combobox",
						options:{
							valueField:"id",
							textField:"aname",
							data:[{}],
							required:true,
							formatter: function(row){
								$(this).attr("id","systemFranchiseStreetAreaCombobox");
								var opts = $(this).combobox("options");
								return row[opts.textField];
							}
						}
					}'>所属区域</th>
			<th data-options="field:'name',width:100,editor:{type:'text',options:{required:true}}">街道名称</th>
			<th data-options="field:'uname',width:100">操作用户</th>
			<th data-options="field:'createtime',width:140">操作时间</th>
		</tr>
	</thead>
</table>

<div id="systemFranchisestreetDatagridTb" style="height:auto">
		<div style="margin-bottom:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="systemFranchisestreetAppend()">新增</a>		
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="systemFranchisestreetAccept()">保存</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="systemFranchisestreetReject()">取消</a>		
	</div>
	<div>		
		城市名称: 
		<input type="text" class="easyui-text" id="systemFranchisestreetNameForSearch" name="systemFranchisestreetNameForSearch">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="systemFranchisestreetSearch()">搜索</a>
	</div>
</div>

<script type="text/javascript">
	var systemFranchisestreetEditIndex = undefined;
	var systemFranchisestreetEndEditing = function (){
		if (systemFranchisestreetEditIndex == undefined){
			return true;
		}
		if ($('#systemFranchisestreetDatagrid').datagrid('validateRow', systemFranchisestreetEditIndex)){
						
			$('#systemFranchisestreetDatagrid').datagrid('endEdit', systemFranchisestreetEditIndex);

			var FranchisestreetInfo = [];
			FranchisestreetInfo.id = $('#systemFranchisestreetDatagrid').datagrid('getRows')[systemFranchisestreetEditIndex]['id'];
			FranchisestreetInfo.streetName = $('#systemFranchisestreetDatagrid').datagrid('getRows')[systemFranchisestreetEditIndex]['name'];
			FranchisestreetInfo.cid = $('#systemFranchisestreetDatagrid').datagrid('getRows')[systemFranchisestreetEditIndex]['cid'];
			FranchisestreetInfo.aid = $('#systemFranchisestreetDatagrid').datagrid('getRows')[systemFranchisestreetEditIndex]['aid'];
			
			
			systemFranchisestreetSave(FranchisestreetInfo,systemFranchisestreetEditIndex);
			systemFranchisestreetEditIndex = undefined;

			return true;
		} else {
			return false;
		}
	}
	var systemFranchisestreetOnClickRow = function (index,data){	
		if (systemFranchisestreetEditIndex != index){
			if (systemFranchisestreetEditIndex == undefined){
				$('#systemFranchisestreetDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemFranchisestreetEditIndex = index;
			} else {
				//$('#systemFranchisestreetDatagrid').datagrid('selectRow', systemFranchisestreetEditIndex);			
				$('#systemFranchisestreetDatagrid').datagrid('refreshRow', systemFranchisestreetEditIndex).datagrid('endEdit', systemFranchisestreetEditIndex);
				$('#systemFranchisestreetDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemFranchisestreetEditIndex = index;
			}
		}
	}
	var systemFranchisestreetAppend = function (){
		if (systemFranchisestreetEndEditing()){
			$('#systemFranchisestreetDatagrid').datagrid('appendRow',{});
			systemFranchisestreetEditIndex = $('#systemFranchisestreetDatagrid').datagrid('getRows').length-1;
			$('#systemFranchisestreetDatagrid').datagrid('selectRow', systemFranchisestreetEditIndex)
					.datagrid('beginEdit', systemFranchisestreetEditIndex);
		}
	}
	var systemFranchisestreetRemove = function (){
		if (systemFranchisestreetEditIndex == undefined){return}
		$('#systemFranchisestreetDatagrid').datagrid('cancelEdit', systemFranchisestreetEditIndex)
				.datagrid('deleteRow', systemFranchisestreetEditIndex);
		systemFranchisestreetEditIndex = undefined;
	}
	var systemFranchisestreetAccept = function (){
		systemFranchisestreetEndEditing();
	}
	var systemFranchisestreetReject = function(){
		$('#systemFranchisestreetDatagrid').datagrid('rejectChanges');
		systemFranchisestreetEditIndex = undefined;
	}
	var systemFranchisestreetGetChanges = function (){
		var rows = $('#systemFranchisestreetDatagrid').datagrid('getChanges','updated');
		alert(rows.length+' rows are changed!');
	}
	var systemFranchisestreetSave = function (FranchisestreetInfo,editIndex){
		if(FranchisestreetInfo.id){
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/streetupdate",
				data:{"name":FranchisestreetInfo.streetName,"id":FranchisestreetInfo.id,"cid":FranchisestreetInfo.cid,"aid":FranchisestreetInfo.aid},
				dataType:"JSON",
				success:function(data){
					if(data.code==1){
						$('#systemFranchisestreetDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}else{
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/streetadd",
				data:{"name":FranchisestreetInfo.streetName,"cid":FranchisestreetInfo.cid,"aid":FranchisestreetInfo.aid},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$('#systemFranchisestreetDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}
	}

	var systemFranchisestreetSearch = function (){
		$('#systemFranchisestreetDatagrid').datagrid('load',{
			department: $("#systemFranchisestreetDepartmentForSearch").combotree('getValue'),
			permissions: $("#systemFranchisestreetPermissionsForSearch").combobox('getValue'),
			FranchisestreetName:$("#systemFranchisestreetNameForSearch").val()
		});
	}

	$(document).ready(function(){
		
	});
</script>