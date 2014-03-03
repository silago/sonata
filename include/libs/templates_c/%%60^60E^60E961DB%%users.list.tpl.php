<?php /* Smarty version 2.6.16, created on 2013-08-01 17:15:59
         compiled from ru/modules/security/admin/users.list.tpl */ ?>




<table class="table table-striped" style="margin-top: 10px;">
	<tr>
		<th>	id			</th>
		<th>	Email		</th>
		<th>	Имя					</th>
		<th>	Фамилия				</th>
		<th>	Отчество			</th>
		<th>	Дата регистрации	</th>
		<th>		</th>
		<th>		</th>
	</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>  
	<tr>
		<td>	<?php echo $this->_tpl_vars['i']['id']; ?>
	</td>
		<td>	<?php echo $this->_tpl_vars['i']['email']; ?>
	</td>
		<td>	<?php echo $this->_tpl_vars['i']['name']; ?>
	</td>
		<td>	<?php echo $this->_tpl_vars['i']['surname']; ?>
	</td>
		<td>	<?php echo $this->_tpl_vars['i']['patronymic']; ?>
	</td>
		<td>	<?php echo $this->_tpl_vars['i']['reg_date']; ?>
	</td>
		<td>  <a  onclick='	if (!confirm("Удалить пользователя")) return false; ' href="/admin/security/userDelete.php/<?php echo $this->_tpl_vars['i']['id']; ?>
">	Удалить	</a>	</td>
		<td>  <a href="/admin/security/userEdit.php/<?php echo $this->_tpl_vars['i']['id']; ?>
">Редактировать</a>	</td>
	</tr>
	
	
     
<?php endforeach; endif; unset($_from); ?>
</table>
<br>
<br>

<a onclick='$(".useradd").toggle();' href="#"> Добавить пользователя </a>
<form class="useradd form-horizontal" style="display:none;" method="POST" action="/admin/security/userAdd.php">



  <div style="color:red;" class="control-group">
	<center>
		<p class="text-error"> <?php echo $this->_tpl_vars['alert']; ?>
 </p> 
	</center>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text"  name="email" id="inputEmail">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputName">Имя</label>
    <div class="controls">
		<input type="text" name="name" id="inputName">
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="inputSurname">Фамилия</label>
    <div class="controls">
		<input type="text" name="surname" id="inputSurname">
    </div>
  </div>
  
   <div class="control-group">
    <label class="control-label" for="inputPatronymic">Отчество</label>
    <div class="controls">
		<input type="text" id="inputPatronymic" name="patronymic">
    </div>
  </div>
  
  
  
  <div class="control-group">
    <label class="control-label" for="inputPhone">Телефон</label>
    <div class="controls">
		<input type="text" name="phone"  id="inputPhone">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="inputPassword">Пароль</label>
    <div class="controls">
		<input type="password" name="pass"  id="inputPassword">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="inputPassword2">Повтор пароля</label>
    <div class="controls">
		<input type="password" name="pass2"  id="inputPassword2">
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
     
      <button name="submit" type="submit" class="btn"> Сохранить </button>
    </div>
  </div>
</form>