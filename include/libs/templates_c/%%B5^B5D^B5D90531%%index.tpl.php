<?php /* Smarty version 2.6.16, created on 2014-03-11 15:13:20
         compiled from ru/plugins/topLoginForm/index.tpl */ ?>
			
			
				<div class="headerTop">
                    <!--<a href="#" class="consult">он-лайн консультант</a>-->
                    <?php if ($this->_tpl_vars['authed'] == 'false'): ?>
                    <div class="boxLogin"><span>Личный кабинет: </span>&nbsp;&nbsp; <a href="/logingo/">Вход</a> <!--<span>|</span> <a href="/register/">Регистрация</a> --></div>
                    
                    <?php else: ?>
                     <div class="enter-box"> <span><a href="/cabinet"><?php echo $this->_tpl_vars['userName']; ?>
</a></span> &nbsp;&nbsp; <a href="/logout/">Выход</a></div>
			

                    <?php endif; ?>
                    	<!--	<a onclick="addToChart(139);" href="#"> addToChart(139);</a> -->
                    <div class="clear"></div>
                </div>

