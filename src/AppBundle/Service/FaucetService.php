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
    	$duration = $faucet->getDuration() / 60;
    	$faucet->setDuration($duration);
    	return $faucet;
	}
//______________________________________________________________________________

	public function getFaucet( $id ){
		$faucet = $this->em->getRepository(Faucet::class)->find( $id );

		$url	= $faucet->getUrl().($faucet->getQuery() != '' ? '?'.$faucet->getQuery() : '');
		$faucet->setUrl( $url );

		$dt_now			= new DateTime(date('Y-m-d'));
		$dt_ban 		= $faucet->getBanUntil();
		$diff			= $dt_now->diff( $dt_ban, FALSE );
		$faucet->bandays= $diff->invert ? 0 : $diff->d;

		return self::applyTimeUnit( $faucet );;
	}
//______________________________________________________________________________
}