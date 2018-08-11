<?php
namespace AppBundle\Service;

class FaucetService{


	public function __construct(){}

	public function getFirstReadyFaucet(){
		return (object)[
			'id'	=> 500,
			'info'	=> 'Dummy faucet name'
		];

	}
//______________________________________________________________________________

}