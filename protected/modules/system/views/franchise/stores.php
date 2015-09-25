<table id="systemFranchiStoresDatagrid" class="easyui-datagrid" title="图片列表"
		data-options="
			iconCls: 'icon-edit',
			singleSelect: true,
			toolbar: '#systemFranchiStoresDatagridTb',
			url: '<?php echo Yii::app()->request->baseUrl; ?>/system/franchise/storesList',
			//onClickRow: systemFranchiStoresOnClickRow,
			pagination: true,
			pageSize:50,
			autoRowHeight:true,
			rownumbers: true,
			animate: true,
			onLoadSuccess:function(){$('#systemFranchiStoresDatagrid').datagrid('resize',{height:parseInt($('#tt .panel').css('height'))});}
		">
	<thead>
		<tr>
			<th data-options="field:'id',width:70,
							formatter:function(value,row){
								return '<a href=\'javascript:void(0)\' class=\'easyui-linkbutton\' onclick=openTab(\'编辑图片\',\'/franchise/storesEdit?id='+row.id+'\')>编辑</a> | <a href=\'javascript:void(0)\' class=\'easyui-linkbutton\' onclick=systemFranchiStoresDelete('+row.id+')>删除</a>';
						}">操作</th>
			<th data-options='field:"name",width:100'>所属类别</th>
			<th data-options='field:"url",width:200,
							formatter:function(value,row){
								return "<img src=\""+BASEUSER+"/"+row.url+"\" height=\"100px\">";
							}
					'>图片</th>
		</tr>
	</thead>
</table>

<div id="systemFranchiStoresDatagridTb" style="height:auto">
		<div style="margin-bottom:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="openTab('添加图片','/franchise/storesAdd')">新增</a>
	</div>
	<div>		
		门店名称: 
		<input type="text" class="easyui-text" id="systemFranchiStoresNameForSearch" name="systemFranchiStoresNameForSearch">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="systemFranchiStoresSearch()">搜索</a>
	</div>
</div>

<script type="text/javascript">
	var systemFranchiStoresDelete = function (id){
		$.messager.confirm('系统消息', '确认删除该条信息吗？', function(r){
			if (r){
				$.ajax({
					type:"POST",
					global:false,
					url:BASEUSER+'/system/franchise/storesDelete',
					data:{"id":id},
					dataType:"JSON",
					success:function(data){					
						if(data.code==1){						
							$.messager.alert('系统消息',data.msg);
							$('#tt').tabs("select","图片列表");
							$('#systemFranchiStoresDatagrid').datagrid('reload');
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
	var systemFranchiStoresSearch = function(){
		$('#systemFranchiStoresDatagrid').datagrid('reload',{
			page: 1,
			rows: 50,
			search:$("#systemFranchiStoresNameForSearch").val()
		});
	}

</script>