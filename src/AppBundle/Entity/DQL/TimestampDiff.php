<?php
namespace AppBundle\Entity\DQL;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class TimestampDiff extends FunctionNode{

	public $dtUnit = null;
	public $dtPar1 = null;
	public $dtPar2 = null;
//______________________________________________________________________________

	private function parseTimeStampUnit( $parser ){
		$units	= ['MICROSECOND', 'SECOND', 'MINUTE', 'HOUR', 'DAY', 'WEEK', 'MONTH', 'QUARTER', 'YEAR'];
		$lexer	= $parser->getLexer();
		$token	= $lexer->lookahead;
		$lexer->moveNext();

		if( !in_array($token['value'], $units) ){
			$str	= implode("' | '", $units);
			$parser->semanticalError("Expected: '$str'. But '".$token['value']."' was got.");
			return false;
		}

		return $token['value'];
	}
//______________________________________________________________________________

	public function parse(\Doctrine\ORM\Query\Parser $parser){
		$parser->match(Lexer::T_IDENTIFIER);					// (1)
		$parser->match(Lexer::T_OPEN_PARENTHESIS);				// (2)
		$this->dtUnit = $this->parseTimeStampUnit( $parser );	// (3)
		$parser->match(Lexer::T_COMMA);							// (4)
		$this->dtPar1 = $parser->ArithmeticPrimary();			// (5)
		$parser->match(Lexer::T_COMMA);							// (6)
		$this->dtPar2 = $parser->ArithmeticPrimary();			// (7)
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);				// (8)
	}
//______________________________________________________________________________

	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker){
		return 'TIMESTAMPDIFF( ' .
			$this->dtUnit . ', ' .
			$this->dtPar1->dispatch($sqlWalker) . ', ' .
			$this->dtPar2->dispatch($sqlWalker) .
		')';
	}
//______________________________________________________________________________
}// Class end
