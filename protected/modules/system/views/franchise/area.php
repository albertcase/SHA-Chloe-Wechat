<table id="systemFranchiseAreaDatagrid" class="easyui-datagrid" title="型号管理"
		data-options="
			iconCls: 'icon-edit',
			singleSelect: false,
			checkOnSelect:true,
			selectOnCheck: true,
			toolbar: '#systemFranchiseAreaDatagridTb',
			url: '<?php echo Yii::app()->request->baseUrl; ?>/system/franchise/arealist',
			onClickRow: systemFranchiseAreaOnClickRow,
			pagination: true,
			pageSize:50,
			autoRowHeight:true,
			rownumbers: true,
			animate: true,
			onLoadSuccess:function(){$('#systemFranchiseAreaDatagrid').datagrid('resize',{height:parseInt($('#tt .panel').css('height'))});}
		">
	<thead>
		<tr>
			<th data-options="field:'id',width:100,checkbox:true"></th>
			<th data-options='field:"cid",width:100,
					formatter:function(value,row){
						return row.cname;
					},
					editor:{
						type:"combobox",
						options:{
							valueField:"id",
							textField:"cname",
							data:<?php echo $cityList;?>,
							required:true
						}
					}'>所属种类</th>
			<th data-options="field:'name',width:100,editor:{type:'text',options:{required:true}}">型号名称</th>
			<th data-options='field:"repair",width:80,
					formatter:function(value,row){
						return row.repair;
					},
					editor:{
						type:"combobox",
						options:{
							valueField:"id",
							textField:"name",
							data:[{"id":"1","name":"一年"},{"id":"2","name":"二年"},{"id":"3","name":"三年"},{"id":"4","name":"四年"},{"id":"5","name":"五年"}],
							required:true
						}
					}'>保修年限</th>
			<th data-options="field:'bak',width:300,editor:{type:'text',options:{required:true}}">备注</th>
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
			<th data-options="field:'uname',width:100">操作用户</th>
			<th data-options="field:'createtime',width:140">操作时间</th>
		</tr>
	</thead>
</table>

<div id="systemFranchiseAreaDatagridTb" style="height:auto">
		<div style="margin-bottom:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="systemFranchiseAreaAppend()">新增</a>		
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="systemFranchiseAreaAccept()">保存</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="systemFranchiseAreaReject()">取消</a>	
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="allAreaStatusData()">批量隐藏</a>		
	</div>
</div>

<script type="text/javascript">
	var systemFranchiseAreaEditIndex = undefined;
	var allAreaStatusData = function() {  
        //返回选中多行  
        var selRow = $('#systemFranchiseAreaDatagrid').datagrid('getSelections')  
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
                    url: BASEUSER+"/system/franchise/areaStatus",  
                    data: {"ids":temID},  
                    success: function (result) {  
                        if (result.indexOf("t") <= 0) {  
                            $('#systemFranchiseAreaDatagrid').datagrid('clearSelections');  
                            $.messager.alert("提示", "批量隐藏成功！", "info");  
                            $('#systemFranchiseAreaDatagrid').datagrid('reload');  
                        } else {  
                            $.messager.alert("提示", "隐藏失败，请重新操作！", "info");  
                            return;  
                        }  
                    }  
                });  
            });  
  
        }  
    };  
	var systemFranchiseAreaEndEditing = function (){
		if (systemFranchiseAreaEditIndex == undefined){
			return true;
		}
		if ($('#systemFranchiseAreaDatagrid').datagrid('validateRow', systemFranchiseAreaEditIndex)){
						
			$('#systemFranchiseAreaDatagrid').datagrid('endEdit', systemFranchiseAreaEditIndex);

			var FranchiseAreaInfo = [];
			FranchiseAreaInfo.id = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['id'];
			FranchiseAreaInfo.areaName = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['name'];
			FranchiseAreaInfo.cid = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['cid'];
			FranchiseAreaInfo.status = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['status'];
			FranchiseAreaInfo.repair = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['repair'];
			FranchiseAreaInfo.bak = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['bak'];
			
			
			systemFranchiseAreaSave(FranchiseAreaInfo,systemFranchiseAreaEditIndex);
			systemFranchiseAreaEditIndex = undefined;

			return true;
		} else {
			return false;
		}
	}
	var systemFranchiseAreaEndEditing2 = function (){
		if (systemFranchiseAreaEditIndex == undefined){
			return true;
		}
		if ($('#systemFranchiseAreaDatagrid').datagrid('validateRow', systemFranchiseAreaEditIndex)){
						
			$('#systemFranchiseAreaDatagrid').datagrid('endEdit', systemFranchiseAreaEditIndex);

			var FranchiseAreaInfo = [];
			FranchiseAreaInfo.id = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['id'];
			FranchiseAreaInfo.areaName = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['name'];
			FranchiseAreaInfo.cid = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['cid'];
			FranchiseAreaInfo.status = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['status'];
			FranchiseAreaInfo.repair = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['repair'];
			FranchiseAreaInfo.bak = $('#systemFranchiseAreaDatagrid').datagrid('getRows')[systemFranchiseAreaEditIndex]['bak'];
			
			systemFranchiseAreaSave2(FranchiseAreaInfo,systemFranchiseAreaEditIndex);
			systemFranchiseAreaEditIndex = undefined;

			return true;
		} else {
			return false;
		}
	}
	var systemFranchiseAreaOnClickRow = function (index,data){	
		if (systemFranchiseAreaEditIndex != index){
			if (systemFranchiseAreaEditIndex == undefined){
				$('#systemFranchiseAreaDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemFranchiseAreaEditIndex = index;
			} else {
				systemFranchiseAreaEndEditing2()
				//$('#systemFranchiseAreaDatagrid').datagrid('selectRow', systemFranchiseAreaEditIndex);			
				$('#systemFranchiseAreaDatagrid').datagrid('refreshRow', systemFranchiseAreaEditIndex).datagrid('endEdit', systemFranchiseAreaEditIndex);
				$('#systemFranchiseAreaDatagrid').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
				
				systemFranchiseAreaEditIndex = index;
			}
		}
	}
	var systemFranchiseAreaAppend = function (){
		if (systemFranchiseAreaEndEditing()){
			$('#systemFranchiseAreaDatagrid').datagrid('appendRow',{});
			systemFranchiseAreaEditIndex = $('#systemFranchiseAreaDatagrid').datagrid('getRows').length-1;
			$('#systemFranchiseAreaDatagrid').datagrid('selectRow', systemFranchiseAreaEditIndex)
					.datagrid('beginEdit', systemFranchiseAreaEditIndex);
		}
	}
	var systemFranchiseAreaRemove = function (){
		if (systemFranchiseAreaEditIndex == undefined){return}
		$('#systemFranchiseAreaDatagrid').datagrid('cancelEdit', systemFranchiseAreaEditIndex)
				.datagrid('deleteRow', systemFranchiseAreaEditIndex);
		systemFranchiseAreaEditIndex = undefined;
	}
	var systemFranchiseAreaAccept = function (){
		systemFranchiseAreaEndEditing();
	}
	var systemFranchiseAreaReject = function(){
		$('#systemFranchiseAreaDatagrid').datagrid('rejectChanges');
		systemFranchiseAreaEditIndex = undefined;
	}
	var systemFranchiseAreaGetChanges = function (){
		var rows = $('#systemFranchiseAreaDatagrid').datagrid('getChanges','updated');
		alert(rows.length+' rows are changed!');
	}
	var systemFranchiseAreaSave = function (FranchiseAreaInfo,editIndex){
		if(FranchiseAreaInfo.id){
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/areaupdate",
				data:{"status":FranchiseAreaInfo.status,"name":FranchiseAreaInfo.areaName,"id":FranchiseAreaInfo.id,"cid":FranchiseAreaInfo.cid,"repair":FranchiseAreaInfo.repair,"bak":FranchiseAreaInfo.bak},
				dataType:"JSON",
				success:function(data){
					if(data.code==1){
						$('#systemFranchiseAreaDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}else{
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/areaadd",
				data:{"status":FranchiseAreaInfo.status,"name":FranchiseAreaInfo.areaName,"cid":FranchiseAreaInfo.cid,"repair":FranchiseAreaInfo.repair,"bak":FranchiseAreaInfo.bak},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						$('#systemFranchiseAreaDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}
	}
	var systemFranchiseAreaSave2 = function (FranchiseAreaInfo,editIndex){
		if(FranchiseAreaInfo.id){
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/areaupdate",
				data:{"status":FranchiseAreaInfo.status,"name":FranchiseAreaInfo.areaName,"id":FranchiseAreaInfo.id,"cid":FranchiseAreaInfo.cid,"repair":FranchiseAreaInfo.repair,"bak":FranchiseAreaInfo.bak},
				dataType:"JSON",
				success:function(data){
					if(data.code==1){
						//$('#systemFranchiseAreaDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						//$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}else{
			$.ajax({
				type:"POST",
				global:false,
				url:BASEUSER+"/system/franchise/areaadd",
				data:{"status":FranchiseAreaInfo.status,"name":FranchiseAreaInfo.areaName,"cid":FranchiseAreaInfo.cid,"repair":FranchiseAreaInfo.repair,"bak":FranchiseAreaInfo.bak},
				dataType:"JSON",
				success:function(data){					
					if(data.code==1){						
						//$('#systemFranchiseAreaDatagrid').datagrid('acceptChanges').datagrid('reload',{});
					}else{
						//$.messager.alert('系统消息',data.msg,'error');
					}
				}
			});
		}
	}

	var systemFranchiseAreaSearch = function (){
		$('#systemFranchiseAreaDatagrid').datagrid('load',{
			department: $("#systemFranchiseAreaDepartmentForSearch").combotree('getValue'),
			permissions: $("#systemFranchiseAreaPermissionsForSearch").combobox('getValue'),
			FranchiseAreaName:$("#systemFranchiseAreaNameForSearch").val()
		});
	}

	$(document).ready(function(){
		//$('#systemFranchiseAreaDepartmentForSearch').combotree('setValue', '1');
	});
</script>