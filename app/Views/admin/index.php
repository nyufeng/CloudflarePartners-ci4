<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">总览</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   域名列表
					&nbsp;&nbsp;
					<button type="button" class="btn btn-success add-domain">新增域名</button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>域名</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
<?php foreach($hosted_zones as $k => $v): ?>
                                <tr data-domain="<?=$v?>">
                                    <td><?= $k?></td>
                                    <td><?= $v?></td>
                                    <td>
                                    <a href="/admin/home/edit/<?=$v?>"><button type="button" class="btn btn-info">编辑</button></a>
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
	$(".delete-domain").on("click", function(){
		let domain = $(this).parent().parent().data('domain');
		if(confirm("确认要删除 " + domain + "吗？")){
			let datas = new FormData();
			datas.append('domain', domain);
			let loadID = layer.load(1);
			$.ajax({
				type:"POST",
				url:"/api/domain/delete",
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

	$(".add-domain").on("click", function(){
		let domain = prompt('请输入域名');
		if(domain){
			let datas = new FormData();
			datas.append('domain', domain);
			let loadID = layer.load(1);
			$.ajax({
				type:"POST",
				url:"/api/domain/add",
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
