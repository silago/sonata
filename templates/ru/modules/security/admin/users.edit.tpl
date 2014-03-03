{literal}
<style>
	table.userlist {width:100%;}
	table.userlist td {padding:10px;}
	table.userlist tr:hover {background-color:lightcyan;}
	table.userlist th {text-align:left; padding:10px; background-color:lightcyan;}
</style>


{/literal}

<br>
<br>


{* {if ($edit) } *}
{ if 1 }
{foreach from=$data item=i} 


<form class="form-horizontal" method=POST action="">
	 <legend>Редактирование пользователя </legend>  
		<p style="color:red;" class="text-error"> {$alert} </p> 	
  <br>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text"  name="email" id="inputEmail" value="{$i.email}">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputName">Имя</label>
    <div class="controls">
		<input type="text" name="name" id="inputName" value="{$i.name}">
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="inputSurname">Фамилия</label>
    <div class="controls">
		<input type="text" name="surname" id="inputSurname" value="{$i.surname}">
    </div>
  </div>
  
   <div class="control-group">
    <label class="control-label" for="inputPatronymic">Отчество</label>
    <div class="controls">
		<input type="text" id="inputPatronymic" name="patronymic" value="{$i.patronymic}">
    </div>
  </div>
  
  
  
  <div class="control-group">
    <label class="control-label" for="inputPhone">Телефон</label>
    <div class="controls">
		<input type="text" name="phone"  id="inputPhone" value="{$i.phone}">
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
     
      <button name="submit" type="submit" class="btn"> Сохранить </button>
    </div>
  </div>
</form>
	
	
	
{/foreach}
{/if}
