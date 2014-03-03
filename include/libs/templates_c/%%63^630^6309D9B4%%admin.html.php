<?php /* Smarty version 2.6.16, created on 2014-02-25 13:35:47
         compiled from ru/admin.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>
        
        </title>	
        <?php echo '
		<link href="/templates/ru/css/admin.css" type="text/css" rel="stylesheet" />
		<link href="/css/uploadify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="/include/JsHttpRequest/JsHttpRequest.js"></script>
		<script type="text/javascript" src="/templates/ru/api/tooltip.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/js/jquery.uploadify-3.1.min.js"></script>
		
		<script type="text/javascript">			
			$(document).ready(function() {
				$("#item_main_photo").uploadify({
						fileTypeDesc  : \'Image Files\',
						formData      : {\'phototype\' : \'main\', \'module\' : \'catalog\', \'area\' : \'items\'},
						fileTypeExts  : \'*.gif; *.jpg; *.png\',
						buttonText 	  : \'Выберите файл\',
						multi		  : true,						
						swf           : \'/include/uploadify/uploadify.swf\',
						uploader      : \'/include/uploadify/uploadify.php\',
						
						onUploadStart : function(file){
							$("#item_main_photo").uploadify(\'settings\');							
						
						},																													
						
						onUploadSuccess : function(file, data){																												
							var myArray = data.split (\':::\')
							$("tr.item_main_photo_upl > td > div").each(function(){									
									
									if($(this).hasClass(file.name)){
										$(this).remove();										
									}																	
								});
								
								$("tr.item_main_photo_upl > td").append("<div id=\'photo\' style=\'float:left;padding-left:5px;\' class=" + myArray[1] +"><img src=\'/userfiles/catalog/tmp/items/main/"+myArray[1]+"\' width=\'150\' /><input type=\'hidden\' id=\'item_main_photo\' style=\'float:left\' name=\'item_main_photo_upl[]\' value=" + myArray[1] + "></div>");
								
						}						
				});
			
				$("#item_add_photo").uploadify({						
						fileTypeDesc  : \'Image Files\',
						formData      : {\'phototype\' : \'add\', \'module\' : \'catalog\', \'area\' : \'items\'},
						fileTypeExts  : \'*.gif; *.jpg; *.png\',
						buttonText 	  : \'Выберите файл\',
						multi		  : true,						
						swf           : \'/include/uploadify/uploadify.swf\',
						uploader      : \'/include/uploadify/uploadify.php\',
						
						onUploadStart : function(file){
							$("#item_add_photo").uploadify(\'settings\');							
						
						},																													
						
						onUploadSuccess : function(file, data){																												
							var myArray = data.split (\':::\')
							$("tr.item_add_photo_upl > td > div").each(function(){									
									
									if($(this).hasClass(file.name)){
										$(this).remove();										
									}																	
								});
								
								$("tr.item_add_photo_upl > td").append("<div onClick=\'return ctodel("+ myArray[3] + ", \\"add\\", \\"items\\", \\"catalog\\");\' id=" + myArray[3] + " style=\'float:left;padding-left:5px;\' class=" + myArray[1] +"><img src=\'/userfiles/catalog/items/add/thumb/"+myArray[1]+"\' width=\'150\' /><input type=\'hidden\' style=\'float:left\' name=\'item_add_photo_upl[]\' class="+myArray[3]+" value=" + myArray[1] +"></div>");																								
								
						}						
				});			
			
			});				
		</script>
		<script type="text/javascript">
		function ctodel(id, type, area, module){												
			if (confirm(\'Удалить фото?\')) {
			var src = $(id).find("img").attr(\'src\');			
			var photoname = $(id).find("input[type=\'hidden\']").val();						
			$.ajax({
					type: \'POST\',				
					url: \'/admin/catalog/photoDel.php\',
					data: {src : src, phototype : type, area : area, module : module, photoname : photoname},
					success: function(data){
					$(id).remove();
					alert(\'Фото удалено\');
					console.log(data);
				}
			});			
		return true;
			}
		};
		</script>
		<script type="text/javascript">
			function disableSubmit(id) {
				but = document.getElementById(id);
				but.style.color="#555555";
				but.style.background="#999999";
				but.disabled=true;
				but.value="Пожалуйста подождите...";
			}
		</script>
	</head>
    '; ?>

	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width: 30px;">&nbsp;</td>
				<td style="width: 203px; height: 61px;" align="center"><a href="/admin/"><img src="/templates/ru/images/api/logo.jpg" alt="logo" /></a></td>
				<td style="width: 355px;">&nbsp;</td>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="width: 1%" align="right">
								<img src="/templates/ru/images/api/top.jpg" width="4" height="20" alt="top" />
							</td>
							<td valign="middle" class="top_menu" style="width: 99%; padding-left:30px; background-color: #00529D;">
								<a href="/index.php" target="_blank" tip="Переход на сайт в новом окне" tipsize="200">на сайт</a> | 
								<a href="/admin/config/" tip="Основная конфигурация системы" tipsize="200">конфигурация</a>  | 
								<a href="/admin/stat/index.php" tip="Полная статистика посещаемости сайта" tipsize="200">статистика</a> | 
								<a href="/help.doc" tip="Подробная справка по системе управления" tipsize="200"> помощь</a> | 
								<a href="/admin/logout/index.php" tip="Выход из системы управления" tipsize="200">выход</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="height:35px; padding-right:55px;" colspan="4"><div style="text-align: right;"><span class="lang">Раздел: [langLinks]</span></div></td>
			</tr>
		</table>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td style="width: 30px;">&nbsp;</td>
                 <td style="width: 2px; background-color: #00529D;" valign="top">&nbsp;</td>
                 <td style="width: 201px; background-color: #F0F7FC;" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="padding-left:30px; padding-top:25px; padding-bottom:25px;">
								<p>[adminMenu]</p>
								<img src="/images/empty.gif" width="180" height="1" alt="" />
							</td>
						</tr>
					</table>
				</td>
				<td valign="top" style="padding-left:35px; padding-right:15px;" class="cont">
					<hr noshade style="color: #F0F7FC; background-color: #F0F7FC; height: 2px; width: 100%; border: 0;" />
					<p>
                    </p>
					<hr noshade style="color: #F0F7FC; background-color: #F0F7FC; height: 2px; width: 100%; border: 0;" />
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="height: 35px;" colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td style="width: 30px;">&nbsp;</td>
				<td style="width: 203px; height: 36px; background: #00529D url(/templates/ru/images/api/bot.jpg) right top no-repeat; padding-top:10px; padding-bottom:5px;" align="center">
					<p>
						<span class="in-site">Разработано In-site</span><br />
						<span class="date">2004 - 2013 г.</span>
					</p>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</body>
</html>