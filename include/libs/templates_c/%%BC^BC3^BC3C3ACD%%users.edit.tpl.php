<?php /* Smarty version 2.6.16, created on 2014-03-14 18:09:56
         compiled from ru/modules/security/admin/users.edit.tpl */ ?>
<?php echo '
<style>
	table.userlist {width:100%;}
	table.userlist td {padding:10px;}
	table.userlist tr:hover {background-color:lightcyan;}
	table.userlist th {text-align:left; padding:10px; background-color:lightcyan;}
</style>


'; ?>


<br>
<br>


<?php if (1):  $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?> 


<form class="form-horizontal" method=POST action="">
	 <legend>Редактирование пользователя </legend>  
		<p style="color:red;" class="text-error"> <?php echo $this->_tpl_vars['alert']; ?>
 </p> 	
  <br>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text"  name="email" id="inputEmail" value="<?php echo $this->_tpl_vars['i']['email']; ?>
">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputName">Имя</label>
    <div class="controls">
		<input type="text" name="name" id="inputName" value="<?php echo $this->_tpl_vars['i']['name']; ?>
">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="inputPhone">Телефон</label>
    <div class="controls">
		<input type="text" name="phone"  id="inputPhone" value="<?php echo $this->_tpl_vars['i']['phone']; ?>
">
    </div>
  </div>
    
<?php if ($this->_tpl_vars['i']['org'] == 1): ?> 
    <div style=""  class="control-group">
        <h4 class="controls">Юридическое лицо </h4>
    </div>
    <div style=""  class="control-group">
        <label class="control-label">  Название оргазинации:  </label> <div class="controls"><?php echo $this->_tpl_vars['i']['data']['organization_name']; ?>
</div>
    </div>
    <div style=""  class="control-group">
        <label class="control-label"> ИНН:                    </label> <div class="controls"> <?php echo $this->_tpl_vars['i']['data']['inn']; ?>
</div> 
    </div>    
<?php else: ?> <div style=""  class="control-group">
        <h4 class="controls">Физическое лицо </h4>
    </div>
<?php endif; ?>

  <div class="control-group">
    <div class="controls">
     
      <button name="submit" type="submit" class="btn"> Сохранить </button>
    </div>
  </div>
</form>
	
	
	
<?php endforeach; endif; unset($_from);  endif; ?>