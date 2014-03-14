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
    
    <div style=""  class="control-group">
{if $i.org == 1} 
    <table>
        <tr><td colspan=2> Юридическое лицо </td></tr>
        <tr><td> Название оргазинации:  </td><td> {$i.data.organization_name}</td> </tr>
        <tr><td> ИНН:  </td>  <td> {$i.data.inn}</td>  </tr> 
    </table>
{else}
<table>
<tr>
<td>Физическое лицо</td>
</tr>
</table>

{/if}

    </div>
  <div class="control-group">
    <div class="controls">
     
      <button name="submit" type="submit" class="btn"> Сохранить </button>
    </div>
  </div>
</form>
	
	
	
{/foreach}
{/if}
