<?php
namespace AppBundle\Service;

use AppBundle\Entity\Faucet;
use Doctrine\ORM\EntityManagerInterface;

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

}