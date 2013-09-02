<?php

namespace JVWS\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\Client;

class ClienteController extends AbstractActionController
{
	protected $_WSDL_URI = "http://localhost2/services";
	
	public function indexAction() {
		$localProduto = $this->_WSDL_URI . '/index/produtos?wsdl';
		$produto = new Client($localProduto);
		
		$localServico = $this->_WSDL_URI . '/index/servicos?wsdl';
		$servico = new Client($localServico);
		
		return new ViewModel(array(
			'produtos' => $produto->produtos(),
			'servicos' => $servico->servicos(),
		));
	}
}