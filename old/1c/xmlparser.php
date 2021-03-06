<?php
function owner($parent) // импорт сведений о продавце(владельце)
	{
		global $owner;
		foreach($parent->xpath("./Классификатор/Владелец") as $owner_data)
			{
				$owner[]=array(
					'title'=>$owner_data->Наименование,
					'inn'=>$owner_data->ИНН,
					'kpp'=>$owner_data->КПП,
					'present'=>$owner_data->ЮридическийАдрес->Представление,
					'rcount'=>$owner_data->РасчетныеСчета->РасчетныйСчет->НомерСчета,
                    'korr'=>$owner_data->РасчетныеСчета->РасчетныйСчет->Банк->СчетКорреспондентский,
                    'bank'=>$owner_data->РасчетныеСчета->РасчетныйСчет->Банк->Наименование,
                    'bik'=>$owner_data->РасчетныеСчета->РасчетныйСчет->Банк->БИК
					);
			}
	}
function pricetype($parent) // импорт типов цен
	{
		global $types;
		foreach ($parent->xpath("./ПакетПредложений/ТипыЦен/ТипЦены") as $ptype)
			{
				$types[]= array (
					'id'=> $ptype->Ид,
					'title'=> substr((string)$ptype->Наименование, 0)
					);
			}
	}
function itemprice($parent) // импорт цен товаров
	{
      global $price;

	  foreach ($parent->xpath("./ПакетПредложений/Предложения/Предложение") as $item) {
			$return[]=array('item_id'=>(string)$item->Ид,
				'remains'=>(string)$item->Количество);
			foreach ($item->Цены[0]->Цена as $element) {
				$price[]=array('item_id'=>(string)$item->Ид,
					'price'=>(string)$element->ЦенаЗаЕдиницу,
					'price_id'=>(string)$element->ИдТипаЦены,
					'remains'=>(string)$item->Количество);
			}
		}
	}

// импорт свойств товаров
function item_prop($parent)
	{
		global $item_prop;
		global $value_prop;
		foreach ($parent->xpath("./Классификатор/Свойства/Свойство") as $i_prop)
			{
				$item_prop[] = array(
					'id'=> $i_prop->Ид,
					'name'=> $i_prop->Наименование);

				foreach($i_prop->ТипыЗначений->ТипЗначений->ВариантыЗначений->ВариантЗначения as $val_prop)
					{
						$value_prop[] = array(
							'id'=> $val_prop->Ид,
							'name'=> $val_prop->Значение);
					}
			}

	}

Function items($parent) // импорт товаров
	{
		global $items;
		foreach ($parent->xpath("./Каталог/Товары/Товар") as $tovar)
			{
				$items[] = array(
					'id'=> $tovar->Ид,
					'articul'=> $tovar->Артикул,
					'title'=> $tovar->Наименование,
					'base_ed'=> $tovar->БазоваяЕдиница,
					'smalltext'=> $tovar->ПолноеНаименование,
					'group_id'=> $tovar->Группы->Ид,
					'descript'=> $tovar->Описание,
					'tax_name'=> $tovar->СтавкиНалогов->СтавкаНалога->Наименование,
					'tax'=> $tovar->СтавкиНалогов->СтавкаНалога->Ставка,
					'image'=> array(),    // Картинка,
					'userfiles'=> array(), // пользовательские файлы
					'props'=> array()  // свойства товара
                    );
					$last=count($items)-1;
			//		foreach($tovar->ЗначенияРеквизитов[0]->ЗначениеРеквизита as $more) {
			//		if ((string)$more->Наименование=="Полное наименование") $items[$last]['smalltext']=(string)$more->Значение; }
					if (count($tovar->Картинка)>0) {
					foreach ($tovar->Картинка as $uimg)
						{
						 $items[$last][image][] = array( 'idesc'=> $uimg->attributes()->Описание,
					 	 								 'ifname'=> $uimg);
						}
					}
					if (count($tovar->Файл)>0) {
					foreach ($tovar->Файл as $ufls)
						{
						 $items[$last][userfiles][] = array( 'fdesc'=> $ufls->attributes()->Описание,
					 	 									 'fname'=> $ufls);
						}
					}
					if (count($tovar->ЗначенияСвойств)>0) {
					foreach ($tovar->ЗначенияСвойств->ЗначенияСвойства as $iprops)
						{
						 $items[$last][props][] = array( 'prop_id'=> $iprops->Ид,
					 	 								 'prop_val_id'=> $iprops->ИдЗначения);
						}
					}
			}
	}
/*
function brand($parent) // импорт производителей
	{
		global $maker;
		$position=0;
		foreach ($parent->xpath("./Классификатор/Производители/Производитель") as $brands)
			{
				$maker[]= array (
					'id'=> $brands->Ид,
					'title'=> $brands->Наименование,
					'descript'=> $brands->Описание,
					'show'=> $brands->ПоказыватьНаСайте,
					'image'=>$brands->Картинка,
					'position'=> $position);
				$position++;
			}
	}
*/
function xmltree($parent,&$key) // импорт групп
 {
	global $groups;
	$level=count($parent->xpath("./Группа/ancestor::*[name()='Группы']"));
	$parents=$parent->xpath("./parent::*");
	$parent_id=(string)$parents[0]->Ид;
	foreach ($parent->Группа as $group) {
		if ($level=='1') {$parent_id='0';}
		$groups[]=array('id'=>(string)$group->Ид,
			'ownerId'=>$parent_id,
			'title'=>substr((string)$group->Наименование, 0),
			'position'=>$key,
			'level'=>$level,
			'lkey'=>$key,
			'rkey'=>0);
		$key++;
		if (count($group->xpath("Группы/Группа"))>0) {
			xmltree($group->Группы[0],$key);
		} else {
			$groups[count($groups)-1]['rkey']=$key;
			$key++;
			$siblings[0]=$group;
			while (count($siblings[0]->xpath("./following-sibling::*"))==0) {
				$siblings=$siblings[0]->xpath("./parent::*");
				for($pos=count($groups)-1;$pos>=0;$pos--) {
					if ($groups[$pos]['id']==(string)$siblings[0]->Ид) {
						$groups[$pos]['rkey']=$key;
						$key++;
						break;
					}
				}
			}

		}

	}

}

function orders($parent)
      {
        global $documents;
		global $agents;
		global $content;
		foreach($parent->xpath("./Документ") as $item) {
			$documents[]=array(
				'id'=>(string)$item->Ид,
				'operation'=>(string)$item->ХозОперация,
				'role'=> (string)$item->Роль,
				'docnumber'=>(string)$item->Номер,
				'docdate'=>(string)$item->Дата,
				'doctime'=>(string)$item->Время,
				'paydate'=> (string)$item->СрокПлатежа,
				'currency'=>(string)$item->Валюта,
				'rate'=>(string)$item->Курс,
				'total'=>(string)$item->Сумма,
				'comment'=>(string)$item->Комментарий,
				// значения реквизитов
				'1cnum'=>"",
				'1cdate'=>"",
				'deleted'=>"",
				'transfer'=>"",
				'1cpaynum'=>"",
				'1cstorenum'=>"",
				'1cstoredate'=>"",
				'1cpaydate'=>"",
				'status'=>"",
				'docosnov'=>"",
				'dateindoc'=>"");

			foreach($item->Контрагенты[0]->Контрагент as $a) {
				$agents[]=array(
					'doc_id'=>(string)$item->Ид,
					'agent_id'=>(string)$a->Ид,
					'name_ru'=>(string)$a->Наименование,
				    'official_name'=>(string)$a->ОфициальноеНаименование,
				    'price_type'=>(string)$a->ТипЦен,
                    'inn'=>(string)$a->ИНН,
                    'kpp'=>(string)$a->КПП,
                    'agent_role'=>(string)$a->Роль);
			}

			foreach($item->xpath("./Товары/Товар") as $c) {
				$content[]=array(
					'doc_id'=>(string)$item->Ид,
					'item_id'=>(string)$c->Ид,
					'itemname'=>(string)$c->Наименование,
					'articul'=>(string)$c->Артикул,
					'measure'=>(string)$c->БазоваяЕдиница,
					'ed_izm'=>(string)$c->Единица,
					'pcs'=>(double)$c->Количество,
					'price'=>(double)$c->ЦенаЗаЕдиницу,
					'summ'=>(double)$c->Сумма);
			}

			$last=count($documents)-1;

			foreach($item->ЗначенияРеквизитов[0]->ЗначениеРеквизита as $more) {
				if ((string)$more->Наименование=="Номер по 1С") $documents[$last]['1cnum']=(string)$more->Значение;
				if ((string)$more->Наименование=="Дата по 1С") $documents[$last]['1cdate']=(string)$more->Значение;
				if ((string)$more->Наименование=="ПометкаУдаления") $documents[$last]['deleted']=(string)$more->Значение;
				if ((string)$more->Наименование=="Проведен") $documents[$last]['transfer']=(string)$more->Значение;
				if ((string)$more->Наименование=="Номер оплаты по 1С") $documents[$last]['1cpaynum']=(string)$more->Значение;
				if ((string)$more->Наименование=="Номер отгрузки по 1С") $documents[$last]['1cstorenum']=(string)$more->Значение;
				if ((string)$more->Наименование=="Дата отгрузки по 1С") $documents[$last]['1cstoredate']=(string)$more->Значение;
				if ((string)$more->Наименование=="Дата оплаты по 1С") $documents[$last]['1cpaydate']=(string)$more->Значение;
				if ((string)$more->Наименование=="СтатусЗаказа") $documents[$last]['status']=(string)$more->Значение;
				if ((string)$more->Наименование=="ДокументОснование") $documents[$last]['docosnov']=(string)$more->Значение;
				if ((string)$more->Наименование=="ДатаВходящегоДокумента") $documents[$last]['dateindoc']=(string)$more->Значение;
			}
		}
     }

?>
