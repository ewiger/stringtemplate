<?php
// $ANTLR 3.2 Sep 23, 2009 12:02:23 src/php/Antlr/StringTemplate/Language/Group.g 2010-09-19 15:10:26

namespace Antlr\StringTemplate\Language;



use Antlr\Runtime\IntStream;
use Antlr\Runtime\DFA;
use Antlr\Runtime\Parser;
use Antlr\Runtime\Lexer;
use Antlr\Runtime\CommonToken;
use Antlr\Runtime\Set;
use Antlr\Runtime\Token;
use Antlr\Runtime\CharStream;
use Antlr\Runtime\RecognizerSharedState;
use Antlr\Runtime\ParserRuleReturnScope;

use Antlr\Runtime\EarlyExitException;
use Antlr\Runtime\FailedPredicateException;
use Antlr\Runtime\MismatchedRangeException;
use Antlr\Runtime\MismatchedSetException;
use Antlr\Runtime\MismatchedTokenException;
use Antlr\Runtime\NoViableAltException;
use Antlr\Runtime\RecognitionException;
use Antlr\Runtime\UnwantedtokenException;


function GroupLexer_DFA7_static(){
    $eot = "\x1\xff\x3\x4\xb\xff\x1\x1b\x7\xff\x3\x4\x4\xff\x6\x4\x1\x27" .
    "\x2\x4\x1\xff\x3\x4\x1\x2d\x1\x4\x1\xff\x1\x4\x1\x30\x1\xff";
    $eof = "\x31\xff";
    $min = "\x1\x9\x1\x72\x1\x6d\x1\x65\xb\xff\x1\x3a\x5\xff\x1\x2a\x1\xff" .
    "\x1\x6f\x1\x70\x1\x66\x4\xff\x1\x75\x1\x6c\x1\x61\x1\x70\x1\x65\x1\x75" .
    "\x1\x2d\x1\x6d\x1\x6c\x1\xff\x1\x65\x1\x74\x1\x6e\x1\x2d\x1\x74\x1\xff" .
    "\x1\x73\x1\x2d\x1\xff";
    $max = "\x1\x7b\x1\x72\x1\x6d\x1\x65\xb\xff\x1\x3a\x5\xff\x1\x2f\x1\xff" .
    "\x1\x6f\x1\x70\x1\x66\x4\xff\x1\x75\x1\x6c\x1\x61\x1\x70\x1\x65\x1\x75" .
    "\x1\x7a\x1\x6d\x1\x6c\x1\xff\x1\x65\x1\x74\x1\x6e\x1\x7a\x1\x74\x1\xff" .
    "\x1\x73\x1\x7a\x1\xff";
    $accept = "\x4\xff\x1\x4\x1\x5\x1\x6\x1\x7\x1\x8\x1\x9\x1\xa\x1\xb\x1" .
    "\xc\x1\xd\x1\xe\x1\xff\x1\x10\x1\x12\x1\x13\x1\x14\x1\x15\x1\xff\x1" .
    "\x18\x3\xff\x1\xf\x1\x11\x1\x16\x1\x17\x9\xff\x1\x1\x5\xff\x1\x3\x2" .
    "\xff\x1\x2";
    $special = "\x31\xff";
    $transitionS = array(
        "\x2\x16\x2\xff\x1\x16\x12\xff\x1\x16\x1\xff\x1\x5\x5\xff\x1\x9\x1" .
        "\xa\x1\x11\x1\x12\x1\xd\x1\xff\x1\xe\x1\x15\xa\xff\x1\xf\x1\x10" .
        "\x1\x6\x1\x13\x1\xff\x1\x14\x1\x8\x1a\x4\x1\xb\x1\xff\x1\xc\x1\xff" .
        "\x1\x4\x1\xff\x3\x4\x1\x3\x2\x4\x1\x1\x1\x4\x1\x2\x11\x4\x1\x7",
        "\x1\x17",
        "\x1\x18",
        "\x1\x19",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "\x1\x1a",
        "",
        "",
        "",
        "",
        "",
        "\x1\x1c\x4\xff\x1\x1d",
        "",
        "\x1\x1e",
        "\x1\x1f",
        "\x1\x20",
        "",
        "",
        "",
        "",
        "\x1\x21",
        "\x1\x22",
        "\x1\x23",
        "\x1\x24",
        "\x1\x25",
        "\x1\x26",
        "\x1\x4\x2\xff\xa\x4\x7\xff\x1a\x4\x4\xff\x1\x4\x1\xff\x1a\x4",
        "\x1\x28",
        "\x1\x29",
        "",
        "\x1\x2a",
        "\x1\x2b",
        "\x1\x2c",
        "\x1\x4\x2\xff\xa\x4\x7\xff\x1a\x4\x4\xff\x1\x4\x1\xff\x1a\x4",
        "\x1\x2e",
        "",
        "\x1\x2f",
        "\x1\x4\x2\xff\xa\x4\x7\xff\x1a\x4\x4\xff\x1\x4\x1\xff\x1a\x4",
        ""
    );

    $arr = array();
    $arr['eot'] = DFA::unpackRLE($eot);
    $arr['eof'] = DFA::unpackRLE($eof);
    $arr['min'] = DFA::unpackRLE($min, true);
    $arr['max'] = DFA::unpackRLE($max, true);
    $arr['accept'] = DFA::unpackRLE($accept);
    $arr['special'] = DFA::unpackRLE($special);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackRLE($transitionS[$i]);
    }
    return $arr;
}

class GroupLexer_DFA7 extends DFA {

    private static $DFA = null;

    public function __construct($recognizer) {
        if (self::$DFA === null) {
            self::$DFA = GroupLexer_DFA7_static();
        }

        $this->recognizer = $recognizer;
        $this->decisionNumber = 7;
        $this->eot = self::$DFA['eot'];
        $this->eof = self::$DFA['eof'];
        $this->min = self::$DFA['min'];
        $this->max = self::$DFA['max'];
        $this->accept = self::$DFA['accept'];
        $this->special = self::$DFA['special'];
        $this->transition = self::$DFA['transition'];
    }
    public function getDescription() {
        return "1:1: Tokens : ( T__25 | T__26 | T__27 | ID | STRING | BIGSTRING | ANONYMOUS_TEMPLATE | AT | LPAREN | RPAREN | LBRACK | RBRACK | COMMA | DOT | DEFINED_TO_BE | SEMI | COLON | STAR | PLUS | ASSIGN | OPTIONAL | COMMENT | LINE_COMMENT | WS );";
    }
}
 

class GroupLexer extends Lexer {
    const T_RBRACK=18;
    const T_LBRACK=17;
    const T_STAR=19;
    const T_T__27=27;
    const T_T__26=26;
    const T_LINE_COMMENT=23;
    const T_T__25=25;
    const T_ANONYMOUS_TEMPLATE=16;
    const T_ID=4;
    const T_EOF=-1;
    const T_SEMI=7;
    const T_LPAREN=10;
    const T_OPTIONAL=21;
    const T_COLON=5;
    const T_AT=8;
    const T_RPAREN=11;
    const T_WS=24;
    const T_DEFINED_TO_BE=12;
    const T_COMMA=6;
    const T_ASSIGN=15;
    const T_BIGSTRING=14;
    const T_PLUS=20;
    const T_DOT=9;
    const T_COMMENT=22;
    const T_STRING=13;

    // delegates
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);


            $this->dfa7 = new GroupLexer_DFA7($this);
    }
    function getGrammarFileName() { return "src/php/Antlr/StringTemplate/Language/Group.g"; }

    // $ANTLR start "T__25"
    function mT__25(){
        try {
            $_type = GroupLexer::T_T__25;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("group"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T__25"

    // $ANTLR start "T__26"
    function mT__26(){
        try {
            $_type = GroupLexer::T_T__26;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("implements"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T__26"

    // $ANTLR start "T__27"
    function mT__27(){
        try {
            $_type = GroupLexer::T_T__27;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("default"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T__27"

    // $ANTLR start "ID"
    function mID(){
        try {
            $_type = GroupLexer::T_ID;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            if ( ($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122')) ) {
                $this->input->consume();

            } else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            // src/php/Antlr/StringTemplate/Language/Group.g
            //loop1:
            do {
                $alt1=2;
                $LA1_0 = $this->input->LA(1);

                if ( ($LA1_0==$this->getToken('45')||($LA1_0>=$this->getToken('48') && $LA1_0<=$this->getToken('57'))||($LA1_0>=$this->getToken('65') && $LA1_0<=$this->getToken('90'))||$LA1_0==$this->getToken('95')||($LA1_0>=$this->getToken('97') && $LA1_0<=$this->getToken('122'))) ) {
                    $alt1=1;
                }


                switch ($alt1) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    if ( $this->input->LA(1)==$this->getToken('45')||($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122')) ) {
            	        $this->input->consume();

            	    } else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop1;
                }
            } while (true);


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ID"

    // $ANTLR start "STRING"
    function mSTRING(){
        try {
            $_type = GroupLexer::T_STRING;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(34); 
            // src/php/Antlr/StringTemplate/Language/Group.g
            //loop2:
            do {
                $alt2=5;
                $LA2_0 = $this->input->LA(1);

                if ( ($LA2_0==$this->getToken('92')) ) {
                    $LA2_2 = $this->input->LA(2);

                    if ( ($LA2_2==$this->getToken('34')) ) {
                        $alt2=1;
                    }
                    else if ( (($LA2_2>=$this->getToken('0') && $LA2_2<=$this->getToken('33'))||($LA2_2>=$this->getToken('35') && $LA2_2<=$this->getToken('65535'))) ) {
                        $alt2=2;
                    }


                }
                else if ( ($LA2_0==$this->getToken('10')) ) {
                    $alt2=3;
                }
                else if ( (($LA2_0>=$this->getToken('0') && $LA2_0<=$this->getToken('9'))||($LA2_0>=$this->getToken('11') && $LA2_0<=$this->getToken('33'))||($LA2_0>=$this->getToken('35') && $LA2_0<=$this->getToken('91'))||($LA2_0>=$this->getToken('93') && $LA2_0<=$this->getToken('65535'))) ) {
                    $alt2=4;
                }


                switch ($alt2) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->matchChar(92); 
            	    $this->matchChar(34); 

            	    }
            	    break;
            	case 2 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->matchChar(92); 
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('33'))||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    } else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;
            	case 3 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {

            	      			$msg = "\\n in string";
            	          		$exception = new NoViableAltException("", 0, 0, input);
            	      			ErrorManager::syntaxError(ErrorType::SYNTAX_ERROR, $this->getSourceName(), $exception, $msg);
            	      			
            	    $this->matchChar(10); 

            	    }
            	    break;
            	case 4 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('9'))||($this->input->LA(1)>=$this->getToken('11') && $this->input->LA(1)<=$this->getToken('33'))||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    } else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop2;
                }
            } while (true);

            $this->matchChar(34); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STRING"

    // $ANTLR start "BIGSTRING"
    function mBIGSTRING(){
        try {
            $_type = GroupLexer::T_BIGSTRING;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("<<"); 

            // src/php/Antlr/StringTemplate/Language/Group.g
            //loop3:
            do {
                $alt3=4;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('62')) ) {
                    $LA3_1 = $this->input->LA(2);

                    if ( ($LA3_1==$this->getToken('62')) ) {
                        $alt3=4;
                    }
                    else if ( (($LA3_1>=$this->getToken('0') && $LA3_1<=$this->getToken('61'))||($LA3_1>=$this->getToken('63') && $LA3_1<=$this->getToken('65535'))) ) {
                        $alt3=3;
                    }


                }
                else if ( ($LA3_0==$this->getToken('92')) ) {
                    $LA3_2 = $this->input->LA(2);

                    if ( ($LA3_2==$this->getToken('62')) ) {
                        $alt3=1;
                    }
                    else if ( (($LA3_2>=$this->getToken('0') && $LA3_2<=$this->getToken('61'))||($LA3_2>=$this->getToken('63') && $LA3_2<=$this->getToken('65535'))) ) {
                        $alt3=2;
                    }


                }
                else if ( (($LA3_0>=$this->getToken('0') && $LA3_0<=$this->getToken('61'))||($LA3_0>=$this->getToken('63') && $LA3_0<=$this->getToken('91'))||($LA3_0>=$this->getToken('93') && $LA3_0<=$this->getToken('65535'))) ) {
                    $alt3=3;
                }


                switch ($alt3) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->matchChar(92); 
            	    $this->matchChar(62); 

            	    }
            	    break;
            	case 2 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->matchChar(92); 
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('61'))||($this->input->LA(1)>=$this->getToken('63') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    } else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;
            	case 3 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    } else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop3;
                }
            } while (true);

            $this->matchString(">>"); 


                          $txt = str_replace("\\\\>",">",$this->getText());
              		    $this->setText($txt);
              		

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "BIGSTRING"

    // $ANTLR start "ANONYMOUS_TEMPLATE"
    function mANONYMOUS_TEMPLATE(){
        try {
            $_type = GroupLexer::T_ANONYMOUS_TEMPLATE;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(123); 
            $this->matchChar(125); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ANONYMOUS_TEMPLATE"

    // $ANTLR start "AT"
    function mAT(){
        try {
            $_type = GroupLexer::T_AT;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(64); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "AT"

    // $ANTLR start "LPAREN"
    function mLPAREN(){
        try {
            $_type = GroupLexer::T_LPAREN;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(40); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LPAREN"

    // $ANTLR start "RPAREN"
    function mRPAREN(){
        try {
            $_type = GroupLexer::T_RPAREN;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(41); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "RPAREN"

    // $ANTLR start "LBRACK"
    function mLBRACK(){
        try {
            $_type = GroupLexer::T_LBRACK;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(91); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LBRACK"

    // $ANTLR start "RBRACK"
    function mRBRACK(){
        try {
            $_type = GroupLexer::T_RBRACK;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(93); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "RBRACK"

    // $ANTLR start "COMMA"
    function mCOMMA(){
        try {
            $_type = GroupLexer::T_COMMA;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(44); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "COMMA"

    // $ANTLR start "DOT"
    function mDOT(){
        try {
            $_type = GroupLexer::T_DOT;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(46); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DOT"

    // $ANTLR start "DEFINED_TO_BE"
    function mDEFINED_TO_BE(){
        try {
            $_type = GroupLexer::T_DEFINED_TO_BE;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("::="); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DEFINED_TO_BE"

    // $ANTLR start "SEMI"
    function mSEMI(){
        try {
            $_type = GroupLexer::T_SEMI;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(59); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "SEMI"

    // $ANTLR start "COLON"
    function mCOLON(){
        try {
            $_type = GroupLexer::T_COLON;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(58); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "COLON"

    // $ANTLR start "STAR"
    function mSTAR(){
        try {
            $_type = GroupLexer::T_STAR;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(42); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STAR"

    // $ANTLR start "PLUS"
    function mPLUS(){
        try {
            $_type = GroupLexer::T_PLUS;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(43); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PLUS"

    // $ANTLR start "ASSIGN"
    function mASSIGN(){
        try {
            $_type = GroupLexer::T_ASSIGN;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(61); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ASSIGN"

    // $ANTLR start "OPTIONAL"
    function mOPTIONAL(){
        try {
            $_type = GroupLexer::T_OPTIONAL;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchChar(63); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OPTIONAL"

    // $ANTLR start "COMMENT"
    function mCOMMENT(){
        try {
            $_type = GroupLexer::T_COMMENT;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("/*"); 

            // src/php/Antlr/StringTemplate/Language/Group.g
            //loop4:
            do {
                $alt4=2;
                $LA4_0 = $this->input->LA(1);

                if ( ($LA4_0==$this->getToken('42')) ) {
                    $LA4_1 = $this->input->LA(2);

                    if ( ($LA4_1==$this->getToken('47')) ) {
                        $alt4=2;
                    }
                    else if ( (($LA4_1>=$this->getToken('0') && $LA4_1<=$this->getToken('46'))||($LA4_1>=$this->getToken('48') && $LA4_1<=$this->getToken('65535'))) ) {
                        $alt4=1;
                    }


                }
                else if ( (($LA4_0>=$this->getToken('0') && $LA4_0<=$this->getToken('41'))||($LA4_0>=$this->getToken('43') && $LA4_0<=$this->getToken('65535'))) ) {
                    $alt4=1;
                }


                switch ($alt4) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->matchAny(); 

            	    }
            	    break;

            	default :
            	    break 2;//loop4;
                }
            } while (true);

            $this->matchString("*/"); 

              skip();

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "COMMENT"

    // $ANTLR start "LINE_COMMENT"
    function mLINE_COMMENT(){
        try {
            $_type = GroupLexer::T_LINE_COMMENT;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->matchString("//"); 

            // src/php/Antlr/StringTemplate/Language/Group.g
            //loop5:
            do {
                $alt5=2;
                $LA5_0 = $this->input->LA(1);

                if ( (($LA5_0>=$this->getToken('0') && $LA5_0<=$this->getToken('9'))||($LA5_0>=$this->getToken('11') && $LA5_0<=$this->getToken('12'))||($LA5_0>=$this->getToken('14') && $LA5_0<=$this->getToken('65535'))) ) {
                    $alt5=1;
                }


                switch ($alt5) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('9'))||($this->input->LA(1)>=$this->getToken('11') && $this->input->LA(1)<=$this->getToken('12'))||($this->input->LA(1)>=$this->getToken('14') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    } else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop5;
                }
            } while (true);

            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt6=2;
            $LA6_0 = $this->input->LA(1);

            if ( ($LA6_0==$this->getToken('13')) ) {
                $alt6=1;
            }
            switch ($alt6) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->matchChar(13); 

                    }
                    break;

            }

            $this->matchChar(10); 
              skip();

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LINE_COMMENT"

    // $ANTLR start "WS"
    function mWS(){
        try {
            $_type = GroupLexer::T_WS;
            $_channel = GroupLexer::DEFAULT_TOKEN_CHANNEL;
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            if ( ($this->input->LA(1)>=$this->getToken('9') && $this->input->LA(1)<=$this->getToken('10'))||$this->input->LA(1)==$this->getToken('13')||$this->input->LA(1)==$this->getToken('32') ) {
                $this->input->consume();

            } else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

              skip();

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "WS"

    function mTokens(){
        // src/php/Antlr/StringTemplate/Language/Group.g
        $alt7=24;
        $alt7 = $this->dfa7->predict($this->input);
        switch ($alt7) {
            case 1 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mT__25(); 

                }
                break;
            case 2 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mT__26(); 

                }
                break;
            case 3 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mT__27(); 

                }
                break;
            case 4 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mID(); 

                }
                break;
            case 5 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mSTRING(); 

                }
                break;
            case 6 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mBIGSTRING(); 

                }
                break;
            case 7 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mANONYMOUS_TEMPLATE(); 

                }
                break;
            case 8 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mAT(); 

                }
                break;
            case 9 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mLPAREN(); 

                }
                break;
            case 10 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mRPAREN(); 

                }
                break;
            case 11 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mLBRACK(); 

                }
                break;
            case 12 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mRBRACK(); 

                }
                break;
            case 13 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mCOMMA(); 

                }
                break;
            case 14 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mDOT(); 

                }
                break;
            case 15 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mDEFINED_TO_BE(); 

                }
                break;
            case 16 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mSEMI(); 

                }
                break;
            case 17 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mCOLON(); 

                }
                break;
            case 18 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mSTAR(); 

                }
                break;
            case 19 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mPLUS(); 

                }
                break;
            case 20 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mASSIGN(); 

                }
                break;
            case 21 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mOPTIONAL(); 

                }
                break;
            case 22 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mCOMMENT(); 

                }
                break;
            case 23 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mLINE_COMMENT(); 

                }
                break;
            case 24 :
                // src/php/Antlr/StringTemplate/Language/Group.g
                {
                $this->mWS(); 

                }
                break;

        }

    }



}
?>