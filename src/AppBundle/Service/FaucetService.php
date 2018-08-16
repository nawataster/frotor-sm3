<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Faucet;
use DateTime;
use Psr\Log\LoggerInterface;

class FaucetService{

	private $em;
	private $lg;

	public function __construct( EntityManagerInterface $em, LoggerInterface $logger ){
		$this->em	= $em;
		$this->lg	= $logger;
	}
//______________________________________________________________________________

	public function updateUntil( $data ){
		$faucet	= $this->em->getRepository(Faucet::class)->find( $data['id'] );

		if( !$faucet->is_debt ){
			$updated	= new DateTime();
			$faucet->setUpdated( $updated );
		}

		$until	= new DateTime(date('Y-m-d H:i:s', strtotime( '+'.$data['cduration'].' minute' )));
		$faucet->setUntil( $until );

		$faucet->setPriority( $data['priority'] );

		$this->em->flush();

		return true;
	}
//______________________________________________________________________________

	public function resetAll( $data ){






//     	$result	= Faucet::where('until','>',date('Y-m-d H:i:s'))->update( ['until' => date('Y-m-d H:i:s')] );
//     	return Response::json( ['message'=>'All faucets reset to current date!!!', 'id' => $data['id']] );








// 		$faucet	= $this->em->getRepository(Faucet::class)->find( $data['id'] );

// 		if( !$faucet->is_debt ){
// 			$updated	= new DateTime();
// 			$faucet->setUpdated( $updated );
// 		}

// 		$until	= new DateTime(date('Y-m-d H:i:s', strtotime( '+'.$data['cduration'].' minute' )));
// 		$faucet->setUntil( $until );

// 		$faucet->setPriority( $data['priority'] );

// 		$this->em->flush();

		return true;
	}
//______________________________________________________________________________

}// Class end