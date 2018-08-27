<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	var $parameters;
	public function __construct()
	{
		parent::__construct();

		// Libería Web Service
		$this->load->library("Nusoap_library");

		// Definición de parámetros
		$login = '6dd490faf9cb87a9862245da41170ff2';
		$tranKey = '024h1IlD';
		$seed = date('c');
		$tranKey = sha1($seed.$tranKey, false);

		$this->parameters = array(
			'auth'=> array(
				'login' 	=> $login,
				'tranKey' 	=> $tranKey,
				'seed' 		=> $seed
			)
		);
	}

	public function register()
	{
		$data = array(
			'transactionID' => $this->input->get_post('transactionID', TRUE),
			'transactionState' => $this->input->get_post('transactionState', TRUE),
			'redirectURL' => $this->input->get_post('redirectURL', TRUE)
		);
		$this->load->view('register', $data);
	}

	public function index()
	{
		$WS = new nusoap_client('https://test.placetopay.com/soap/pse/?wsdl', true);
		$error = '';

		if ($this->input->post())
		{
			$this->createTransaction();
			$transaction = $WS->call('createTransaction', $this->parameters);
			if (isset($transaction['faultcode']))
				$error = $transaction['faultstring'];
			else
				if ($transaction)
					header('Location: '.$transaction['createTransactionResult']['bankURL']);
		}

		$bancos = $WS->call('getBankList', $this->parameters);
		$data = array();
		$data['bancos'] = array();
		$data['error'] = '';
		$data['bancos'] = $bancos['getBankListResult']['item'];
		$data['error'] = $error;

		$this->load->view('main', $data);
	}

	private function createTransaction()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$agente = $_SERVER['HTTP_USER_AGENT'];
		$bankCode = $this->input->get_post('banco', TRUE);
		$bankInterface = $this->input->get_post('interface', TRUE);

		$personInfo = array(
			'documentType'	=> 'CC',
			'document'		=> '1037587156',
			'firstName'		=> 'David',
			'lastName'		=> 'Guerra',
			'company'		=> 'particular',
			'emailAddress'	=> 'rem5742@gmail.com',
			'address'		=> 'Envigado',
			'city'			=> 'Envigado',
			'province'		=> 'Antioqui',
			'country'		=> 'CO',
			'phone'			=> '5975768',
			'mobile'		=> '3187556701',
			'postalCode'	=> '055420'
		);
		$this->parameters['transaction'] = array(
			'bankCode'		=> $bankCode,
			'bankInterface'	=> $bankInterface,
			'returnURL'		=> 'http://localhost/place2pay/',
			'reference'		=> '123456789',
			'description'	=> 'pago de pruebas',
			'language'		=> 'EN',
			'currency'		=> 'COP',
			'totalAmount'	=> 100000,
			'taxAmount'		=> 20000,
			'devolutionBase'=> 0,
			'tipAmount'		=> 0,
			'payer' 		=> $personInfo,
			'buyer'			=> $personInfo,
			'shipping'		=> $personInfo,
			'ipAddress'		=> $ip,
			'userAgent'		=> $agente,
			'additionalData'=> array()
		);
	}
}