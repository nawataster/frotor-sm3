<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Faucet;
use DateTime;

class FaucetService{

	private $em;

	public function __construct( EntityManagerInterface $em ){
		$this->em	= $em;
	}
//______________________________________________________________________________

	private function getActiveFaucetsObj(){
		$qb = $this->em->createQueryBuilder();

		$qb->select('fct')->from('AppBundle\Entity\Faucet', 'fct')
			->where($qb->expr()->andX(
				$qb->expr()->gte('timestamp_diff( SECOND, fct.until, CURRENT_TIMESTAMP())', 0)
				,$qb->expr()->gte('timestamp_diff( SECOND, fct.banUntil, CURRENT_TIMESTAMP())', 0)
			)
		)
		;

		return $qb;
	}
//______________________________________________________________________________

	public function getFirstReadyFaucet(){

		$qb		= $this->getActiveFaucetsObj()
			->setMaxResults( 1 )
			->addSelect('RAND() as HIDDEN rand')
			->addOrderBy('fct.priority', 'DESC')
			->addOrderBy('rand', 'ASC')
			;

		$query	= $qb->getQuery();
		$res	= $query->getResult();
		return $res[0];
	}
//______________________________________________________________________________

	public function faucetCount(){
		return [
			'n_act' => count($this->getActiveFaucetsObj()->getQuery()->getResult()),
			'n_all' => count($this->em->getRepository('AppBundle\Entity\Faucet')->findAll())];
	}
//______________________________________________________________________________

	private static function applyTimeUnit( $faucet ){
    	$faucet->duration = $faucet->duration / 60;
    	return $faucet;
	}
//______________________________________________________________________________

	public function find( $id ){

// 		$faucet = $this->em
// 			->getRepository(Faucet::class)
// 			->find( $id );

// 		$faucet->url= $faucet->url.($faucet->query != '' ? '?'.$faucet->query : '');



// 		$dt_now = new DateTime( date('Y-m-d') );
// 		$dt_ban = new DateTime( date('Y-m-d', strtotime($faucet->getBanUntil)) );
// 		$diff	= $dt_now->diff( $dt_ban, FALSE );
// 		$faucet->bandays	= $diff->invert ? 0 : $diff->d;



// 		$updated_mk	= strtotime($faucet->getUpdated()->format('Y-m-d H:i:s'));
// 		$dt_now		= new DateTime(date('Y-m-d'));
// 		$dt_payed	= new DateTime(date( 'Y-m-d', $updated_mk ));
// 		return date( 'd-m-Y', $updated_mk ).' ('.$dt_now->diff( $dt_payed )->days.')';



// 		return self::applyTimeUnit( $faucet );

	}
//______________________________________________________________________________
}