<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FaucetService;
// use Symfony\Component\HttpFoundation\Response;
// use Psr\Log\LoggerInterface;

class IndexController extends Controller{

	public function indexAction( Request $request ) {

		$fsrv	= $this->container->get(FaucetService::class);

		$faucet	= $fsrv->getFirstReadyFaucet();

		$count	= $fsrv->faucetCount();

		return $this->render('pages/index.html.twig', [
			'faucet'	=> $faucet,
			'last_pay'	=> '11-11-2011',
	    	'order'		=> 'desc',
	    	'count'		=> $count
        ]);
	}
//______________________________________________________________________________

}//class end
