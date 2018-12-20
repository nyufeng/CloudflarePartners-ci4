
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>登陆注册 | <?= getenv('SITE_TITLE')?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" id="email" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="pass" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="button" class="btn btn-lg btn-success btn-block login">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                
                    
                <div class="alert alert-danger hidden" id="error-msg"></div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/dist/js/sb-admin-2.js"></script>
<script>
$(".login").on('click',function(){
    $("#error-msg").addClass('hidden');
    $("#error-msg").html('');
    let email = $("#email").val();
    if(email == ''){
        alert("邮箱不能为空")
        return false;
    }
    let pass = $("#pass").val();
    if(pass == ''){
        alert("密码不能为空")
        return false;
    }
    let datas = new FormData();
    datas.append('email', email);
    datas.append('pass', pass);
    $.ajax({
        type:"POST",
        url:"/api/login",
        processData:false,
        contentType:false, 
        data:datas,
        dataType:"json",
        success:function(data){
            if(data.result = 'success'){
                window.location.href=data.redirect;
            }
        },
        error:function(data){
            $("#error-msg").removeClass('hidden');
            $("#error-msg").html(data.responseJSON.messages.error);
        }
    });
});
</script>
</body>

</html>
