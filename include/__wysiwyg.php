<?php
class FCKeditor
{

    public $InstanceName;
    public $BasePath;
    public $Width;
    public $Height;
    public $ToolbarSet;
    public $Value;
    public $Config;

    public function __construct($instanceName)
    {
        $this->InstanceName = $instanceName;
        $this->BasePath = '';
        $this->Width = '100%';
        $this->Height = '200';
        $this->ToolbarSet = 'Default';
        $this->Value = '';

        $this->Config = array();
    }

    public function Create()
    {
        echo $this->CreateHtml();
    }

    /**
     * TODO: preview
     */

    public function CreateHtml()
    {
        $script_include = '<script type="text/javascript" src="/include/ext/tiny_mce/tiny_mce.js"></script>';
        $script_init = '
            <script type="text/javascript">
                    tinyMCE.init({
                        language: "ru",
                        mode : "specific_textareas",
                        editor_selector : "tinymce",
                        theme : "advanced",
                        plugins : "codemagic, inlinepopups,pagebreak,style,table,advimage,advlink,iespell,preview,media,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
                        theme_advanced_buttons1 : "code,codemagic,|,cut,copy,paste,pastetext,pasteword,|,link,unlink,anchor,|,image, media,|,tablecontrols",
                        theme_advanced_buttons2 : "bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,formatselect,fontsizeselect",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,
                        width: "' . $this->Width . '",
                        height: "' . $this->Height . '",
                        dialog_type : "modal",
                        document_base_url: "/",
                        relative_urls : false,
                        file_browser_callback : "elFinderBrowser"
                    });

                    function elFinderBrowser (field_name, url, type, win) {
                        var elfinder_url = "/include/ext/elfinder/elfinder.html";
                        tinyMCE.activeEditor.windowManager.open({
                            file: elfinder_url,
                            title: "elFinder 2.0",
                            width: 900,
                            height: 650,
                            resizable: "no",
                            inline: "yes",
                            popup_css: false,
                            close_previous: "no"
                        }, {
                            window: win,
                            input: field_name
                        });

                        return false;
                    }
            </script>';
        $area = '
		    <textarea
		        name="' . $this->InstanceName . '"
		        width="' . $this->Width . '"
		        height="' . $this->Height . '"
		        class="tinymce"
		    >
		    ' . $this->Value . '
		    </textarea>';

        return $script_include . $script_init . $area;
    }
}

?>