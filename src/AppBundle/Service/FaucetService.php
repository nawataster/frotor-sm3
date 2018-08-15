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

	public function prepareFaucet( $faucet ){
		$url	= $faucet->getUrl().($faucet->getQuery() != '' ? '?'.$faucet->getQuery() : '');
		$faucet->setUrl( $url );

		$dt_now			= new DateTime(date('Y-m-d'));
		$dt_ban 		= $faucet->getBanUntil();
		$diff			= $dt_now->diff( $dt_ban, FALSE );
		$faucet->bandays= $diff->invert ? 0 : $diff->d;

		return self::applyTimeUnit( $faucet );;
	}
//______________________________________________________________________________

    private static function prepareUrl( $form_data ){
    	$url	= $form_data->getUrl();

    	$query	= parse_url( $url, PHP_URL_QUERY );
		$url	= parse_url( $url, PHP_URL_SCHEME ).'://'.parse_url( $url, PHP_URL_HOST ).parse_url( $url, PHP_URL_PATH );

		$form_data->setUrl( $url );
		$form_data->setQuery( $query );

    	return $form_data;
    }
//______________________________________________________________________________

	public function saveFaucet( $id, $form_data ){
		$form_data	= self::prepareUrl( $form_data );

		$faucet = (bool)$id
			? $this->em->getRepository(Faucet::class)->find( $id )
			: $this->getNullFaucet();

		$faucet->setUrl( $form_data->getUrl() );
		$faucet->setQuery( $form_data->getQuery() );
		$faucet->setInfo( $form_data->getInfo() );
		$faucet->setPriority( $form_data->getPriority() );
		$faucet->setDuration( $form_data->getDuration() * 60 );

		!(bool)$id ? $this->em->persist($faucet):null;
		$this->em->flush();

		return true;
	}
//______________________________________________________________________________

	public function getNullFaucet(){
		$faucet	= new Faucet();

		$faucet->setUrl('');
		$faucet->setDuration( 1800 );

		$faucet->setUpdated( new DateTime(date('Y-m-d H:i:s')) );
		$faucet->setUntil( new DateTime(date('Y-m-d H:i:s')) );
		$faucet->setBanUntil( new DateTime(date('Y-m-d H:i:s', strtotime( '-1 day' ))) );

		$faucet->setPriority( 1 );
		$faucet->setIsDebt( false );

		return $faucet;
	}
//______________________________________________________________________________

	public function removeFaucet( $id ){
		$faucet	= $this->em->getRepository(Faucet::class)->find( $id );
		$this->em->remove( $faucet );
		$this->em->flush();
	}
//______________________________________________________________________________

}// Class end