<?php

// Плагин "Новости"
//
// Версия 1.0 Beta,
// (C) Oskorbin Sergey, 2006
//
// Зависимисть: модуль "Новости" (3.0 И Выше)
//
// Парметры:
//      LIMIT: (INT);
//      Количество новостей для отображения, по уполнчанию -1;
//
//      ORDER: (название столбца в БД);
//      Сортировать по столбцу, по умолнчанию: `date`
//
//      ORDERBY: (DESC|ASK);
//      Тип сортировки данных в таблцице, по умолчанию DESC
//
//      GROUP: (INT);
//      Группа для отображения

include_once("include/classes/class.tree.php");

class plugin_showMenu {

    protected $pluginParams = array();
    protected $return = "";

    public function start() {
        global $sql, $lang, $smarty;
        $sqlMax = clone $sql;

        $sql->query("SELECT `item_id` as 'id', `title` as 'title', `parent_id` as 'parent', `uri` as 'url', `order` as 'order' FROM `#__#menu_items` WHERE `menu_id` = '" . $this->pluginParams['menuid'] . "' && `item_id` > '0' ORDER by `order` ASC");


        $itemArray = array();

        while ($row = $sql->next_row()) {
            $itemArray[$row['id']] = $row;
        }



        $treeItem = new Tree();
        foreach ($itemArray as $item) {
            $treeItem->addItem(
                    $item['id'], $item['parent'], array(
                'title' => $item['title'],
                'url' => $item['url'],
                    ), $item['order']
            );
        }



        $childs = $this->createNode($treeItem, 0);
        $smarty->assign('tree', $childs);
        $smarty->assign('dir', $_SERVER['DOCUMENT_ROOT']);
        $template = $smarty->fetch(api::setTemplate("plugins/showMenu/index.tpl"));
        return $template;
    }

    private function createNode($tree, $parent) {

        $s = array();
        if (!$tree->hasChilds($parent))
            return '';
        $childs = $tree->getChilds($parent);
        foreach ($childs as $k => $v) {
            $s[$v['id']]['id'] = $v['id'];
            $s[$v['id']]['parent'] = $v['parent'];
            $s[$v['id']]['data']['title'] = $v['data']['title'];
            $s[$v['id']]['data']['url'] = $v['data']['url'];
            if (count($tree->getChilds($v['id'])) > 0) {
                if ($tree->hasChilds($v['id'])) {
                    $s[$v['id']]['children'] = $this->createNode($tree, $v['id']);
                }
            }
        }
        return $s;
    }

    function __construct($params) {
        $this->pluginParams = api::setPluginParams($params);
    }

}

?>
