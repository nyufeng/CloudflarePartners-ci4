<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?=$response['zone_name']?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    域名记录
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-success add-sub-domain">新增记录</button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>子域名</th>
                                    <th>CNAME</th>
                                    <th>CDN</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="add-sub-domain" class="hidden">
                                    <td>
										<div class="form-group input-group">
											<input type="text" id="addSubDomain" class="form-control" placeholder="eg. example"><span class="input-group-addon">.<?=$response['zone_name']?></span>
										</div>

									</td>
                                    <td><input type="text" id="addCname" class="form-control" placeholder="eg. example"></td>
                                    <td></td>
                                    <td>
										<button type="button" class="btn btn-success confirm-sub-domain">保存</button>
										<button type="button" class="btn btn-danger cancel-sub-domain">取消</button>
									</td>
                                </tr>
<?php foreach($response['hosted_cnames'] as $k => $v): ?>
                                <tr data-subdomain="<?=$k?>">
                                    <td><?= $k?></td>
                                    <td><?= $v?></td>
                                    <td><?= $response['forward_tos'][$k]?></td>
                                    <td>
                                    <button type="button" class="btn btn-info edit-domain">编辑</button>
                                    <button type="button" class="btn btn-danger delete-domain">删除</button>
                                    </td>
                                </tr>
<?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->    
</div>
<script>
$(function(){
    $(".add-sub-domain").on('click',function(){
        $("#add-sub-domain").removeClass("hidden");
    });

    $(".cancel-sub-domain").on("click", function(){
		$("#add-sub-domain").addClass("hidden");
	});

    $(".confirm-sub-domain").on("click", function(){
    	let subDomain = $("#addSubDomain").val();
    	let cname = $("#addCname").val();
    	if(subDomain == ''){
			layer.msg("请输入正确的子域名");
    		return false;
		}
    	if(cname == ''){
			layer.msg("请输入CNAME");
    		return false;
		}
		let datas = new FormData();
		datas.append('sub', subDomain);
		datas.append('cname', cname);
		datas.append('domain', '<?=$response['zone_name']?>');
		let loadID = layer.load(1);
		$.ajax({
			type:"POST",
			url:"/api/Subdomain/add",
			processData:false,
			contentType:false,
			data:datas,
			dataType:"json",
			success:function(data){
				layer.close(loadID);
				if(data.result = 'success'){
					window.location.reload();
				}
			},
			error:function(data){
				layer.close(loadID);
				layer.msg(data.responseJSON.messages.error);
			}
		});
	});

    $(".delete-domain").on("click", function(){
		let subDomain = $(this).parent().parent().data('subdomain');
		if(confirm("确认要删除 " + subDomain + "吗？")){
			let datas = new FormData();
			datas.append('sub', subDomain);
			datas.append('domain', '<?=$response['zone_name']?>');
			let loadID = layer.load(1);
			$.ajax({
				type:"POST",
				url:"/api/Subdomain/delete",
				processData:false,
				contentType:false,
				data:datas,
				dataType:"json",
				success:function(data){
					layer.close(loadID);
					if(data.result = 'success'){
						window.location.reload();
					}
				},
				error:function(data){
					layer.close(loadID);
					layer.msg(data.responseJSON.messages.error);
				}
			});
		}
	});

    $(".edit-domain").on("click", function(){
		let subDomain = $(this).parent().parent().data('subdomain');
		let cname = prompt('请输入 ' + subDomain + ' 的新 CNAME');
		if(cname){
			let datas = new FormData();
			datas.append('sub', subDomain);
			datas.append('cname', cname);
			datas.append('domain', '<?=$response['zone_name']?>');
			let loadID = layer.load(1);
			$.ajax({
				type:"POST",
				url:"/api/Subdomain/edit",
				processData:false,
				contentType:false,
				data:datas,
				dataType:"json",
				success:function(data){
					layer.close(loadID);
					if(data.result = 'success'){
						window.location.reload();
					}
				},
				error:function(data){
					layer.close(loadID);
					alert(data.responseJSON.messages.error);
				}
			});
		}
	})
});
</script>