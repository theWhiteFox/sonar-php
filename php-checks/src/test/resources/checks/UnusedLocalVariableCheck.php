<?php

/**
 *  BASIC VARIABLE
 */
function f() {
  $a = 1;    // OK
  $b = 1;    // NOK
  $c =& $a;  // NOK
}

/**
 *  GLOBAL
 */
function g($p) {
  global $a;

  $a = 1;         // OK - global var
  $b = 1;         // NOK
  $c = $p->a;     // OK

  return $c;
}

/**
 *  STATIC
 */
function h() {
  static $a, $b = 1;  // NOK - $b

  return $a;
}

/**
 *  PARAMETER
 */
function i($p) {  // OK - not a local variable
   $a = 1;        // NOK

   return $p;
}

/*
 *  USE
 */
$a = function($p) use ($u) {   // OK - $u exclusion
	return $p;
};

function j($p) {
  $a = 1;                      // OK - use in anonymous function
  $b = 1;                      // OK - use in anonymous function

  call(function () use ($a, $b, $p) {  // NOK - $b ($p exclusion)
    return $a;
  });
}

/*
 *  USE WITH REFERENCE
 */
function j() {
  $a = 1;                                 // OK - use in anonymous function

  call(function () use (&$a, &$b, &$c) {  // NOK - $a, $c (not use in outer, reference not needed )
    $b = 1 ;
    $c = 1;
  });

  return $b;
}

/**
 * SUPER-GLOBALS
 */
function k() {
  $GLOBALS["name"] = "name";  // OK
  $_POST["name"] = "name";    // OK
}

/**
 * NEW EXPRESSION
 */
function l() {
  $class = "MyClass";   // OK

  return new $class ();
}

/**
 *  $this
 */
class C {
  static $a = 1;
  private $b = 1;

  public function f() {
    self::$a = 1;       // OK
    $this->b = 1;       // OK

  }
}

/**
 * SCOPE
 */
function m($p){

  $a = $p;                                            // OK - use in anonymous function
  $b = function () use ($a) {                         // OK - use in anonymous function
          return function (FormView $view) use ($a) { // OK used
          $a->do();
        };
     };

  doSomething($b);
}

/**
 * LIST
 */
function n(){

  list($a, $b) = array();             // NOK - $a
  list(static::$d) = array();         // OK
  list(list($c) = array()) = array(); // NOK - $c

  doSomething($b);
}

/**
 * VARIABLE VARIABLES
 */
function o(){
  global $a, $$a;  // OK variable variables are not supported

  return $a;
}

/**
 * ENCAPSULATE VARIABLE
 */
function p(){
  $a1 = 1; $a2 = 1; $a3 = 1;    // OK
  $b1 = 2; $b2 = 2; $b3 = 2;    // OK
  $c1 = 3;                      // OK

  echo "Simple encaps  $a1";
  echo "Semi-complex encaps  ${a2}";
  echo "Complex encaps  {$a3}";

  echo "Simple encaps  $b1->c";
  echo "Semi-complex encaps  ${b2[0]}";
  echo "Complex encaps  {$b3 + $c1}";
}

/**
 * OUT OF EVERY SCOPE
 */
$a = 1;
