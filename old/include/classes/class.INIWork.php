<?php

/**
 * Работа с INI файлами 
 */
class INIWork {

    public $filename;
    public $arr = array ();

    /**
     * При инициализации можно сразу загрузить требуемый файл конфигурации
     */
    function __construct($file = false) {
        if ($file)
            $this->loadFromFile($file);
        
        defined('_BR_') || define('_BR_', "\n");
    }

    /**
     * Обертка для parse_ini_file. Загрузка данных во внутренний массив экземпляра класса
     */
    function initArray() {
        $this->arr = parse_ini_file($this->filename, true);
    }

    /**
     * Загрузка конфигурации из файла, возвращает true при успешном завершении операции.
     * 
     * @param String $file
     * @return boolean
     */
    function loadFromFile($file) {
        $result = true;
        $this->filename = $file;
        if (file_exists($file) && is_readable($file)) {
            $this->initArray();
        }
        else
            $result = false;
        return $result;
    }

    /**
     * Чтение значения заданного ключа из заданной секции. Также можно задать значение по умолчанию.
     * 
     * @param String $section
     * @param String $key
     * @param String $def
     * @return String
     */
    function read($section, $key, $def = '') {
        if (isset($this->arr[$section][$key])) {
            return $this->arr[$section][$key];
        } else
            return $def;
    }

    /**
     * Запись значения в заданный ключ заданной секции. Булевы значения преобразуются в 1(true) или 0(false)
     * 
     * @param String $section
     * @param String $key
     * @param String $value
     */
    function write($section, $key, $value) {
        if (is_bool($value))
            $value = $value ? 1 : 0;
        $this->arr[$section][$key] = $value;
    }

    /**
     * Удаление секции
     * 
     * @param String $section
     */
    function eraseSection($section) {
        if (isset($this->arr[$section]))
            unset($this->arr[$section]);
    }

    /**
     * Удаление ключа в заданной секции
     * 
     * @param String $section
     * @param String $key
     */
    function deleteKey($section, $key) {
        if (isset($this->arr[$section][$key]))
            unset($this->arr[$section][$key]);
    }

    /**           
     * @param mixed $array
     * @return Array
     */
    function readSections(&$array) {
        $array = array_keys($this->arr);
        return $array;
    }

    function readKeys($section, &$array) {
        if (isset($this->arr[$section])) {
            $array = array_keys($this->arr[$section]);
            return $array;
        }
        return array();
    }

    /**
     * Запись конфигурационных данных в файл
     * 
     * @return boolean
     */
    function updateFile() {
        $result = '';        

        foreach ($this->arr as $sname => $section) {
            $result .= '[' . $sname . ']' . _BR_ . _BR_;
            foreach ($section as $key => $value) {
                $result .= $key . ' = ' . $value . _BR_;
            }
            $result .= _BR_;
        }

		if (is_writeable ($this->filename)) {	// Проверка на наличие записи
			if (file_put_contents($this->filename, $result, FILE_APPEND)) { // Проверка на наличие пространства для записи (дисковая квота может закончиться)
				file_put_contents($this->filename, $result);				
			} else {
				
			}
		} else {
			
		}
        //file_put_contents($this->filename, $result);
        return true;
    }

    function __destruct() {
        //$this->updateFile();
    }

}

?>
