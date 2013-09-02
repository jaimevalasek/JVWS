<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace JVWS\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;

class IndexController extends AbstractActionController
{
	private $_WSDL_URI = "http://localhost2/services";
    
    public function indexAction()
    {
    	if (isset($_GET['wsdl'])) {
    		$this->handleWSDL();
    	} else {
    		$this->handleSOAP();
    	}
    	
    	$view = new ViewModel();
    	$view->setTerminal(true);
    	exit;
    }
    
    public function produtosAction() {
    	if (isset($_GET['wsdl'])) {
    		$this->handleWSDL('/index/produtos', '\JVWS\Service\Produto');
    	} else {
    		$this->handleSOAP('/index/produtos?wsdl', '\JVWS\Service\Produto');
    	}
    	 
    	$view = new ViewModel();
    	$view->setTerminal(true);
    	exit;
    }
    
    public function servicosAction() {
    	if (isset($_GET['wsdl'])) {
    		$this->handleWSDL('/index/servicos', '\JVWS\Service\Servico');
    	} else {
    		$this->handleSOAP('/index/servicos?wsdl', '\JVWS\Service\Servico');
    	}
    	 
    	$view = new ViewModel();
    	$view->setTerminal(true);
    	exit;
    }
    
    public function handleWSDL($local, $class) {
    	$autoDiscover = new AutoDiscover();
    	$autoDiscover->setClass($class);
    	$autoDiscover->setUri($this->_WSDL_URI . $local);
    	$autoDiscover->setServiceName('zf2teste');
    	
    	$wsdl = $autoDiscover->generate();
		$wsdl = $wsdl->toDomDocument();
		echo $wsdl->saveXML();
    }
    
    public function handleSOAP($local, $class) {
    	$soap = new Server($this->_WSDL_URI . $local);
    	$soap->setClass($class);
    	$soap->handle();
    }
}
