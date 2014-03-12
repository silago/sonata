<div style="margin-top:-20px;" class="container-content">
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
						    {show_menu menuid=7}
                        </div>	
					</div>
				</div>




{literal}
	<script>
		function changeType(id){
			$('tbody#fizform').hide();$('tbody#orgform').hide();var type = $('select#'+id+'>option:selected').val();
			switch (type){case '1':$('tbody#fizform').show();break; case '2': $('tbody#orgform').show(); break;}			
			return false;
		}
		
		function changePass(){
			if($('tbody#passchange').css('display') == 'none'){
				$('tbody#passchange').css('display', 'table-row-group'); $('input#passchange').val(1);
			}else{
				$('tbody#passchange').css('display', 'none'); $('input#passchange').val(0);
			}
			return false;
		}
	</script>
	
	<style>
	.tabContent table tr td {vertical-align:top; padding:10px;}
	
	</style>
{/literal}

	<div class="content">

					<div class="product">

        <h2>Личный кабинет</h2>
{if $error}
    <div class="alert alert-error">
    {foreach from=$error item=item key=key}
          {$item}
    {/foreach}
    </div>
{/if}
    <div class="box-cont">
<div class="cabitene">
<form  class="tabContent" action="/savedata/" method="post">

	                            <div class="box">
									<p>Данные покупателя</p>

									<div class="block">
										<span>Имя</span>	
										<input value="{$surname} {$name} {$patronymic}" name="name" type="text"/>
									</div>

									<div class="block">
										<span>Телефон</span>	
										<input type="text" name="phone" value="{$phone}" />
									</div>

									<div class="block">
										<span>E-Mail</span>	
										<input type="text" name="email" value="{$email}" />
									</div>	
								</div>
                                
                        		<div class="box">
                                    {literal}
									<p>Смена пароля</p>
                                	<script type="text/javascript">
                                    pone = false;
                                    ptwo = false;
                                    pthree = false;
                                    function pcheck()
                                    {
                                    if (pone && ptwo && pthree)
                                        $('.change-pass').removeAttr('disabled');
                                    else
                                        $('.change-pass').attr('disabled','disabled');
                                    }
                                    </script>
                                    
                                    <input  type="hidden" name="passchange" id="passchange" value="{$passchange}">
                        
                                    <div class="block">
										<span>Старый пароль</span>	
										<input onchange="if ($(this).val()!='') pone=true; else pone=false; pcheck();" type="password" name="oldpass" placeholder="********" />
									</div>


									<div class="block">
										<span>Новый пароль</span>	
										<input onchange="if ($(this).val()!='') ptwo=true; else ptwo=false; pcheck();" type="password" name="newpass" placeholder="********" />
									</div>

									<div class="block">
										<span>Повторить пароль</span>	
										<input onchange="if ($(this).val()!='') pthree=true; else pthree=false; pcheck();" type="password" name="newpassconfirm" placeholder="********" />
									</div>
                                    {/literal}
									<input disabled=disabled type="submit" value="Сменить пароль" class="change-pass" />	
								</div>

                               
                                <div class="box">
									<p>Организация</p>

									<div class="block">
										<span>Название</span>	
										<input type="text" name="data[organization_name]" value="{$data.data.organization_name}" />
									</div>

									<div class="block">
										<span>ИНН</span>	
										<input type="text" name="data[inn]" value="{$data.data.inn}" placeholder="456654545654" />
									</div>	
								</div> 
                                
                                
                                	<div class="box">
									<p>Адрес</p>

									<div class="block">
										<div class="bl-box">
											<span>Улица</span>
											<input type="text" name="order[street]" value="{$data.order.street}" placeholder="Васильевская" />	
										</div>
									</div>
                                    <div class="block">
                                    
										<div class="bl-box">
											<div class="adr">
												<span>Дом</span>
												<input name="order[house]" value="{$data.order.house}" type="text" placeholder="5" class="c1" />	
											</div>

											<div class="adr">
												<span>Корпус</span>
												<input type="text" name="order[corp]" value="{$data.order.corp}" placeholder="2" class="c2" />	
											</div>	

											<div class="adr">
												<span>Квартира/офис</span>
												<input type="text" name="order[office]" value="{$data.order.office}"  placeholder="16" class="c3" />	
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
