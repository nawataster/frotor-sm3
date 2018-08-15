<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FaucetService;
use DateTime;
// use Symfony\Component\HttpFoundation\Response;
// use Psr\Log\LoggerInterface;
use AppBundle\Entity\Faucet;
use AppBundle\Form\FaucetForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller{

	private static function getLastPayInfo( $faucet ){
		$dt_now		= new DateTime(date('Y-m-d'));
		return $faucet->getUpdated()->format('d-m-Y').' ('.$dt_now->diff( $faucet->getUpdated() )->days.')';
	}
//______________________________________________________________________________

	public function indexAction( Request $request ) {
		$fsrv	= $this->container->get(FaucetService::class);
		$faucet	= $fsrv->getFirstReadyFaucet();
		$count	= $fsrv->faucetCount();

		return $this->render('pages/index.html.twig', [
			'faucet'	=> $faucet,
			'faucet_id'	=> $faucet->getId(),
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
		if( $id < 0 )
			return;

		$fsrv	= $this->container->get(FaucetService::class);

		$faucet	= (bool)$id
			? $this->getDoctrine()->getRepository(Faucet::class)->find( $id )
			: $this->getDoctrine()->getRepository(Faucet::class)->getNullFaucet();

		$faucet	= $fsrv->prepareFaucet( $faucet );

		$form	= $this->createForm( FaucetForm::class, $faucet );
		$form->handleRequest($request);

		$message	= '';
		if( $form->isSubmitted() && $form->isValid() ){
			$form_data = $form->getData();
			$message	= $fsrv->saveFaucet( $faucet->getId(), $form_data )
				? 'Successfully saved.'
				: 'Problem while saveing.';
		}

		$faucet_id	= $faucet->getId();

		return $this->render('pages/dashboard.html.twig', [
			'form'		=> $form->createView(),
			'faucet'	=> $faucet,
			'faucet_id'	=> ($faucet_id ?? 0),
			'message'	=> $message
		]);
	}
//______________________________________________________________________________

	public function deleteAction( Request $request, $id ){
		$this->container->get(FaucetService::class)->removeFaucet( $id );
		return $this->redirectToRoute('showindex');
	}
//______________________________________________________________________________

	public function postIndexAction(  Request $request, $action  ){
		$fsrv	= $this->container->get(FaucetService::class);
		$post	= $request->request->all();


		switch( $action ){

			case 'next':
				if( !$fsrv->updateUntil( $post ) ){
					$json_ret	= [ 'success' => false, 'Message' => 'Faild updating until value.', 'post' => $post ];
					return new JsonResponse($json_ret);
				}
				break;

			case 'reset':
				if( !$fsrv->resetAll( $post ) ){
					$json_ret	= [ 'success' => false, 'Message' => 'Faild resetting all faucetse.', 'post' => $post ];
					return new JsonResponse($json_ret);
				}
				break;

			default:
				$json_ret	= [ 'success' => false, 'Message' => 'Undefined action: '.$action ];
				return new JsonResponse($json_ret);
		}

		$json_ret	= [ 'success' => true, 'post' => $post ];
		return new JsonResponse($json_ret);
	}
//______________________________________________________________________________

}//class end
