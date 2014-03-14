<?php /* Smarty version 2.6.16, created on 2014-03-14 16:16:34
         compiled from ru/bootstrap.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'api_func', 'ru/bootstrap.html', 736, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php echo '
    <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>%title%</title>

		<!-- jquery.treeTable.css - CSS-файл для отображения групп каталог в виде дерева, раздел - каталог -> группы -->
			<link href="/include/ext/treetable/css/jquery.treeTable.css" type="text/css" rel="stylesheet" />
		<!-- jquery.treeTable.css - CSS-файл для отображения групп каталог в виде дерева, раздел - каталог -> группы   -->

		<!-- jquery.treeview.css - CSS-файл для отображения групп каталог в виде дерева, раздел - каталог -> товары  -->
			<link href="/include/ext/treeview/css/jquery.treeview.css" type="text/css" rel="stylesheet" />
		<!-- jquery.treeview.css - CSS-файл для отображения групп каталог в виде дерева, раздел - каталог -> товары  -->

		<!-- bootstrap.css - CSS-файл для bootstrap - общее оформление админки -->
			<link href="/include/ext/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
		<!-- bootstrap.css - CSS-файл для bootstrap - общее оформление админки -->

		<!-- bootstrap-responsive.css - CSS-файл для bootstrap - общее оформление админки для разных девайсов-->
			<link href="/include/ext/bootstrap/css/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
		<!-- bootstrap-responsive.css - CSS-файл для bootstrap - общее оформление админки для разных девайсов -->

		<style>
		body {
			padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}

		.subnav{
			width: 100%;
			height: 36px;
			background-color: #EEE;
			background-repeat: repeat-x;
			background-image: -moz-linear-gradient(top, whiteSmoke 0%, #EEE 100%);
			background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,whiteSmoke), color-stop(100%,#EEE));
			background-image: -webkit-linear-gradient(top, whiteSmoke 0%,#EEE 100%);
			background-image: -ms-linear-gradient(top, whiteSmoke 0%,#EEE 100%);
			background-image: -o-linear-gradient(top, whiteSmoke 0%,#EEE 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#f5f5f5\', endColorstr=\'#eeeeee\',GradientType=0 );
			background-image: linear-gradient(top, whiteSmoke 0%,#EEE 100%);
			border: 1px solid #E5E5E5;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
		}

		.subnav .nav > li > a {
			margin: 0;
			padding-top: 11px;
			padding-bottom: 11px;
			border-left: 1px solid whiteSmoke;
			border-right: 1px solid #E5E5E5;
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			border-radius: 0;
		}

		.subnav-fixed {
			position: fixed;
			top: 40px;
			left: 0;
			right: 0;
			z-index: 1020;
			border-color: #D5D5D5;
			border-width: 0 0 1px;
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			border-radius: 0;
			-webkit-box-shadow: inset 0 1px 0 white, 0 1px 5px rgba(0, 0, 0, .1);
			-moz-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
			box-shadow: inset 0 1px 0 white, 0 1px 5px rgba(0, 0, 0, .1);
			filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.subnav-fixed .nav {
			width: 938px;
			margin: 0 auto;
			padding: 0 1px;
		}

		.subnav-fixed .nav {
			width: 1168px;
		}

		.navbar-fixed-top .brand {
				padding-right: 0;
				padding-left: 20px;
				margin-right: 20px;
				float: left;
				font-weight: bold;
				color: black;
				text-shadow: 0 1px 0 rgba(255, 255, 255, .1), 0 0 30px rgba(255, 255, 255, .125);
				-webkit-transition: all .2s linear;
				-moz-transition: all .2s linear;
				transition: all .2s linear;
		}


		div.menu .placeholder {
			border: 1px dashed #4183C4;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
		}



		div.menu .mjs-nestedSortable-error {
			background: #fbe3e4;
			border-color: transparent;
		}

		div.menu ol {
			margin: 0;
			padding: 0;
			padding-left: 30px;
		}

		div.menu ol.sortable, ol.sortable ol {
			margin: 0 0 0 25px;
			padding: 0;
			list-style-type: none;
		}

		div.menu ol.sortable {
			margin: 2em 0;
		}

		div.menu .sortable li {
			margin: 5px 0 0 0;
			padding: 0;
		}

		div.menu .sortable li div  {
			border: 1px solid #d4d4d4;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			border-color: #D4D4D4 #D4D4D4 #BCBCBC;
			padding: 6px;
			margin: 0;
			margin-bottom:10px;
			cursor: move;
			background: #f6f6f6;
		}

		div.menu .sortable li div.btn-group{
			border: none;
			padding: 0px;
			margin: 0;
			margin-top:-20px;
			background: none;
		}

		div.menu .sortable li div.control-group{
			border: none;
			padding: 0px;
			margin: 0;
			background: none;
		}

		div.menu .sortable li div.controls{
			border: none;
			padding: 0px;
			margin: 0;
			background: none;
		}


		div.menu .sortable li div.info  {
			border-top: 1px solid #fff;
			display:none;
			margin-top:-13px;
			background:#e4e4e4;
		}

		div.menu .control-label{
			color:#666;
			font-style:italic;
		}

		div.struct div.main  {
			border: 1px solid #d4d4d4;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			border-color: #D4D4D4 #D4D4D4 #BCBCBC;
			margin: 0;
			margin-bottom:10px;
			background: #f6f6f6;
			padding: 6px;
		}

		div.struct div.info  {
			border: 1px solid #d4d4d4;
			border-top: 1px solid #fff;
			display:none;
			margin-top:-13px;
			background:#e4e4e4;
			padding: 19px;
			margin-bottom: 10px;
		}

		</style>

		<!-- jQuery and jQuery UI (REQUIRED) for bootstrap, elfinder, sortable menu -->
			<script type="text/javascript" src="/include/ext/elfinder/js/jquery.min.js"></script>
			<script type="text/javascript" src="/include/ext/elfinder/js/jquery-ui.min.js"></script>
		<!-- jQuery and jQuery UI (REQUIRED) for bootstrap, elfinder, sortable menu -->

		<!-- js script-files for bootstrap -->
			<script src="/include/ext/bootstrap/js/bootstrap-alert.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-modal.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-dropdown.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-scrollspy.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-tab.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-tooltip.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-popover.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-button.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-collapse.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-carousel.js"></script>
			<script src="/include/ext/bootstrap/js/bootstrap-typeahead.js"></script>
			<script src="/include/ext/bootstrap/js/application.js"></script>
            <script type="text/javascript" src="/include/ext/scripts/jquery.timers.js"></script>
		<!-- js script-files for bootstrap -->

		<!-- переопределяем, иначе конфликт bootstrap - elfinder -->
			<script type="text/javascript" src="/include/ext/elfinder/js/jquery-ui.min.js"></script>
		<!-- переопределяем, иначе конфликт bootstrap - elfinder -->

		<!-- CSS for elFinder (REQUIRED) -->
			<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
			<link rel="stylesheet" type="text/css" media="screen" href="/include/ext/elfinder/css/elfinder.min.css">
			<link rel="stylesheet" type="text/css" media="screen" href="/include/ext/elfinder/css/theme.css">
		<!-- CSS for elFinder (REQUIRED) -->

		<!-- elFinder JS (REQUIRED) -->
			<script type="text/javascript" src="/include/ext/elfinder/js/elfinder.min.js"></script>
		<!-- elFinder JS (REQUIRED) -->

		<!-- elFinder translation (OPTIONAL) -->
			<script type="text/javascript" src="/include/ext/elfinder/js/i18n/elfinder.ru.js"></script>
		<!-- elFinder translation (OPTIONAL) -->

		<!-- elfinder intialization for catalog, pages, news etc. -->
			<script type="text/javascript" src="/include/ext/scripts/finder.js"></script>
		<!-- elfinder intialization for catalog, pages, news etc. -->

		<!-- отображение групп каталога в виде дерева, раздел каталог -> группы -->
			<script type="text/javascript" src="/include/ext/treetable/js/jquery.treeTable.js"></script>
		<!-- отображение групп каталога в виде дерева, раздел каталог -> группы -->

		<!-- отображение групп каталога в виде дерева, раздел каталог -> товары -->
			<script src="/include/ext/treeview/js/jquery.cookie.js" type="text/javascript"></script>
			<script src="/include/ext/treeview/js/jquery.treeview.js" type="text/javascript"></script>
		<!-- отображение групп каталога в виде дерева, раздел каталог -> товары -->

		<script type="text/javascript" src="/include/ext/nestednemu/jquery.mjs.nestedSortable.js"></script>

		<script type="text/javascript" src="/include/ext/synctranslit/jquery.synctranslit.js"></script>

		
		<link rel="stylesheet" href="/include/ext/datepicker/css/jquery.ui.theme.css">
		<link rel="stylesheet" href="/include/ext/datepicker/css/jquery.ui.datepicker.css">
		<script src="/include/ext/datepicker/js/jquery.ui.datepicker.js"></script>
        <script src="/include/ext/datepicker/js/jquery.ui.datepicker-ru.js"></script>
		
		
		<script type="text/javascript" charset="utf-8">

        function ShowOrHide(id){
					if($(\'div#info_\'+id).css(\'display\') == \'none\'){
						$(\'div#info_\'+id).css(\'display\', \'block\');
					}else{
						$(\'div#info_\'+id).css(\'display\', \'none\');
					}

				}

				function cancelChange(id, title, url){
					$(\'div#info_\'+id).find(\'input[name="title"]\').val(title);
					$(\'div#info_\'+id).find(\'input[name="url"]\').val(url);
					return false;
				}

				function deleteNode(id){
					var content = $(\'li#list_\'+id).children(\'ol\').html();
					$(\'li#list_\'+id).parent(\'ol\').append(content);
					$(\'li#list_\'+id).remove();
					return false;
				}

				function getMaxId(){
					var ind =\'0\';
					var list = [];
					var idmax = \'\';
					$(\'ol > li\').each(function(){list[ind] = $(this).attr(\'id\').replace(\'list_\', "");ind++;})
					if(!(list.length)){idmax = 0;}else{idmax = Math.max.apply({},list);}
					console.log(list);
					return idmax;
				}

				function setNewId(id){
					var newid = \'\';
					newid = id+1;
					return newid;
				}

				function add(){
					var maxid = getMaxId();
					var idnew = setNewId(maxid);
					var title = $(\'input#titleManual\').val();
					var url = $(\'input#urlManual\').val();
					var regtitle = /^[a-zа-я0-9\\.\\:\\/\\?\\&\\=\\-\\!\\+\\\\\\"\\s]+$/i;
					var regurl = /^[a-zа-я0-9\\.\\:\\/\\?\\&\\=\\-]+$/i;
					var ret =	\'<li id="list_\'+idnew+\'">\'+
									\'<div>\' +
                                        \'<span class="blockTitle">\'+title+\'</span>\' +
                                        \'<span style="float:right;cursor:pointer;" onclick="return ShowOrHide(\'+idnew+\')">\' +
                                            \'<i title="Подробнее" class="icon-chevron-down"></i>\' +
                                        \'</span>\' +
                                    \'</div>\'+
									\'<div id="info_\'+idnew+\'" class="info">\' +
										\'<form action="#" class="form-inline">\' +
                                            \'<div class="control-group">\' +
                                                \'<label class="control-label" for="title">Заголовок ссылки:</label>\' +
                                                \'<div class="controls">\' +
                                                    \'<input onBlur="return checkTitle(\\\'\'+idnew+\'\\\',\\\'\'+title+\'\\\',\\\'\'+url+\'\\\');" type="text" name="title" id="title" value="\'+title+\'">\' +
                                                \'</div>\' +
                                            \'</div>\' +
										    \'<div class="control-group">\' +
                                                \'<label class="control-label" for="url">URL:</label>\' +
                                                \'<div class="controls">\' +
                                                    \'<input onBlur="return checkUrl(\\\'\'+idnew+\'\\\',\\\'\'+title+\'\\\',\\\'\'+url+\'\\\');" type="text" name="url" id="url" value="\'+url+\'">\' +
                                                \'</div>\' +
                                            \'</div>\' +
                                        \'</form>\'+
										\'<div class="btn-group">\' +
											\'<button title="Отменить изменения" data-placement="bottom" class="btn btn-info" onclick="return cancelChange(\\\'\'+idnew+\'\\\',\\\'\'+title+\'\\\',\\\'\'+url+\'\\\');"> <i class="icon-refresh"></i></button>\'+
											\'<button title="Удалить пункт меню" data-placement="bottom" class="btn btn-danger" onclick="return deleteNode(\\\'\'+idnew+\'\\\')"> <i class="icon-trash"></i></button>\' +
										\'</div>\' +
									\'</div>\' +
                                    \'<input type=hidden class="title" name="itemsArr[\'+idnew+\'][title]" value="\'+title+\'">\'+
                                    \'<input type=hidden class="url" name="itemsArr[\'+idnew+\'][uri]" value="\'+url+\'">\'+
                                    \'<input type=hidden class="item_id" name="itemsArr[\'+idnew+\'][item_id]" value="\'+idnew+\'">\'+
                                    \'<input type=hidden class="parent_id" name="itemsArr[\'+idnew+\'][parent_id]" value="">\'+
                                    \'<input type=hidden class="order" name="itemsArr[\'+idnew+\'][order]" value="">\'+
                                    \'<ol id="\'+idnew+\'"></ol>\'+
                                    \'</li>\';
					if(!(title.match(regtitle))){
						alert(\'Поле title не заполнено или содержит недопустимые символы\');
					}else if(!(url.match(regurl))){
						alert(\'Поле URL не заполнено или содержит недопустимые символы\');
					}else{
                        $(\'.sortable\').prepend(ret);
					}

				return false;
				}

				function deletedMenuItems(){
					if(confirm(\'Удалить все пункты?\')){$(\'.sortable\').empty();}
					return false;
				}

				function multiadd(id){
					var addingTitle = [];
					var addingOwnerTitle = [];
					var addingUrl = [];
					var parentcheck = [];
					var ulid = [];
					var liid = [];
					var maxid = getMaxId();
					var idnew = setNewId(maxid);

					var index = ++maxid;

					$(\'div#\'+id+\'\').find(\'input[name="adding"]:checked\').each(function(){

						liid[index] = $(this).parent().parent().attr(\'id\');
						ulid[index] = $(this).parents(\'ul:first\').attr(\'id\');
						if(ulid[index] == undefined){ulid[index] = 0;}
						addingTitle[index] = $(this).parent().parent().find(\'input[name="title"]\').val();
						addingUrl[index] = $(this).parent().parent().find(\'input[name="url"]\').val();

						addingOwnerTitle[index] = $(this).parents(\'li#\'+ulid[index]+\'\').find(\'input[name="title"]\').val();
						if(addingOwnerTitle[index] == undefined){addingOwnerTitle[index] = 0;}

						var ret = 	\'<li id="list_\'+index+\'">\'+
										\'<div><span class="blockTitle">\'+addingTitle[index]+\'</span><span style="float:right" onclick="return ShowOrHide(\'+index+\')"><i title="Подробнее" class="icon-chevron-down"></i></span></div>\'+
										\'<div id=info_\'+index+\' class="info">\'+
											\'<form action="#" class=".form-inline"><div class="control-group"><label class="control-label" for="title">Заголовок ссылки:</label><div class="controls"><input style="width:98%" onBlur="return checkTitle(\'+idnew+\',\\\'\'+addingTitle[index]+\'\\\',\\\'\'+addingUrl[index]+\'\\\');" type="text" name="title" value=\\\'\'+addingTitle[index]+\'\\\'></div></div>\'+
											\'<div class="control-group"><label class="control-label" for="url">URL:</label><div class="controls"><input style="width:98%" onBlur="return checkUrl(\'+index+\',\\\'\'+addingTitle[index]+\'\\\',\\\'\'+addingUrl[index]+\'\\\');" type="text" name="url" value=\\\'\'+addingUrl[index]+\'\\\'></div></div></form>\'+
											\'<div class="btn-group">\'+
												\'<button title="Отменить изменения" data-placement="bottom" class="btn btn-info" onclick="return cancelChange(\'+index+\',\\\'\'+addingTitle[index]+\'\\\',\\\'\'+addingUrl[index]+\'\\\');"> <i class="icon-refresh"></i></button>\'+
												\'<button title="Удалить пункт меню" data-placement="bottom" class="btn btn-danger" onclick="if(confirm(\\\'Удалить пункт меню?\\\')){return deleteNode(\'+index+\')}"> <i class="icon-trash"></i></button>\'+
											\'</div>\'+
										\'</div>\'+
									\'<input type=hidden class="title" name="itemsArr[\'+index+\'][title]" value="\'+addingTitle[index]+\'">\'+
									\'<input type=hidden class="url" name="itemsArr[\'+index+\'][uri]" value="\'+addingUrl[index]+\'">\'+
									\'<input type=hidden class="item_id" name="itemsArr[\'+index+\'][item_id]" value="\'+index+\'">\'+
									\'<input type=hidden class="parent_id" name="itemsArr[\'+index+\'][parent_id]" value="">\'+
									\'<input type=hidden class="order" name="itemsArr[\'+index+\'][order]" value="">\'+
									\'<ol id="\'+liid[index]+\'"></ol>\'+
									\'</li>\';



						if((ulid[index])){

							/*if(($(\'.sortable\').find(\'ol\').attr(\'id\') == ulid[index])){
									$(\'.sortable\').find(\'ol#\'+ulid[index]+\':last\').append(ret);
							} */

							console.log($(\'.sortable\').find(\'ol#\'+ulid[index]+\'>li\').find(\'input[value=\'+liid[index]+\']\').length);

							/*if($(\'.sortable\').find(\'ol#\'+ulid[index]+\'>li\').find(\'input[value=\'+liid[index]+\']\').length > 0){
								$(\'.sortable\').append(ret); */
							if($(\'.sortable\').find(\'ol#\'+ulid[index]+\'\').length > 0){
								$(\'.sortable\').find(\'ol#\'+ulid[index]+\':last\').append(ret);
							}else if(($(\'.sortable\').find(\'ol#\'+ulid[index]+\'\').length == 0)){
								$(\'.sortable\').append(ret);
							}

						}else{
                            $(\'.sortable\').append(ret);
                            $(\'input#titleManual\').empty();
                            $(\'input#urlManual\').empty();
						}




					index++;
					//$(this).attr(\'checked\', false);

					})

				/*$(\'.sortable\').find(\'ol\').each(function(){
					if($(this).html() == \'\'){
						console.log($(this).html());
						$(this).remove();
					}

				}) */


				return false;
				}

				function menuCheck(){
					$(\'.sortable\').find(\'li\').each(function(){

						var itemTitle = $(this).find(\'input[class="title"]\').val();
						var itemUrl = $(this).find(\'input[class="url"]\').val();
						var itemId = $(this).find(\'input[class="item_id"]\').val();
						var itemParentId = $(this).find(\'input[class="parent_id"]\').val();

						var itemIndex = $(this).index();
						$(this).find(\'input[class="order"]\').val(itemIndex);


						var newItemParentId = $(this).parents(\'li:first\').find(\'input[class="item_id"]\').val();
						if(newItemParentId == undefined){newItemParentId = 0;}

                        var newUrl = $(this).find(\'input[name="url"]\').val();
                        if(!(itemUrl == newUrl)){
                            $(this).find(\'input[class="url"]\').val(newUrl);
                        }

                        var newTitle = $(this).find(\'input[name="title"]\').val();
                        if(!(itemTitle == newTitle)){
                            $(this).find(\'input[class="title"]\').val(newTitle);
                        }

						if(!(itemParentId === newItemParentId)){
							$(this).find(\'input[class="parent_id"]\').val(newItemParentId);
						}
					});

					if(!($(\'input[name="menuid"]\').val()==\'empty\')){
						var menuid = $(\'input[name="menuid"]\').val();
					}else{
						var menuid=\'\';
					}

					var reg = /^[a-zа-я0-9\\s]+$/i;
					var menuTitle = $(\'input[name="menuTitle"]\').val();

					if(!(menuTitle.match(reg))){
						alert(\'Поле "Название меню" содержит недопустимые символы\');
					}

					arraied = $(\'ol.sortable\').nestedSortable(\'toArray\', {startDepthCount: 0});
					if(arraied.length == 1 ){
						alert(\'Необходимо добавить хотя бы один пункт меню\');
					}

					if((menuTitle.match(reg)) && (arraied.length > 1)){
						return true;
					}

				return false;
				}

				function checkUrl(id, title, url){
					var reg = /^[a-zа-я0-9\\.\\:\\/\\?\\&\\=\\-]+$/i;
					var value = $(\'div#info_\'+id+\'\').find(\'input[name="url"]\').val();
					if(!(value.match(reg))){
						alert(\'Поле "Ссылка" пункта \'+title+\' содержит недопустимые символы\');
						$(\'div#info_\'+id+\'\').find(\'input[name="url"]\').val(url);
					}
				}

				function checkTitle(id, title, url){
					var reg = /^[a-zа-я0-9\\.\\:\\/\\?\\&\\=\\-\\!\\+\\\\\\"\\s]+$/i;
					var value = $(\'div#info_\'+id+\'\').find(\'input[name="title"]\').val();
					if(!(value.match(reg))){
						alert(\'Поле "Заголовок ссылки" пункта \'+title+\' содержит недопустимые символы\');
						$(\'div#info_\'+id+\'\').find(\'input[name="title"]\').val(title);
					}

				}

				function confirmPhoto(id){
					if (confirm(\'Удалить фото?\')){
						$(\'a#\'+id).parent().remove();
					}
					return false;
				};




				$().ready(function() {
					$("#datepicker").datepicker();
					
					
                    $(\'input[name="itemhit"]\').change(function(){
                    var elem = $(this);
                    var item_id = $(this).parent().find(\'input[name="item_id"]\').val();
                        if($(this).attr(\'checked\') == \'checked\'){
                            var value = 1;
                        }else{
                            var value = 0;
                        }

                        $.ajax({
                            type: \'POST\',
                            url: \'/admin/catalog/setItemHit.php\',
                            data: {value:value, itemid:item_id},
                            success: function(data){
                                elem.tooltip({placement: "top",title: data,trigger: \'manual\',
                                        }
                                ),
                                        elem.tooltip(\'show\');
                                elem.oneTime("800ms", function() {
                                    elem.tooltip(\'hide\');
                                });
                            }
                        })
                    });

                    $(\'input[name="itemnew"]\').change(function(){
                        var elem = $(this);
                        var item_id = $(this).parent().find(\'input[name="item_id"]\').val();
                        if($(this).attr(\'checked\') == \'checked\'){
                            var value = 1;
                        }else{
                            var value = 0;
                        }
                        $.ajax({
                            type: \'POST\',
                            url: \'/admin/catalog/setItemNew.php\',
                            data: {value:value, itemid:item_id},
                            success: function(data){
                                elem.tooltip({placement: "top", title: data, trigger: \'manual\'}),
                                elem.tooltip(\'show\');
                                elem.oneTime("800ms", function(){elem.tooltip(\'hide\');});
                            }
                        })
                    });

                    $(\'#name\').syncTranslit({
						destination: \'uri\',
						caseStyle: \'lower\',
						urlSeparator: \'-\',
						max: 40,
					});

					$(\'#uri\').syncTranslit({
						destination: \'uri\',
						caseStyle: \'lower\',
						urlSeparator: \'-\',
						max: 40,
					});


					$(\'#uri\').blur(function(){
							uricheck()
					});


					$(\'#name\').blur(function(){
							uricheck()
					});


					$(\'input[name="adding"]\').change(function(){
						var sel = $(this).attr(\'checked\');
						if(sel==\'checked\'){
							$(this).parent().parent().find(\'input[name="adding"]\').attr(\'checked\', true);
						}else{
							$(this).parent().parent().find(\'input[name="adding"]\').attr(\'checked\', false);
						}
					});


					$("#red").treeview({
						animated: "fast",
						collapsed: true,
						unique: true,
						persist: "cookie",
						toggle: function() {
							window.console && console.log("%o was toggled", this);
						}
					});

					$(\'body\').tooltip({
						selector: "[rel=tooltip]", // можете использовать любой селектор
						placement: "top"
					});

					$(\'input.position.span1\').focus(function(){
						$(this).parent().parent().find(\'a.text\').css(\'color\', \'red\');
					});

					$(\'input.position.span1\').blur(function(){
						$(this).parent().parent().find(\'a.text\').css(\'color\', \'#08C\');
					});


					$(\'a.btn.btn-primary\').each(function(){
						var linkColor = $(this).parent().parent().parent().find(\'a.text\').css(\'color\');
						$(this).mouseover(function(){
							$(this).parent().parent().parent().find(\'a.text\').css(\'color\', \'red\');
						});

						$(this).mouseout(function(){
							$(this).parent().parent().parent().find(\'a.text\').css(\'color\', linkColor);
						});
					});


					$(\'input.ishidden\').each(function(){
						var linkColor = $(this).parent().parent().find(\'a.text\').css(\'color\');
						$(this).mouseover(function(){
							$(this).parent().parent().find(\'a.text\').css(\'color\', \'red\');
						});

						$(this).mouseout(function(){
							$(this).parent().parent().find(\'a.text\').css(\'color\', linkColor);
						});

					});

					$(\'input.ishidden\').change(function(){
						$(\'form#grplist\').find(\'button#savepos\').remove();
						$(\'form#grplist\').append(\'<center><button type="submit" id="savepos" class="btn btn-success" style="margin-top:-145px;">Сохранить</button></center>\');
					});


					$(\'input.position.span1\').change(function(){
						var value = $(this).val();
						var grpid = $(this).attr(\'rel\');
						if(!value.match(\'^[0-9]+$\')){
							$(this).val(\'\');
							alert(\'В поле "Позиция" допустимы только цифры от 0 до 9\');
							$(\'form#grplist\').find(\'button#savepos\').remove();
						}else{
							$(\'form#grplist\').find(\'button#savepos\').remove();
							$(\'form#grplist\').append(\'<center><button type="submit" id="savepos" class="btn btn-success" style="margin-top:-145px;">Сохранить</button></center>\');
						}
					});

					$("#tree").treeTable({
						initialState: \'collapsed\',
						treeColumn: 0,
						expandable: true
					});

					$(\'tr#node-0\').find(\'td > a.expander\').click();
					$(\'tr#node-0\').find(\'td > a.expander\').remove();

					$(\'ol.sortable\').nestedSortable({
						disableNesting: \'no-nest\',
						forcePlaceholderSize: true,
						handle: \'div\',
						helper:	\'clone\',
						items: \'li\',
						maxLevels: 4,
						opacity: .6,
						placeholder: \'placeholder\',
						revert: 250,
						tabSize: 20,
						tolerance: \'pointer\',
						rootID: 0,
						toleranceElement: \'> div\'
					});

                    $(\'ol.sortable1\').nestedSortable({
                        disableNesting: \'no-nest\',
                        forcePlaceholderSize: true,
                        handle: \'div\',
                        helper:	\'clone\',
                        items: \'li\',
                        maxLevels: 1,
                        opacity: .6,
                        placeholder: \'placeholder\',
                        revert: 250,
                        tabSize: 20,
                        tolerance: \'pointer\',
                        rootID: 0,
                        toleranceElement: \'> div\'
                    });
				});
			</script>
	</head>
    '; ?>

	<body>
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<div class="nav-collapse">
							<a class="brand" href="/admin/">PlazaCMS</a>
							<?php echo smarty_function_api_func(array('name' => 'profile'), $this);?>

							<ul class="nav">
								<li class="dropdown active">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">Управление сайтом <span class="caret"></span></a>
									<ul class="dropdown-menu">
									<?php echo smarty_function_api_func(array('name' => 'getCMSNavigation'), $this);?>

                                    <li>
                                        <a href="/admin/banners/">Баннеры</a>
                                    </ul>
								</li>
								<li class="divider-vertical"></li>
								<li class="dropdown active">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">Управление магазином<span class="caret"></span></a>
									<ul class="dropdown-menu">
									
									
									<?php echo smarty_function_api_func(array('name' => 'getShopNavigation'), $this);?>

									<li class="divider"></li>
									<li><a href="/admin/catalog/groupList.php">Группы</a></li>
									<li><a href="/admin/catalog/listItems.php">Товары</a></li>
									</ul>
								</li>
								<li class="divider-vertical"></li>
								<li><a href="">Конфигурация</a></li>
								<li><a href="">Статистика</a></li>
								<li><a href="">Помощь</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
						<?php echo smarty_function_api_func(array('name' => 'getModuleNavigation'), $this);?>

			</div>
			</div><br/>
			<div class="container" id="content">
            <?php echo $this->_tpl_vars['content']; ?>
            
            
            
            
            </div>
	<?php echo smarty_function_api_func(array('name' => 'printInfoAdmin'), $this);?>

    </body>
</html>