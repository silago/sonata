<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: fckeditor.php
 * 	This is the integration file for PHP.
 * 	
 * 	It defines the FCKeditor class that can be used to create editor
 * 	instances in PHP pages on server side.
 * 
 * Version:  2.0 RC3
 * Modified: 2005-03-02 12:38:37
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

class FCKeditor
{
	var $InstanceName ;
	var $BasePath ;
	var $Width ;
	var $Height ;
	var $ToolbarSet ;
	var $Value ;
	var $Config ;

	function FCKeditor( $instanceName )
	{
		$this->InstanceName	= $instanceName ;
		$this->BasePath		= '/include/fckeditor/' ;
		$this->Width		= '100%' ;
		$this->Height		= '200' ;
		$this->ToolbarSet	= 'Default' ;
		$this->Value		= '' ;

		$this->Config		= array() ;
		$this->Config['SkinPath'] = 'skins/silver/';
		
		$basePath="/include/fckeditor/";
		$s_LoggedInUser_IP=$_SERVER['REMOTE_ADDR'];
		$s_LoggedInUser="admin";
		$sharedKey="->Shared_K3y-F0R*5enD1NG^auth3nt1caT10n'Info/To\FILE,Brow5er--!";
		$myData=time()."|^SEP^|".$s_LoggedInUser_IP."|^SEP^|".$s_LoggedInUser; $test=$myData.$sharedKey; $myData.="|^SEP^|".md5($myData.$sharedKey);
		$myData_hex=''; for ($i=0;$i<strlen($myData);$i++) $myData_hex.=(strlen(dechex(ord($myData[$i])))<2)? "0".dechex(ord($myData[$i])): dechex(ord($myData[$i]));
		$fbPath="${basePath}editor/filemanager/browser/default";
		$eq=urlencode("="); $amp=urlencode("&");
		$this->Config['ImageBrowserURL']="$fbPath/browser.html?Type${eq}Image${amp}ExtraParams${eq}${myData_hex}${amp}Connector${eq}$fbPath/connectors/php/connector.php";
		$this->Config['LinkBrowserURL']="$fbPath/browser.html?ExtraParams${eq}${myData_hex}${amp}Connector${eq}$fbPath/connectors/php/connector.php";
		
	}

	function Create()
	{
		echo $this->CreateHtml() ;
	}
	
	function CreateHtml()
	{
		$HtmlValue = htmlspecialchars( $this->Value ) ;

		$Html = '<div>' ;
		
		if ( $this->IsCompatible() )
		{
			$Link = "{$this->BasePath}editor/fckeditor.html?InstanceName={$this->InstanceName}" ;
			
			if ( $this->ToolbarSet != '' )
				$Link .= "&Toolbar={$this->ToolbarSet}" ;

			// Render the linked hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\">" ;

			// Render the configurations hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}___Config\" value=\"" . $this->GetConfigFieldString() . "\">" ;

			// Render the editor IFRAME.
			$Html .= "<iframe id=\"{$this->InstanceName}___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"no\" scrolling=\"no\"></iframe>" ;
		}
		else
		{
			if ( strpos( $this->Width, '%' ) === false )
				$WidthCSS = $this->Width . 'px' ;
			else
				$WidthCSS = $this->Width ;

			if ( strpos( $this->Height, '%' ) === false )
				$HeightCSS = $this->Height . 'px' ;
			else
				$HeightCSS = $this->Height ;

			$Html .= "<textarea name=\"{$this->InstanceName}\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\" wrap=\"virtual\">{$HtmlValue}</textarea>" ;
		}

		$Html .= '</div>' ;
		
		return $Html ;
	}

	function IsCompatible()
	{
			if ( isset( $_SERVER ) ) {
		$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
	}
	else {
		global $HTTP_SERVER_VARS ;
		if ( isset( $HTTP_SERVER_VARS ) ) {
			$sAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ;
		}
		else {
			global $HTTP_USER_AGENT ;
			$sAgent = $HTTP_USER_AGENT ;
		}
	}

	if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') === false && strpos($sAgent, 'Opera') === false )
	{
		$iVersion = (float)substr($sAgent, strpos($sAgent, 'MSIE') + 5, 3) ;
		return ($iVersion >= 5.5) ;
	}
	else if ( strpos($sAgent, 'Gecko/') !== false )
	{
		$iVersion = (int)substr($sAgent, strpos($sAgent, 'Gecko/') + 6, 8) ;
		return ($iVersion >= 20030210) ;
	}
	else if ( strpos($sAgent, 'Opera/') !== false )
	{
		$fVersion = (float)substr($sAgent, strpos($sAgent, 'Opera/') + 6, 4) ;
		return ($fVersion >= 9.5) ;
	}
	else if ( preg_match( "|AppleWebKit/(\d+)|i", $sAgent, $matches ) )
	{
		$iVersion = $matches[1] ;
		return ( $matches[1] >= 522 ) ;
	}
	else
		return false ;
	}

	function GetConfigFieldString()
	{
		$sParams = '' ;
		$bFirst = true ;

		foreach ( $this->Config as $sKey => $sValue )
		{
			if ( $bFirst == false )
				$sParams .= '&' ;
			else
				$bFirst = false ;
			
			if ( $sValue === true )
				$sParams .= $this->EncodeConfig( $sKey ) . '=true' ;
			else if ( $sValue === false )
				$sParams .= $this->EncodeConfig( $sKey ) . '=false' ;
			else
				$sParams .= $this->EncodeConfig( $sKey ) . '=' . $this->EncodeConfig( $sValue ) ;
		}
		
		return $sParams ;
	}

	function EncodeConfig( $valueToEncode )
	{
		$chars = array( 
			'&' => '%26', 
			'=' => '%3D', 
			'"' => '%22' ) ;

		return strtr( $valueToEncode,  $chars ) ;
	}
	
	function __construct($instanceName) {
		$this->FCKeditor( $instanceName );
	}
}

?>