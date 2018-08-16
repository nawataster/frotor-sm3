<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
// use Symfony\Component\HttpFoundation\Response;
// use Psr\Log\LoggerInterface;
use AppBundle\Entity\Faucet;
use AppBundle\Form\FaucetForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;


class IndexController extends Controller{

	private $em;
	private $odb;

	public function __construct( EntityManagerInterface $em ){
		$this->em	= $em;
 		$this->odb	= $em->getRepository(Faucet::class);
	}
//______________________________________________________________________________

	private static function getLastPayInfo( $faucet ){
		$dt_now		= new DateTime(date('Y-m-d'));
		return $faucet->getUpdated()->format('d-m-Y').' ('.$dt_now->diff( $faucet->getUpdated() )->days.')';
	}
//______________________________________________________________________________

	public function indexAction( Request $request ) {

		$session = new Session(new NativeSessionStorage(), new AttributeBag());
		$action = $session->get('action', 'init');
		$session->clear();

		$faucet	= $this->odb->getFirstReadyFaucet();
		$count	= $this->odb->faucetCount();

		return $this->render('pages/index.html.twig', [
			'faucet'	=> $faucet,
			'faucet_id'	=> $faucet->getId(),
			'last_pay'	=> self::getLastPayInfo( $faucet ),
	    	'order'		=> 'desc',
	    	'count'		=> $count,
			'action'	=> $action
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

		$faucet	= (bool)$id
			? $this->odb->find( $id )
			: $this->odb->getNullFaucet();

		$faucet	= $this->odb->prepareFaucet( $faucet );

		$form	= $this->createForm( FaucetForm::class, $faucet );
		$form->handleRequest($request);

		$message	= '';
		if( $form->isSubmitted() && $form->isValid() ){
			$form_data = $form->getData();
			$message	= $this->odb->saveFaucet( $faucet->getId(), $form_data )
				? 'Data have been successfully saved.'
				: 'Data saving has been failed.';
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
		$this->odb->removeFaucet( $id );
		return $this->redirectToRoute('showindex');
	}
//______________________________________________________________________________

	public function postIndexAction(  Request $request, $action  ){
		$post	= $request->request->all();

		$session = new Session(new NativeSessionStorage(), new AttributeBag());
		$session->set('action', $action);

		switch( $action ){

			case 'next':
				if( !$this->odb->updateUntil( $post ) ){
					$json_ret	= [ 'success' => false, 'Message' => 'Faild updating until value.', 'post' => $post ];
					return new JsonResponse($json_ret);
				}
				break;

			case 'reset':
				if( $this->odb->resetAll( $post ) < 0 ){
					$json_ret	= [ 'success' => false, 'Message' => 'Faild resetting all faucetse.', 'post' => $post ];
					return new JsonResponse($json_ret);
				}
				break;

			case 'tomorrow':
				if( !$this->odb->updateUntilTomorrow( $post ) ){
					$json_ret	= [ 'success' => false, 'Message' => 'Faild apdating till tomorrow.', 'post' => $post ];
					return new JsonResponse($json_ret);
				}
				break;

			case 'save_duration':
				if( !$this->odb->updateDuration( $post ) ){
					$json_ret	= [ 'success' => false, 'Message' => 'Faild updating duration value.', 'post' => $post ];
					return new JsonResponse($json_ret);
				}
				break;

			default:
				$json_ret	= [ 'success' => false, 'Message' => 'Undefined action: '.$action ];
				return new JsonResponse($json_ret);
		}

		$post['action']	= $action;
		$json_ret	= [ 'success' => true, 'post' => $post, 'Message' => 'Operation successful.' ];
		return new JsonResponse($json_ret);
	}
//______________________________________________________________________________

}//class end
