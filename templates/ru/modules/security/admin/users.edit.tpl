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
    <label class="control-label" for="inputPhone">Телефон</label>
    <div class="controls">
		<input type="text" name="phone"  id="inputPhone" value="{$i.phone}">
    </div>
  </div>
    
{if $i.org == 1} 
    <div style=""  class="control-group">
        <h4 class="controls">Юридическое лицо </h4>
    </div>
    <div style=""  class="control-group">
        <label class="control-label">  Название оргазинации:  </label> <div class="controls">{$i.data.organization_name}</div>
    </div>
    <div style=""  class="control-group">
        <label class="control-label"> ИНН:                    </label> <div class="controls"> {$i.data.inn}</div> 
    </div>    
{else} <div style=""  class="control-group">
        <h4 class="controls">Физическое лицо </h4>
    </div>
{/if}

  <div class="control-group">
    <div class="controls">
     
      <button name="submit" type="submit" class="btn"> Сохранить </button>
    </div>
  </div>
</form>
	
	
	
{/foreach}
{/if}
