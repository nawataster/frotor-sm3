<?php
namespace AppBundle\Entity\DQL;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class Rand extends FunctionNode{

//______________________________________________________________________________

	public function parse(\Doctrine\ORM\Query\Parser $parser){
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
//______________________________________________________________________________

	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker){
		return 'RAND()';
	}
//______________________________________________________________________________
}// Class end
