<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Psr\Log\LoggerInterface;

class IndexController extends Controller{

	public function indexAction( Request $request, $num ) {

		$number = $num;

		return $this->render('pages/index.html.twig', [
            'number' => $number,
			'base_dir'	=> 'Dummy-base-dir'
        ]);
	}
//______________________________________________________________________________

}//class end
