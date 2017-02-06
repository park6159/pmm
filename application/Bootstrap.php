<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array(
									'namespace' => '',
									'basePath' => APPLICATION_PATH));	
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Dashboard_');	
		$autoloader->registerNamespace('PHPExcel_');
		$autoloader->registerNamespace('PHPExcel');

		return $moduleLoader;
	}
	
	protected function _initControllerPlugins()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$frontController->registerPlugin(new Dashboard_Controller_Plugin_SessionHandler());
	}
	
}

