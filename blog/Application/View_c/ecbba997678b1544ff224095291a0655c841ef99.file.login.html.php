<?php /* Smarty version Smarty-3.1-DEV, created on 2017-06-14 18:21:24
         compiled from "D:\wamp\test1\yu\blog\Application\View\Admin\Login\login.html" */ ?>
<?php /*%%SmartyHeaderCode:1644759415bf0c42a17-71573050%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecbba997678b1544ff224095291a0655c841ef99' => 
    array (
      0 => 'D:\\wamp\\test1\\yu\\blog\\Application\\View\\Admin\\Login\\login.html',
      1 => 1497457082,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1644759415bf0c42a17-71573050',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_59415bf12602d2_85164944',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59415bf12602d2_85164944')) {function content_59415bf12602d2_85164944($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="public/admin/css/ch-ui.admin.css">
	<link rel="stylesheet" href="public/admin/font/css/font-awesome.min.css">
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			<form action="index.php?p=admin&c=login&a=dologin" method="post">
				<ul>
					<li>
					<input type="text" name="username" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="index.php?p=admin&c=login&a=captcha&v=" onclick="this.src += Math.random();"style="cursor:pointer; " alt="">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="index.php?p=admin&c=register&a=register" >用户注册</a></p>
			<p>
				&copy; 2016 Powered by itcast<br />
				<a href="http://www.itcast.cn/" target="_blank">PHP高级开发攻城狮</a>
			</p>
		</div>
	</div>
</body>
</html><?php }} ?>
