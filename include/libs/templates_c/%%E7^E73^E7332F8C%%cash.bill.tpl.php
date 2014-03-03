<?php /* Smarty version 2.6.16, created on 2013-10-23 16:05:30
         compiled from ru/modules/orders/index/cash.bill.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/orders/index/cash.bill.tpl', 26, false),array('function', 'math', 'ru/modules/orders/index/cash.bill.tpl', 53, false),)), $this); ?>
<table style="font-size:12px;" width="570" style="border:0px;">


<tr>
	<td><u> ООО «НЕРПА»	</u></td>

</tr>

<tr>
	<td>	Адрес: 664003, г.Иркутск, ул Советская, 27-24  Тел/факс: 8( 3952)75-75-37, 20-44-19</td>
</tr>
</table>


<br>
<br>





<table cellspacing="0" border="0" cellpadding="3" width="570" style="font-size:12px;">
	<tbody>
		
		<tr>
			<td align="center" colspan="2"><strong><font size="3">СЧЕТ № <?php echo $this->_tpl_vars['billnum']; ?>
 от <?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</strong></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="10%">Плательщик:</td>
			<td align="left"><?php echo $this->_tpl_vars['surname']; ?>
 <?php echo $this->_tpl_vars['name']; ?>
 <?php echo $this->_tpl_vars['patronymic']; ?>
</td>
		</tr>
		<tr>
			<td>Грузополучатель:</td>
			<td align="left"><?php echo $this->_tpl_vars['surname']; ?>
 <?php echo $this->_tpl_vars['name']; ?>
 <?php echo $this->_tpl_vars['patronymic']; ?>
</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td colspan="2">
				<table style="font-size:12px;" cellspacing="0" border="1" cellpadding="2" width="100%">
					<tr>
							<td>№</td>
							<td>Наименование товара</td>
							<td>Еденица измерения</td>
							<td>Количество</td>
							<td>Цена</td>
							<td>Сумма</td>
					</tr>
					<?php $_from = $this->_tpl_vars['orderData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<?php if (is_int ( $this->_tpl_vars['key'] )): ?>
						<tr>
							<td><?php echo smarty_function_math(array('equation' => ($this->_tpl_vars['key'])."+1"), $this);?>
</td>
							<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
							<td>шт.</td>
							<td><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>
							<td nowrap><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
							<td nowrap><?php echo $this->_tpl_vars['item']['total']; ?>
</td>
						</tr>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php if ($this->_tpl_vars['sprice'] != '0.00'): ?>
						<tr>
							<td></td>
							<td>Доставка <?php echo $this->_tpl_vars['sname']; ?>
</td>
							<td>шт.</td>
							<td>1</td>
							<td><?php echo $this->_tpl_vars['sprice']; ?>
</td>
							<td><?php echo $this->_tpl_vars['sprice']; ?>
</td>
						</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['sprice'] != '0.00'): ?>	
						<tr>
							<td colspan="4" align="right"><strong>Итого:</strong></td>
							<td colspan="2"><?php echo $this->_tpl_vars['cost']; ?>
</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Без налога НДС:</strong></td>
							<td colspan="2">-</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Всего к оплате:</strong></td>
							<td colspan="2"><?php echo $this->_tpl_vars['cost']; ?>
</td>
						</tr>
					<?php else: ?>
						<tr>
							<td colspan="4" align="right"><strong>Итого:</strong></td>
							<td colspan="2"><?php echo $this->_tpl_vars['total']; ?>
</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Без налога НДС:</strong></td>
							<td colspan="2">-</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Всего к оплате:</strong></td>
							<td colspan="2"><?php echo $this->_tpl_vars['total']; ?>
</td>
						</tr>					
					<?php endif; ?>
					
				</table>
			</td>
		<tr><td>&nbsp;</td></tr>
	</tbody>
</table>
<input id="button" type="button" value="Распечатать" onclick="window.print();">