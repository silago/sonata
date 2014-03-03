<?php
class navigation {
         // Attributes
         var $navigationMenuArray = array();

        // Class operations
         function setMainPage($string, $ref = "") {
                 if (empty($ref)) {
                         $ref="/";
                         }
                 $this->navigationMenuArray[0]['title'] = $string;
                 $this->navigationMenuArray[0]['ref']   = $ref;
                 }

        function add($title, $ref) {
                global $API;
                 if (!isset($this->navigationMenuArray) || !is_array($this->navigationMenuArray)) {
                         $this->setMainPage($API['main']['config']['defaultMainPageNavigationTitle']['value']);
                         }
                $nextArrayOffset=count($this->navigationMenuArray);
                 $this->navigationMenuArray[$nextArrayOffset]['title'] = $title;
                 $this->navigationMenuArray[$nextArrayOffset]['ref']   = $ref;
                return true;
                }

         function get() {
                 global $lang;
                 $return="";
                 if (!isset($this->navigationMenuArray) || !is_array($this->navigationMenuArray)) {
                         $this->setMainPage(api::getConfig("main", "api", "mainPageInNavigation"));
                         }

                 foreach($this->navigationMenuArray as $key=>$value){
                 $nextOffset=0;
                 if (isset($this->navigationMenuArray[$nextOffset])) {
                 $return.="<a class=\"navigation\" href=\"".$this->navigationMenuArray[$key]['ref']."?lang=".$lang."\">".$this->navigationMenuArray[$key]['title']."</a>";
                         $nextOffset=$key+1;
                         
                                 $return.="<span class=\"navigation\">&nbsp;>>&nbsp;</span>";
                                 }
                         }
                 return $return;
                 }


         // Core function to set class attribute (PHP4/5 support only)
         function set_attribute($value) {
                 if (!isset($navigationMenuArray) || !is_array($navigationMenuArray)) {
                         $this->navigationMenuArray=array();
                         }
                 return $value;
                 }

        }


?>