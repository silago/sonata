<?php /* Smarty version 2.6.16, created on 2014-03-10 23:44:06
         compiled from ru/modules/security/index/cabinet.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_menu', 'ru/modules/security/index/cabinet.form.tpl', 15, false),)), $this); ?>
﻿<div style="margin-top:-20px;" class="container-content">
		<div class="aside-setting">
					<div class="nav-aside">
						<ul>
							<li><a href="/cabinet">Личный кабинет</a></li>
							<li class="active"><a href="/orderslist">Мои заказы</a></li>
							<li><a href="/basket">Моя корзина</a></li>
						</ul>	
					</div>

					<div class="help">
						<span>Помощь</span>

						<div class="block">
						    <?php echo smarty_function_show_menu(array('menuid' => 7), $this);?>

                        </div>	
					</div>
				</div>




<?php echo '
	<script>
		function changeType(id){
			$(\'tbody#fizform\').hide();$(\'tbody#orgform\').hide();var type = $(\'select#\'+id+\'>option:selected\').val();
			switch (type){case \'1\':$(\'tbody#fizform\').show();break; case \'2\': $(\'tbody#orgform\').show(); break;}			
			return false;
		}
		
		function changePass(){
			if($(\'tbody#passchange\').css(\'display\') == \'none\'){
				$(\'tbody#passchange\').css(\'display\', \'table-row-group\'); $(\'input#passchange\').val(1);
			}else{
				$(\'tbody#passchange\').css(\'display\', \'none\'); $(\'input#passchange\').val(0);
			}
			return false;
		}
	</script>
	
	<style>
	.tabContent table tr td {vertical-align:top; padding:10px;}
	
	</style>
'; ?>


	<div class="content">

					<div class="product">

        <h2>Личный кабинет</h2>
<?php if ($this->_tpl_vars['error']): ?>
    <div class="alert alert-error">
    <?php $_from = $this->_tpl_vars['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <?php echo $this->_tpl_vars['item']; ?>

    <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
    <div class="box-cont">
<div class="cabitene">
<form  class="tabContent" action="/savedata/" method="post">

	                            <div class="box">
									<p>Данные покупателя</p>

									<div class="block">
										<span>Имя</span>	
										<input value="<?php echo $this->_tpl_vars['name']; ?>
 <?php echo $this->_tpl_vars['surname']; ?>
 <?php echo $this->_tpl_vars['patronymic']; ?>
" name="name" type="text"/>
									</div>

									<div class="block">
										<span>Телефон</span>	
										<input type="text" name="phone" value="<?php echo $this->_tpl_vars['phone']; ?>
" />
									</div>

									<div class="block">
										<span>E-Mail</span>	
										<input type="text" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
" />
									</div>	
								</div>
                                
                        		<div class="box">
									<p>Смена пароля</p>
                                	<input type="hidden" name="passchange" id="passchange" value="<?php echo $this->_tpl_vars['passchange']; ?>
">
                        
                                    <div class="block">
										<span>Старый пароль</span>	
										<input type="password" name="oldpass" placeholder="********" />
									</div>


									<div class="block">
										<span>Новый пароль</span>	
										<input type="password" name="newpass" placeholder="********" />
									</div>

									<div class="block">
										<span>Повторить пароль</span>	
										<input type="password" name="newpassconfirm" placeholder="********" />
									</div>

									<input type="submit" value="Сменить пароль" class="change-pass" />	
								</div>

                               
                                <div class="box">
									<p>Организация</p>

									<div class="block">
										<span>Название</span>	
										<input type="text" name="data[organization_name]" value="<?php echo $this->_tpl_vars['data']['data']['organization_name']; ?>
" />
									</div>

									<div class="block">
										<span>ИНН</span>	
										<input type="text" name="data[inn]" value="<?php echo $this->_tpl_vars['data']['data']['inn']; ?>
" placeholder="456654545654" />
									</div>	
								</div> 
                                
                                
                                	<div class="box">
									<p>Адрес</p>

									<div class="block">
										<div class="bl-box">
											<span>Улица</span>
											<input type="text" name="order[street]" value="<?php echo $this->_tpl_vars['data']['order']['street']; ?>
" placeholder="Васильевская" />	
										</div>
									</div>
                                    <div class="block">
                                    
										<div class="bl-box">
											<div class="adr">
												<span>Дом</span>
												<input name="order[house]" value="<?php echo $this->_tpl_vars['data']['order']['house']; ?>
" type="text" placeholder="5" class="c1" />	
											</div>

											<div class="adr">
												<span>Корпус</span>
												<input type="text" name="order[corp]" value="<?php echo $this->_tpl_vars['data']['order']['corp']; ?>
" placeholder="2" class="c2" />	
											</div>	

											<div class="adr">
												<span>Квартира/офис</span>
												<input type="text" name="order[office]" value="<?php echo $this->_tpl_vars['data']['order']['office']; ?>
"  placeholder="16" class="c3" />	
											</div>
										</div>
									</div>	
								</div>	

                                <input class="button_4" type="hidden" name="go" value="go">
								<input type="submit" value="Сохранить изменения" class="save" />



</form>
</div>
</div>
</div></div></div>