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


		return $this->render('pages/index.html.twig', [
        ]);
	}
//______________________________________________________________________________

}//class end
