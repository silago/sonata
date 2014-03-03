<table cellspacing="0" border="1" cellpadding="3" width="570">
<tbody><tr>
        <td align="right" width="200" height="255" valign="top"><br><br><font size="2"><p>Извещение</p><br><br><br><br><br><br><br><br><br><br><br>
        <font size="1"><p>Кассир</p></font></font></td>
             <td align="right" width="100" height="255" valign="middle">
                <font size="-1"></font><p align="center"><font size="-1">ИНН {$inn} КПП {$kpp}<br><u>{$recipient}</u><br><font size="1">получатель платежа</font></font>
            </p><table cellspacing="0" border="1" cellpadding="3" width="370"><tbody><tr><td align="center" colspan="4" height="10" valign="center"><font size="2"><p>Расчетный счет: {$account}&nbsp;&nbsp;БИК: {$bik}</p></font></td></tr>
                <tr><td align="center" colspan="4" height="10" valign="center"><font size="2"><p>Кор. сч.: {$korAccount}&nbsp;&nbsp;&nbsp;&nbsp;</p></font></td></tr>
                <tr><td colspan="4"><font size="2"></font><center><font size="2">{$surname} {$name} {$patronymic}<br>{$adress}</font><center><font size="2"><center><font size="1">плательщик (ФИО, адрес)</font></center></font></center></center></td></tr>
                <tr><td align="center" colspan="2"><font size="2">Вид платежа</font></td><td align="center"><font size="2">Дата</font></td><td align="center"><font size="2">Сумма</font></td></tr>
                <tr><td align="center" colspan="2"><font size="1">{$payment}</font></td><td align="center" colspan="1"><br></td><td align="center" colspan="1"><font size="2">{$summ}</font></td></tr>
                <tr><td align="left" colspan="2" rowspan="2"><font size="2">Плательщик:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td align="center"><font size="1">Пеня:</font></td><td align="center"><br></td></tr>
                <tr align="center"><td><font size="1">Всего:</font></td><td><br></td></tr>
                </tbody></table>
        </td>
</tr>
<tr>
        <td align="right" width="200" height="255" valign="top"><font size="2"><br><br><p>Квитанция</p><br><br><br><br><br><br><br><br><br><br><br>
        <font size="1"><p>Кассир</p></font></font></td>
             <td align="right" width="100" height="255" valign="middle">
                <font size="-1"></font><p align="center"><font size="-1">ИНН {$inn} КПП {$kpp}<br><u>{$recipient}</u><br><font size="1">получатель платежа</font></font>
            </p><table cellspacing="0" border="1" cellpadding="3" width="370"><tbody><tr><td align="center" colspan="4" height="10" valign="center"><font size="2"><p>Расчетный счет: {$account}&nbsp;&nbsp;БИК: {$bik}</p></font></td></tr>
                <tr><td align="center" colspan="4" height="10" valign="center"><font size="2"><p>Кор. сч.: {$korAccount}&nbsp;&nbsp;&nbsp;&nbsp;</p></font></td></tr>
                <tr><td colspan="4"><font size="2"></font><center><font size="2">{$surname} {$name} {$patronymic}<br>{$adress}</font><center><font size="2"><center><font size="1">плательщик (ФИО, адрес)</font></center></font></center></center></td></tr>
                <tr><td align="center" colspan="2"><font size="2">Вид платежа</font></td><td align="center"><font size="2">Дата</font></td><td align="center"><font size="2">Сумма</font></td></tr>
                <tr><td align="center" colspan="2"><font size="1">{$payment}</font></td><td align="center" colspan="1"><br></td><td align="center" colspan="1"><font size="2">{$summ}</font></td></tr>
                <tr><td align="left" colspan="2" rowspan="2"><font size="2">Плательщик:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td align="center"><font size="1">Пеня:</font></td><td align="center"><br></td></tr>
                <tr align="center"><td><font size="1">Всего:</font></td><td><br></td></tr>
                </tbody></table>
        </td>
</tr>
</tbody></table>

<input id="button" type="button" value="Распечатать" onclick="window.print();">