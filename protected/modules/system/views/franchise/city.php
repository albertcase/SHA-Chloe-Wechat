<table id="systemFranchiseCityDatagrid" class="easyui-datagrid" title="种类管理"
		data-options="
			iconCls: 'icon-edit',
			singleSelect: false,
			checkOnSelect:true,
			selectOnCheck: true,
			toolbar: '#systemFranchiseCityDatagridTb',
			url: '<?php echo Yii::app()->request->baseUrl; ?>/system/franchise/citylist',
			onClickRow: systemFranchiseCityOnClickRow,
			pagination: true,
			pageSize:50,
			autoRowHeight:true,
			rownumbers: true,
			animate: true,
			onLoadSuccess:function(){$('#systemFranchiseCityDatagrid').datagrid('resize',{height:parseInt($('#tt .panel').css('height'))});}
		">
	<thead>
		<tr>
			<th data-options="field:'id',width:100,checkbox:true"></th>
			<th data-options="field:'name',width:100,editor:{type:'text',options:{required:true}}">种类名称</th>
			<th data-options='field:"status",width:80,
					formatter:function(value,row){
						if(row.status==1)
							return "显示"
						else
							return "隐藏"
					},
					editor:{
						type:"combobox",
						options:{
							valueField:"id",
							textField:"name",
							data:[{"id":"0","name":"隐藏"},{"id":"1","name":"显示"}],
							required:true
						}
					}'>状态</th>	
		</tr>
	</thead>
</table>

<div id="systemFranchiseCityDatagridTb" style="height:auto">
		<div style="margin-bottom:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="systemFranchiseCityAppend()">新增</a>		
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="systemFranchiseCityAccept()">保存</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="systemFranchiseCityReject()">取消</a>	
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="allCityStatusData()">批量隐藏</a>		
	</div>
</div>

<script type="text/javascript">
	var systemFranchiseCityEditIndex = undefined;
	var allCityStatusData = function() {  
        //返回选中多行  
        var selRow = $('#systemFranchiseCityDatagrid').datagrid('getSelections')  
        //判断是否选中行  
        if (selRow.length==0) {  
            $.messager.alert("提示", "请选择要隐藏的行！", "info");  
            return;  
        }else{      
            var temID="";  
            //批量获取选中行的评估模板ID  
            for (i = 0; i < selRow.length;i++) {  
                if (temID =="") {  
                    temID = selRow[i].id;  
                } else {  
                    temID = selRow[i].id + "," + temID;  
                }                 
            }  
                        
            $.messager.confirm('提示', '是否隐藏选中数据?', function (r) {  
  
                if (!r) {  
                    return;  
                }  
                //提交  
                $.ajax({  
                    type: "POST",  
                    async: false,  
                    url: BASEUSER+"/system/franchise/cityStatus",  
                    data: {"ids":temID},  
                    success: function (result) {  
                        if (result.indexOf("t") <= 0) {  
                            $('#systemFranchiseCityDatagrid').datagrid('clearSelections');  
                            $.messager.alert("提示", "批量隐藏成功！", "info");  
                            $('#systemFranchiseCityDatagrid').datagrid('reload');  
                        } else {  
                            $.messager.alert("提示", "隐藏失败，请重新操作！", "info");  
                            return;  
                        }  
                    }  
                });  
            });  
  
        }  
    };  
	var systemFranchiseCityEndEditing = function (){
		if (systemFranchiseCityEditIndex == undefined){
			return true;
		}
		if ($('#systemFranchiseCityDatagrid').datagrid('validateRow', systemFranchiseCityEditIndex)){
						
			$('#systemFranchiseCityDatagrid').datagrid('endEdit', systemFranchiseCityEditIndex);

			var FranchiseCityInfo = [];
			FranchiseCityInfo.id = $('#systemFranchiseCityDatagrid').datagrid('getRows')[systemFranchiseCityEditIndex]['id'];
			FranchiseCityInfo.cityName = $('#systemFranchiseCityDatagrid').datagrid('getRows')[systemFranchiseCityEditIndex]['name'];
			FranchiseCityInfo.status = $('#systemFranchiseCityDatagrid').datagrid('getRows')[systemFranchiseCityEditIndex]['status'];
			
			systemFranchiseCitySave(FranchiseCityInfo,systemFranchiseCityEditIndex);
			systemFranchiseCityEditIndex = undefined;

			return true;
		} else {
			return false;
		}
	}
	var systemFranchiseCityEndEditing2 = function (){
		if (systemFranchiseCityEditIndex == undefined){
			return true;
		}
		if ($('#systemFranchiseCityDatagrid').datagrid('validateRow', systemFranchiseCityEditIndex)){
						
			$('#systemFranchiseCityDatagrid').datagrid('endEdit', systemFranchiseCityEditIndex);

			var FranchiseCityInfo = [];
			FranchiseCityInfo.id = $('#systemFranchiseCityDatagrid').datagrid('getRows')[systemFranchiseCityEditIndex]['id'];
			FranchiseCityInfo.cityName = $('#systemFranchiseCityDatagrid').datagrid('getRows')[systemFranchiseCityEditIndex]['name'];
			FranchiseCityInfo.status = $('#systemFranchiseCityDatagrid').datagrid('getRows')[systemFranchiseCityEditIndex]['status'];
			
			systemFranchiseCitySave2(FranchiseCityInfo,systemFranchiseCityEditIndex);
			systemFranchiseCityEditIndex = undefined;

			return true;
		} else {
			return false;
		}
	}
	var systemFranchiseCityOnClickRow = function (index,data){	
		if (systemFranchiseCityEditIndex != index){
			if (systemFranchiseCityEditIndex == undefined){
				$('#systemFranchiseCityDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemFranchiseCityEditIndex = index;
			} else {
				systemFranchiseCityEndEditing2()
				//$('#systemFranchiseCityDatagrid').datagrid('selectRow', systemFranchiseCityEditIndex);			
				$('#systemFranchiseCityDatagrid').datagrid('refreshRow', systemFranchiseCityEditIndex).datagrid('endEdit', systemFranchiseCityEditIndex);
				$('#systemFranchiseCityDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemFranchiseCityEditIndex = index;
			}
		}
	}
	var systemFranchiseCityAppend = function (){
		if (systemFranchiseCityEndEditing()){
			$('#systemFranchiseCityDatagrid').datagrid('appendRow',{});
			systemFranchiseCityEditIndex = $('#systemFranchiseCityDatagrid').datagrid('getRows').length-1;
			$('#systemFranchiseCityDatagrid').datagrid('selectRow', systemFranchiseCityEditIndex)
					.datagrid('beginEdit', systemFranchiseCityEditIndex);
		}
	}
	var systemFranchiseCityRemove = function (){
		if (systemFranchiseCityEditIndex == undefined){return}
		$('#systemFranchiseCityDatagrid').datagrid('cancelEdit', systemFranchiseCityEditIndex)
				.datagrid('deleteRow', systemFranchiseCityEditIndex);
		systemFranchiseCityEditIndex = undefined;
	}
	var systemFranchiseCityAccept = function (){
		systemFranchiseCityEndEditing();
	}
	var systemFranchiseCityReject = function(){
		$('#systemFranchiseCityDatagrid').datagrid('rejectChanges');
		systemFranchiseCityEditIndex = undefined;
	}
	var systemFranchiseCityGetChanges = function (){
		var rows = $('#systemFranchiseCityDatagrid').datagrid('getChanges','updated');
		alert(rows.length+' rows are changed!');
	}
	var systemFranchiseCitySave = function (FranchiseCityInfo,editIndex){
		if(FranchiseCityInfo.id){
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/cityupdate",
				data:{"name":FranchiseCityInfo.cityName,"id":FranchiseCityInfo.id,"status":FranchiseCityInfo.status},
				dataType:"JSON",
				success:function(data){
					if(data.code==1){
						$('#systemFranchiseCityDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}else{
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/cityadd",
				data:{"name":FranchiseCityInfo.cityName,"status":FranchiseCityInfo.status},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$('#systemFranchiseCityDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}
	}
	var systemFranchiseCitySave2 = function (FranchiseCityInfo,editIndex){
		if(FranchiseCityInfo.id){
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/cityupdate",
				data:{"name":FranchiseCityInfo.cityName,"id":FranchiseCityInfo.id,"status":FranchiseCityInfo.status},
				dataType:"JSON",
				success:function(data){
					if(data.code==1){
						$('#systemFranchiseCityDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}else{
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/cityadd",
				data:{"name":FranchiseCityInfo.cityName,"status":FranchiseCityInfo.status},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$('#systemFranchiseCityDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}
	}

	var systemFranchiseCitySearch = function (){
		$('#systemFranchiseCityDatagrid').datagrid('load',{
			department: $("#systemFranchiseCityDepartmentForSearch").combotree('getValue'),
			permissions: $("#systemFranchiseCityPermissionsForSearch").combobox('getValue'),
			FranchiseCityName:$("#systemFranchiseCityNameForSearch").val()
		});
	}

	$(document).ready(function(){
		//$('#systemFranchiseCityDepartmentForSearch').combotree('setValue', '1');
	});
</script>