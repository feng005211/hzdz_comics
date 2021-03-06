<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no, email=no">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="HandheldFriendly" content="true">
<meta name="MobileOptimized" content="640">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="browsermode" content="application">
<meta name="x5-page-mode" content="app">
<meta name="msapplication-tap-highlight" content="no">
<meta name="viewport" content="width=640,target-densitydpi=device-dpi,maximum-scale=1.0, user-scalable=no ">
<meta name="keywords" content="<?php echo ($_site['name']); ?>">
<meta name="description" content="<?php echo ($_site['name']); ?>">
<title>代理注册</title>
<link rel="stylesheet" href="/Public/css/common.css" type="text/css">
<link rel="stylesheet" href="/Public/font-awesome/css/font-awesome.min.css">
<script src="/Public/js/jquery.min.js" type="text/javascript"></script>
<style>
body{background:url(./Public/images/login-bg.jpg) no-repeat;background-size:100%;}
</style>
<div class="rmain">
	<div class="rtxt">
		<ul>
			<li>
				<span><i></i>站点名称<b></b></span>
				<span><input id="username" type="text" placeholder="设置小说漫画系统名称" errmsg="设置小说漫画系统名称！" /></span>
			</li>
			<li>
				<span><i></i>姓名<b></b></span>
				<span><input id="name" type="text" placeholder="请输入姓名" errmsg="请输入名姓名！" /></span>
			</li>
			<li>
				<span><i></i>支付宝<b></b></span>
				<span><input id="zfb" type="text" placeholder="输入支付宝账号，用于提现" errmsg="输入支付宝账号，用于提现！" /></span>
			</li>
			<li>
				<span><i></i>手机号<b></b></span>
				<span><input id="mobile" type="tel" placeholder="请输入11位手机号" errmsg="请输入11位手机号！" /></span>
				<button onclick="sendSms(this);">发送验证码</button>
			</li>
			<li>
				<span><i></i>验证码<b></b></span>
				<span><input id="code" type="tel" placeholder="请输入验证码" errmsg="请输入验证码！" /></span>
			</li>
			<li>
				<span><i></i>密码<b></b></span>
				<span><input id="password" type="password" placeholder="请输入密码" errmsg="请输入密码！" /></span>
			</li>
			<li>
				<span><i></i>确定密码<b></b></span>
				<span><input id="tpassword" type="password" placeholder="请再次输入密码" errmsg="请再次输入密码！" /></span>
			</li>
		</ul>	
		<div class="btn">
			<a href="javascript:;">立即注册</a>
		</div>
	</div>
</div>
<script>
	$('.btn a').click(function(){
		var data = {};
			msg = "";
		$('input').each(function(){
			if($(this).val() == ""){
				msg = $(this).attr("errmsg");
				return false;
			}else{
				data[$(this).attr("id")] = $(this).val();
			}
		});
		if(msg !=""){
			alert(msg);
			return false;
		}
		if(data.password!=data.tpassword){
			alert("两次密码不一致！");
			return false;
		}
		$.post("<?php echo U('regist');?>",data,function(d){
			if(d){
				alert(d.info);
			}else{
				alert('请求失败');
			}
		});
	});
	
	/*
	*注册发送验证码
	*ob:发送按钮元素
	*/
	var flag = true;
	function sendSms(ob){
		if(flag){
			var mobile = $('#mobile').val();
			if(checkMobile(mobile)){
				$.post("./index.php?m=&c=Public&a=SendSms",{mobile:mobile},function(d){
					if(d){
						if(d.status){
							alert(d.info);
							Settime(ob);
						}else{
							alert(d.info);
						}
					}else{
						alert('请求失败！');
					}
				});
			}
		}
	}

	
	
	//校验手机号
	function checkMobile(mobile){
		var msg='';
		var myreg = /^1[34578]\d{9}$/;             
		if(mobile == ''){
			msg = '请输入您的手机号！';
		}else if(mobile.length !=11){
			msg = '您的手机号输入有误！';
		}else if(!myreg.test(mobile)){
			msg = '请输入有效的手机号！';
		}
		if(msg!=''){
			alert(msg,'','');
			return false;
		}else{
			return true;
		}
	}


	//验证码倒计时
	var countdown = 60;
	function Settime(ob) {
		if (countdown == 0) {
			$(ob).html("获取验证码");
			countdown = 60;
			flag = true;
			$(ob).css('background','#3679ff');
			return;
		} else {
			$(ob).html(countdown+'S');
			$(ob).css('background','#9E9E9E');
			countdown--;
			flag = false;
		}
		setTimeout(function () {
			Settime(ob);
		}, 1000);
	}
</script>
</body>
</html>