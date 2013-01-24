<?php
/** 
 *-------------------------------------------------------------------------
 * T3 Framework for Joomla!
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2013 JoomlArt.com, Ltd. All Rights Reserved.
 * License - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Authors:  JoomlArt, JoomlaBamboo 
 * If you want to be come co-authors of this project, please follow our 
 * guidelines at http://t3-framework.org/contribute
 * ------------------------------------------------------------------------
 */

if (!defined('_JEXEC')) {
    // no direct access
	define('_JEXEC', 1);
	defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
	$path = dirname(dirname(dirname(dirname(__FILE__))));
	define('JPATH_BASE', $path);

	if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
        //Apache CGI
		$_SERVER['PHP_SELF'] = rtrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '/\\');
	} else {
        //Others
		$_SERVER['SCRIPT_NAME'] = rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/\\');
	}

	require_once (JPATH_BASE . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'defines.php');
	require_once (JPATH_BASE . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'framework.php');
	JDEBUG ? $_PROFILER->mark('afterLoad') : null;

	/**
	 * CREATE THE APPLICATION
	 *
	 * NOTE :
	 */
	$japp = JFactory::getApplication('administrator');

	/**
	 * INITIALISE THE APPLICATION
	 *
	 * NOTE :
	 */
	$japp->initialise(array('language' => $japp->getUserState('application.lang', 'lang')));
}

$user = JFactory::getUser();

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');


if(!$user->authorise('core.manage', 'com_templates')){
	die(json_encode(array(JText::_('NO_PERMISSION'))));
}


$helpcls = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fileconfig.php';
if(file_exists($helpcls))
include_once $helpcls;

$task = isset($_REQUEST['dptask']) ? $_REQUEST['dptask'] : '';
if ($task != '' && method_exists('JAFileConfig', $task)) {
	JAFileConfig::$task();
}