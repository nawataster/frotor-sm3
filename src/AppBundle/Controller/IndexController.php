<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FaucetService;
use DateTime;
// use Symfony\Component\HttpFoundation\Response;
// use Psr\Log\LoggerInterface;

class IndexController extends Controller{

	private static function getLastPayInfo( $faucet ){
		$updated_mk	= strtotime($faucet->getUpdated()->format('Y-m-d H:i:s'));
		$dt_now		= new DateTime(date('Y-m-d'));
		$dt_payed	= new DateTime(date( 'Y-m-d', $updated_mk ));
		return date( 'd-m-Y', $updated_mk ).' ('.$dt_now->diff( $dt_payed )->days.')';
	}
//______________________________________________________________________________

	public function indexAction( Request $request ) {
		$fsrv	= $this->container->get(FaucetService::class);
		$faucet	= $fsrv->getFirstReadyFaucet();
		$count	= $fsrv->faucetCount();

		return $this->render('pages/index.html.twig', [
			'faucet'	=> $faucet,
			'last_pay'	=> self::getLastPayInfo( $faucet ),
	    	'order'		=> 'desc',
	    	'count'		=> $count
        ]);
	}
//______________________________________________________________________________

	public function dummyAction( Request $request ) {

		return $this->render('pages/dummy.html.twig', []);
	}
//______________________________________________________________________________

	public function dashboardAction( Request $request, $id ){

		return $this->render('pages/dashboard.html.twig', []);
	}
//______________________________________________________________________________

}//class end
