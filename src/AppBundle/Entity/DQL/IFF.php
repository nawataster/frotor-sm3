<?php
namespace AppBundle\Entity\DQL;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class IFF extends FunctionNode{

	public $exp1 = null;
	public $exp2 = null;
	public $exp3 = null;
//______________________________________________________________________________

	public function parse(\Doctrine\ORM\Query\Parser $parser){
		$parser->match(Lexer::T_IDENTIFIER);			// (1)
		$parser->match(Lexer::T_OPEN_PARENTHESIS);		// (2)
		$this->exp1 = $parser->ConditionalExpression();	// (3)
		$parser->match(Lexer::T_COMMA);					// (4)
		$this->exp2 = $parser->ArithmeticPrimary();		// (5)
		$parser->match(Lexer::T_COMMA);					// (6)
		$this->exp3 = $parser->ArithmeticPrimary();		// (7)
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);		// (8)
	}
//______________________________________________________________________________

	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker){
		return 'IF( ' .
			$this->exp1->dispatch($sqlWalker) . ', ' .
			$this->exp2->dispatch($sqlWalker) . ', ' .
			$this->exp3->dispatch($sqlWalker).
        ')';
	}
//______________________________________________________________________________
}// Class end
