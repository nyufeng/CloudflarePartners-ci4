
<!DOCTYPE html>
<html>
<head>
<title><?= $code ?> - <?= $title?></title>
<meta name="author" content="kookxiang" />
<meta name="copyright" content="KK's Laboratory" />
<meta name="Robots" content="NOINDEX, NOARCHIVE"/>
<meta name="ViewPort" content="initial-scale=1, minimum-scale=1, width=device-width"/>
<meta name="HandheldFriendly" content="true" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="renderer" content="webkit">
<style type="text/css">
html,body{width:100%;height:100%;cursor:default}
html,body,p,h2,div{margin:0;padding:0}
body{background:#2980B9;text-align:center;user-select:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none}
html{font:12px "Segoe UI","Microsoft YaHei",FreeSans,Arimo,"Droid Sans","Hiragino Sans GB","Hiragino Sans GB W3",Arial,sans-serif}
h2{margin-bottom:25px;font-size:30px;font-weight:300;color:#e05d6f}
p{line-height:1.5em;font-size:12px;color:#95a2a9;margin-bottom:5px}
.title{position:relative;top:75px;margin-bottom:.7em;line-height:30px;font-size:26px;font-weight:300;color:#fff;text-shadow:0 0 4px #666666}
.box{position:relative;top:80px;width:600px;max-width:85%;margin:0 auto;background:#fff;padding:15px;box-shadow:0 0 50px #2964B9}
.main{font-size:18px;color:#000;font-weight:500;line-height:1.7em;margin:0 0 10px}
.foot{position:relative;top:80px;margin:15px 15px 0;font-size:12px;color:#4eb0f8}
pre{background:#3498DB;color:#ffffff;padding:15px 20px;margin:25px -15px -15px;line-height:1.4em;font-size:14px;text-align:left;word-break:break-all;white-space:pre-wrap}
</style>
</head>
<body>
<p class="title">Server Error</p>
<div class="box">
<h2><b><?= $code ?></b> -  <?= $title ?></h2>
<p class="main"><?= $message ?></p>
<p><?= $message2 ?></p>
<pre><?= $message3 ?></pre>
</div>
<p class="foot">Hosted by <?=getenv('SITE_TITLE')?></p>
</body>
</html>
