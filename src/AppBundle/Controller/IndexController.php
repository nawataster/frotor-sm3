<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller{


	public function indexAction( Request $request, $num ) {

// 	    return $app['twig']->render('index.twig', []);


		$number = $num;

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );

	}
//______________________________________________________________________________

}//class end

//Commit before amend.


// 	$faucet = new \App\Model\Faucet();
//     $faucet->setUrl(rand(1, 11000).'-test/url/tst.tst');
//     $faucet->setQuery(rand(1, 11000).'-test/query/tst.qqq');
//     $faucet->setInfo(rand(1, 11000).'-test/INFO/tst.inf');
// //     $faucet->setDuration(10);
//     $faucet->setUntil( new \DateTime('2018-10-01 00:00:01') );

//     $entityManager = $app['orm.em'];
//     $entityManager->persist( $faucet );
//     $entityManager->flush();
