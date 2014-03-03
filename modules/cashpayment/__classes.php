<?php
/**
 * O_o
 *
 * @author kvmang
 */
class cashpayment
{
    
	public static $paymentName = 'Наличными';
	public static $paymentComment = 'Вам будет выписан счет для оплаты заказа';
	public static $paymentButtonName = 'Счет';
	
	public function start($array){
		return cashpayment::bill($array);
	}
	
	public function end(){
	
	}
	
	public static function bill($array){
		global $smarty, $sql;
		
		$smarty->assign('recipient', $array['recipient']);
		$smarty->assign('recipientAdr', $array['recipientAdr']);
		$smarty->assign('recipientTel', $array['recipientTel']);
		$smarty->assign('inn', $array['recipientINN']);	
		$smarty->assign('kpp', $array['recipientKPP']);	
		$smarty->assign('account', $array['account']);
		$smarty->assign('korAccount', $array['korAccount']);		
		$smarty->assign('bik', $array['bik']);
		
		$smarty->assign('name', $array['name']);
		$smarty->assign('surname', $array['surname']);
		$smarty->assign('patronymic', $array['patronymic']);
			if (isset($array['adress']))
		$smarty->assign('adress', $array['adress']);
		if (isset($array['summ']))
		$smarty->assign('summ', $array['summ']);
		$smarty->assign('payment', $array['payment']);		
		
		
		$smarty->assign('orderData', $array['order_data']);					
		$smarty->assign('cost', $array['order_data']['cost']);		
		$smarty->assign('sname', $array['sname']);
		$smarty->assign('sprice', $array['sprice']);
		
		$smarty->assign('total', $array['order_data']['total']);
		
		$smarty->assign('date', $array['date']);
		$smarty->assign('billnum', $array['billnum']);
		
		global $smarty, $sql;
		return $smarty->fetch(api::setTemplate('modules/orders/index/cash.bill.tpl'));		
	}
	
	function __construct()
    {
        

    }
}

?>
