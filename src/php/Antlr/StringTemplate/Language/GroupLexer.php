<?php
// $ANTLR 3.2 Sep 23, 2009 12:02:23 Group.g 2010-06-20 00:50:44


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
function GroupLexer_DFA7_static(){
    $eotS =
        "\x1\xff\x3\x4\xb\xff\x1\x1b\x7\xff\x3\x4\x4\xff\x6\x4\x1\x27\x2".
    "\x4\x1\xff\x3\x4\x1\x2d\x1\x4\x1\xff\x1\x4\x1\x30\x1\xff";
    $eofS =
        "\x31\xff";
    $minS =
        "\x1\x9\x1\x72\x1\x6d\x1\x65\xb\xff\x1\x3a\x5\xff\x1\x2a\x1\xff\x1".
    "\x6f\x1\x70\x1\x66\x4\xff\x1\x75\x1\x6c\x1\x61\x1\x70\x1\x65\x1\x75".
    "\x1\x2d\x1\x6d\x1\x6c\x1\xff\x1\x65\x1\x74\x1\x6e\x1\x2d\x1\x74\x1\xff".
    "\x1\x73\x1\x2d\x1\xff";
    $maxS =
        "\x1\x7b\x1\x72\x1\x6d\x1\x65\xb\xff\x1\x3a\x5\xff\x1\x2f\x1\xff".
    "\x1\x6f\x1\x70\x1\x66\x4\xff\x1\x75\x1\x6c\x1\x61\x1\x70\x1\x65\x1\x75".
    "\x1\x7a\x1\x6d\x1\x6c\x1\xff\x1\x65\x1\x74\x1\x6e\x1\x7a\x1\x74\x1\xff".
    "\x1\x73\x1\x7a\x1\xff";
    $acceptS =
        "\x4\xff\x1\x4\x1\x5\x1\x6\x1\x7\x1\x8\x1\x9\x1\xa\x1\xb\x1\xc\x1".
    "\xd\x1\xe\x1\xff\x1\x10\x1\x12\x1\x13\x1\x14\x1\x15\x1\xff\x1\x18\x3".
    "\xff\x1\xf\x1\x11\x1\x16\x1\x17\x9\xff\x1\x1\x5\xff\x1\x3\x2\xff\x1".
    "\x2";
    $specialS =
        "\x31\xff}>";
    $transitionS = array(
        "\x2\x16\x2\xff\x1\x16\x12\xff\x1\x16\x1\xff\x1\x5\x5\xff\x1\x9\x1".
        "\xa\x1\x11\x1\x12\x1\xd\x1\xff\x1\xe\x1\x15\xa\xff\x1\xf\x1\x10".
        "\x1\x6\x1\x13\x1\xff\x1\x14\x1\x8\x1a\x4\x1\xb\x1\xff\x1\xc\x1\xff".
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
    $arr['eot'] = DFA::unpackEncodedString($eotS);
    $arr['eof'] = DFA::unpackEncodedString($eofS);
    $arr['min'] = DFA::unpackEncodedString($minS);
    $arr['max'] = DFA::unpackEncodedString($maxS);
    $arr['accept'] = DFA::unpackEncodedString($acceptS);
    $arr['special'] = DFA::unpackEncodedString($specialS);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackEncodedString($transitionS[$i]);
    }
    return $arr;
}
$GroupLexer_DFA7 = GroupLexer_DFA7_static();

class GroupLexer_DFA7 extends DFA {

    public function __construct($recognizer) {
        global $GroupLexer_DFA7;
        $DFA = $GroupLexer_DFA7;
        $this->recognizer = $recognizer;
        $this->decisionNumber = 7;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "1:1: Tokens : ( T__25 | T__26 | T__27 | ID | STRING | BIGSTRING | ANONYMOUS_TEMPLATE | AT | LPAREN | RPAREN | LBRACK | RBRACK | COMMA | DOT | DEFINED_TO_BE | SEMI | COLON | STAR | PLUS | ASSIGN | OPTIONAL | COMMENT | LINE_COMMENT | WS );";
    }
}
      

class GroupLexer extends AntlrLexer {
    static $RBRACK=18;
    static $LBRACK=17;
    static $STAR=19;
    static $T__27=27;
    static $T__26=26;
    static $LINE_COMMENT=23;
    static $T__25=25;
    static $ANONYMOUS_TEMPLATE=16;
    static $ID=4;
    static $EOF=-1;
    static $SEMI=7;
    static $LPAREN=10;
    static $OPTIONAL=21;
    static $COLON=5;
    static $AT=8;
    static $RPAREN=11;
    static $WS=24;
    static $DEFINED_TO_BE=12;
    static $COMMA=6;
    static $ASSIGN=15;
    static $BIGSTRING=14;
    static $PLUS=20;
    static $DOT=9;
    static $COMMENT=22;
    static $STRING=13;

    // delegates
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);

        
            $this->dfa7 = new GroupLexer_DFA7($this);
    }
    function getGrammarFileName() { return "Group.g"; }

    // $ANTLR start "T__25"
    function mT__25(){
        try {
            $_type = GroupLexer::$T__25;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:7:7: ( 'group' ) 
            // Group.g:7:9: 'group' 
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
            $_type = GroupLexer::$T__26;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:8:7: ( 'implements' ) 
            // Group.g:8:9: 'implements' 
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
            $_type = GroupLexer::$T__27;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:9:7: ( 'default' ) 
            // Group.g:9:9: 'default' 
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
            $_type = GroupLexer::$ID;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:242:5: ( ( 'a' .. 'z' | 'A' .. 'Z' | '_' ) ( 'a' .. 'z' | 'A' .. 'Z' | '0' .. '9' | '-' | '_' )* ) 
            // Group.g:242:7: ( 'a' .. 'z' | 'A' .. 'Z' | '_' ) ( 'a' .. 'z' | 'A' .. 'Z' | '0' .. '9' | '-' | '_' )* 
            {
            if ( ($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122')) ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            // Group.g:242:31: ( 'a' .. 'z' | 'A' .. 'Z' | '0' .. '9' | '-' | '_' )* 
            //loop1:
            do {
                $alt1=2;
                $LA1_0 = $this->input->LA(1);

                if ( ($LA1_0==$this->getToken('45')||($LA1_0>=$this->getToken('48') && $LA1_0<=$this->getToken('57'))||($LA1_0>=$this->getToken('65') && $LA1_0<=$this->getToken('90'))||$LA1_0==$this->getToken('95')||($LA1_0>=$this->getToken('97') && $LA1_0<=$this->getToken('122'))) ) {
                    $alt1=1;
                }


                switch ($alt1) {
            	case 1 :
            	    // Group.g: 
            	    {
            	    if ( $this->input->LA(1)==$this->getToken('45')||($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122')) ) {
            	        $this->input->consume();

            	    }
            	    else {
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
            $_type = GroupLexer::$STRING;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:246:2: ( '\"' ( '\\\\' '\"' | '\\\\' ~ '\"' | '\\n' | ~ ( '\\\\' | '\"' | '\\n' ) )* '\"' ) 
            // Group.g:246:4: '\"' ( '\\\\' '\"' | '\\\\' ~ '\"' | '\\n' | ~ ( '\\\\' | '\"' | '\\n' ) )* '\"' 
            {
            $this->matchChar(34); 
            // Group.g:247:3: ( '\\\\' '\"' | '\\\\' ~ '\"' | '\\n' | ~ ( '\\\\' | '\"' | '\\n' ) )* 
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
            	    // Group.g:247:5: '\\\\' '\"' 
            	    {
            	    $this->matchChar(92); 
            	    $this->matchChar(34); 

            	    }
            	    break;
            	case 2 :
            	    // Group.g:248:5: '\\\\' ~ '\"' 
            	    {
            	    $this->matchChar(92); 
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('33'))||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;
            	case 3 :
            	    // Group.g:249:5: '\\n' 
            	    {

            	      			String msg = "\\n in string";
            	          		NoViableAltException e = new NoViableAltException("", 0, 0, input);
            	      			ErrorManager.syntaxError(ErrorType.SYNTAX_ERROR, getSourceName(), e, msg);
            	      			
            	    $this->matchChar(10); 

            	    }
            	    break;
            	case 4 :
            	    // Group.g:255:5: ~ ( '\\\\' | '\"' | '\\n' ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('9'))||($this->input->LA(1)>=$this->getToken('11') && $this->input->LA(1)<=$this->getToken('33'))||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
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
            $_type = GroupLexer::$BIGSTRING;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:261:2: ( '<<' ( options {greedy=false; } : '\\\\' '>' | '\\\\' ~ '>' | ~ '\\\\' )* '>>' ) 
            // Group.g:261:4: '<<' ( options {greedy=false; } : '\\\\' '>' | '\\\\' ~ '>' | ~ '\\\\' )* '>>' 
            {
            $this->matchString("<<"); 

            // Group.g:262:3: ( options {greedy=false; } : '\\\\' '>' | '\\\\' ~ '>' | ~ '\\\\' )* 
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
            	    // Group.g:263:5: '\\\\' '>' 
            	    {
            	    $this->matchChar(92); 
            	    $this->matchChar(62); 

            	    }
            	    break;
            	case 2 :
            	    // Group.g:264:5: '\\\\' ~ '>' 
            	    {
            	    $this->matchChar(92); 
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('61'))||($this->input->LA(1)>=$this->getToken('63') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;
            	case 3 :
            	    // Group.g:265:5: ~ '\\\\' 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
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


                          String txt = getText().replaceAll("\\\\>",">");
              		    setText(txt);
              		

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
            $_type = GroupLexer::$ANONYMOUS_TEMPLATE;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:279:2: ( '{' '}' ) 
            // Group.g:279:4: '{' '}' 
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
            $_type = GroupLexer::$AT;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:293:4: ( '@' ) 
            // Group.g:293:6: '@' 
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
            $_type = GroupLexer::$LPAREN;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:294:7: ( '(' ) 
            // Group.g:294:9: '(' 
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
            $_type = GroupLexer::$RPAREN;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:295:7: ( ')' ) 
            // Group.g:295:9: ')' 
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
            $_type = GroupLexer::$LBRACK;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:296:7: ( '[' ) 
            // Group.g:296:9: '[' 
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
            $_type = GroupLexer::$RBRACK;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:297:7: ( ']' ) 
            // Group.g:297:9: ']' 
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
            $_type = GroupLexer::$COMMA;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:298:6: ( ',' ) 
            // Group.g:298:9: ',' 
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
            $_type = GroupLexer::$DOT;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:299:4: ( '.' ) 
            // Group.g:299:7: '.' 
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
            $_type = GroupLexer::$DEFINED_TO_BE;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:300:14: ( '::=' ) 
            // Group.g:300:17: '::=' 
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
            $_type = GroupLexer::$SEMI;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:301:5: ( ';' ) 
            // Group.g:301:9: ';' 
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
            $_type = GroupLexer::$COLON;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:302:6: ( ':' ) 
            // Group.g:302:9: ':' 
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
            $_type = GroupLexer::$STAR;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:303:5: ( '*' ) 
            // Group.g:303:9: '*' 
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
            $_type = GroupLexer::$PLUS;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:304:5: ( '+' ) 
            // Group.g:304:9: '+' 
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
            $_type = GroupLexer::$ASSIGN;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:305:7: ( '=' ) 
            // Group.g:305:11: '=' 
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
            $_type = GroupLexer::$OPTIONAL;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:306:10: ( '?' ) 
            // Group.g:306:12: '?' 
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
            $_type = GroupLexer::$COMMENT;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:309:5: ( '/*' ( options {greedy=false; } : . )* '*/' ) 
            // Group.g:309:9: '/*' ( options {greedy=false; } : . )* '*/' 
            {
            $this->matchString("/*"); 

            // Group.g:309:14: ( options {greedy=false; } : . )* 
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
            	    // Group.g:309:42: . 
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
            $_type = GroupLexer::$LINE_COMMENT;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:313:5: ( '//' (~ ( '\\n' | '\\r' ) )* ( '\\r' )? '\\n' ) 
            // Group.g:313:7: '//' (~ ( '\\n' | '\\r' ) )* ( '\\r' )? '\\n' 
            {
            $this->matchString("//"); 

            // Group.g:313:12: (~ ( '\\n' | '\\r' ) )* 
            //loop5:
            do {
                $alt5=2;
                $LA5_0 = $this->input->LA(1);

                if ( (($LA5_0>=$this->getToken('0') && $LA5_0<=$this->getToken('9'))||($LA5_0>=$this->getToken('11') && $LA5_0<=$this->getToken('12'))||($LA5_0>=$this->getToken('14') && $LA5_0<=$this->getToken('65535'))) ) {
                    $alt5=1;
                }


                switch ($alt5) {
            	case 1 :
            	    // Group.g:313:12: ~ ( '\\n' | '\\r' ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('9'))||($this->input->LA(1)>=$this->getToken('11') && $this->input->LA(1)<=$this->getToken('12'))||($this->input->LA(1)>=$this->getToken('14') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop5;
                }
            } while (true);

            // Group.g:313:26: ( '\\r' )? 
            $alt6=2;
            $LA6_0 = $this->input->LA(1);

            if ( ($LA6_0==$this->getToken('13')) ) {
                $alt6=1;
            }
            switch ($alt6) {
                case 1 :
                    // Group.g:313:26: '\\r' 
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
            $_type = GroupLexer::$WS;
            $_channel = GroupLexer::$DEFAULT_TOKEN_CHANNEL;
            // Group.g:316:5: ( ( ' ' | '\\r' | '\\t' | '\\n' ) ) 
            // Group.g:316:7: ( ' ' | '\\r' | '\\t' | '\\n' ) 
            {
            if ( ($this->input->LA(1)>=$this->getToken('9') && $this->input->LA(1)<=$this->getToken('10'))||$this->input->LA(1)==$this->getToken('13')||$this->input->LA(1)==$this->getToken('32') ) {
                $this->input->consume();

            }
            else {
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
        // Group.g:1:8: ( T__25 | T__26 | T__27 | ID | STRING | BIGSTRING | ANONYMOUS_TEMPLATE | AT | LPAREN | RPAREN | LBRACK | RBRACK | COMMA | DOT | DEFINED_TO_BE | SEMI | COLON | STAR | PLUS | ASSIGN | OPTIONAL | COMMENT | LINE_COMMENT | WS ) 
        $alt7=24;
        $alt7 = $this->dfa7->predict($this->input);
        switch ($alt7) {
            case 1 :
                // Group.g:1:10: T__25 
                {
                $this->mT__25(); 

                }
                break;
            case 2 :
                // Group.g:1:16: T__26 
                {
                $this->mT__26(); 

                }
                break;
            case 3 :
                // Group.g:1:22: T__27 
                {
                $this->mT__27(); 

                }
                break;
            case 4 :
                // Group.g:1:28: ID 
                {
                $this->mID(); 

                }
                break;
            case 5 :
                // Group.g:1:31: STRING 
                {
                $this->mSTRING(); 

                }
                break;
            case 6 :
                // Group.g:1:38: BIGSTRING 
                {
                $this->mBIGSTRING(); 

                }
                break;
            case 7 :
                // Group.g:1:48: ANONYMOUS_TEMPLATE 
                {
                $this->mANONYMOUS_TEMPLATE(); 

                }
                break;
            case 8 :
                // Group.g:1:67: AT 
                {
                $this->mAT(); 

                }
                break;
            case 9 :
                // Group.g:1:70: LPAREN 
                {
                $this->mLPAREN(); 

                }
                break;
            case 10 :
                // Group.g:1:77: RPAREN 
                {
                $this->mRPAREN(); 

                }
                break;
            case 11 :
                // Group.g:1:84: LBRACK 
                {
                $this->mLBRACK(); 

                }
                break;
            case 12 :
                // Group.g:1:91: RBRACK 
                {
                $this->mRBRACK(); 

                }
                break;
            case 13 :
                // Group.g:1:98: COMMA 
                {
                $this->mCOMMA(); 

                }
                break;
            case 14 :
                // Group.g:1:104: DOT 
                {
                $this->mDOT(); 

                }
                break;
            case 15 :
                // Group.g:1:108: DEFINED_TO_BE 
                {
                $this->mDEFINED_TO_BE(); 

                }
                break;
            case 16 :
                // Group.g:1:122: SEMI 
                {
                $this->mSEMI(); 

                }
                break;
            case 17 :
                // Group.g:1:127: COLON 
                {
                $this->mCOLON(); 

                }
                break;
            case 18 :
                // Group.g:1:133: STAR 
                {
                $this->mSTAR(); 

                }
                break;
            case 19 :
                // Group.g:1:138: PLUS 
                {
                $this->mPLUS(); 

                }
                break;
            case 20 :
                // Group.g:1:143: ASSIGN 
                {
                $this->mASSIGN(); 

                }
                break;
            case 21 :
                // Group.g:1:150: OPTIONAL 
                {
                $this->mOPTIONAL(); 

                }
                break;
            case 22 :
                // Group.g:1:159: COMMENT 
                {
                $this->mCOMMENT(); 

                }
                break;
            case 23 :
                // Group.g:1:167: LINE_COMMENT 
                {
                $this->mLINE_COMMENT(); 

                }
                break;
            case 24 :
                // Group.g:1:180: WS 
                {
                $this->mWS(); 

                }
                break;

        }

    }



}
?>