<table id="systemFranchiPreferentialDatagrid" class="easyui-datagrid" title="门店优惠信息管理"
		data-options="
			iconCls: 'icon-edit',
			singleSelect: true,
			toolbar: '#systemFranchiPreferentialDatagridTb',
			url: '<?php echo Yii::app()->request->baseUrl; ?>/system/franchise/preferentialList',
			//onClickRow: systemFranchiPreferentialOnClickRow,
			pagination: true,
			pageSize:50,
			autoRowHeight:true,
			rownumbers: true,
			animate: true,
			onLoadSuccess:function(){$('#systemFranchiPreferentialDatagrid').datagrid('resize',{height:parseInt($('#tt .panel').css('height'))});}
		">
	<thead>
		<tr>
			<th data-options="field:'id',width:70,
							formatter:function(value,row){
								return '<a href=\'javascript:void(0)\' class=\'easyui-linkbutton\' onclick=openTab(\'编辑门店优惠信息\',\'/franchise/preferentialEdit?id='+row.id+'\')>编辑</a> | <a href=\'javascript:void(0)\' class=\'easyui-linkbutton\' onclick=systemFranchiPreferentialDelete('+row.id+')>删除</a>';
						}">操作</th>
			<th data-options='field:"cid",width:100'>所属城市</th>
			<th data-options="field:'name',width:100">优惠名称</th>
			<th data-options="field:'f_title',width:100">副标题</th>
			<th data-options='field:"img",width:200,
							formatter:function(value,row){
								if(value)
									return "<img src=\""+BASEUSER+"/"+value+"\" width=\"200px\">";
								else
									return "无门店图片";
							}
					'>图片</th>
			<th data-options="field:'uname',width:100">操作用户</th>
			<th data-options="field:'createtime',width:140">操作时间</th>
			
		</tr>
	</thead>
</table>

<div id="systemFranchiPreferentialDatagridTb" style="height:auto">
		<div style="margin-bottom:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="openTab('添加门店优惠信息','/franchise/preferentialAdd')">新增</a>
	</div>
	<div>		
		优惠名称: 
		<input type="text" class="easyui-text" id="systemFranchiPreferentialNameForSearch" name="systemFranchiPreferentialNameForSearch">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="systemFranchiPreferentialSearch()">搜索</a>
	</div>
</div>

<script type="text/javascript">
	var systemFranchiPreferentialDelete = function (id){
		$.messager.confirm('系统消息', '确认删除该条信息吗？', function(r){
			if (r){
				$.ajax({
					type:"POST",
					global:false,
					url:BASEUSER+'/system/franchise/preferentialDelete',
					data:{"id":id},
					dataType:"JSON",
					success:function(data){					
						if(data.code==1){						
							$.messager.alert('系统消息',data.msg);
							$('#tt').tabs("select","门店优惠信息管理").tabs("select","门店优惠信息管理");
							$('#systemFranchiPreferentialDatagrid').datagrid('reload');
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
	var systemFranchiPreferentialSearch = function(){
		$('#systemFranchiPreferentialDatagrid').datagrid('reload',{
			page: 1,
			rows: 50,
			search:$("#systemFranchiPreferentialNameForSearch").val()
		});
	}

</script>