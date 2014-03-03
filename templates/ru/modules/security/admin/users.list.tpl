



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
{foreach from=$data item=i}  
	<tr>
		<td>	{$i.id}	</td>
		<td>	{$i.email}	</td>
		<td>	{$i.name}	</td>
		<td>	{$i.surname}	</td>
		<td>	{$i.patronymic}	</td>
		<td>	{$i.reg_date}	</td>
		<td>  <a  onclick='	if (!confirm("Удалить пользователя")) return false; ' href="/admin/security/userDelete.php/{$i.id}">	Удалить	</a>	</td>
		<td>  <a href="/admin/security/userEdit.php/{$i.id}">Редактировать</a>	</td>
	</tr>
	
	
     
{/foreach}
</table>
<br>
<br>

<a onclick='$(".useradd").toggle();' href="#"> Добавить пользователя </a>
<form class="useradd form-horizontal" style="display:none;" method="POST" action="/admin/security/userAdd.php">



  <div style="color:red;" class="control-group">
	<center>
		<p class="text-error"> {$alert} </p> 
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
