<?php

/**
 * Test: Annotations file parser.
 *
 * @author     David Grudl
 * @package    Nette\Reflection
 * @subpackage UnitTests
 */

use Nette\Reflection\AnnotationsParser,
	Nette\Environment;



require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/files/annotations.php';



// temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
TestHelpers::purge(TEMP_DIR);


AnnotationsParser::$useReflection = FALSE;


// AnnotatedClass1

$rc = new ReflectionClass('Nette\AnnotatedClass1');
Assert::same( array(
	'author' => array('john'),
), AnnotationsParser::getAll($rc) );

Assert::same( array(
	'var' => array('a'),
), AnnotationsParser::getAll($rc->getProperty('a')), '$a' );

Assert::same( array(
	'var' => array('b'),
), AnnotationsParser::getAll($rc->getProperty('b')), '$b' );

Assert::same( array(
	'var' => array('c'),
), AnnotationsParser::getAll($rc->getProperty('c')), '$c' );

Assert::same( array(
	'var' => array('d'),
), AnnotationsParser::getAll($rc->getProperty('d')), '$d' );

Assert::same( array(
	'var' => array('e'),
), AnnotationsParser::getAll($rc->getProperty('e')), '$e' );

Assert::same( array(), AnnotationsParser::getAll($rc->getProperty('f')), '$f' );

// AnnotationsParser::getAll($rc->getProperty('g')), '$g' ); // ignore due PHP bug #50174
Assert::same( array(
	'return' => array('a'),
), AnnotationsParser::getAll($rc->getMethod('a')), 'a()' );

Assert::same( array(
	'return' => array('b'),
), AnnotationsParser::getAll($rc->getMethod('b')), 'b()' );

Assert::same( array(
	'return' => array('c'),
), AnnotationsParser::getAll($rc->getMethod('c')), 'c()' );

Assert::same( array(
	'return' => array('d'),
), AnnotationsParser::getAll($rc->getMethod('d')), 'd()' );

Assert::same( array(
	'return' => array('e'),
), AnnotationsParser::getAll($rc->getMethod('e')), 'e()' );

Assert::same( array(), AnnotationsParser::getAll($rc->getMethod('f')), 'f()' );

Assert::same( array(
	'return' => array('g'),
), AnnotationsParser::getAll($rc->getMethod('g')), 'g()' );


// AnnotatedClass2

$rc = new ReflectionClass('Nette\AnnotatedClass2');
Assert::same( array(
	'author' => array('jack'),
), AnnotationsParser::getAll($rc) );


// AnnotatedClass3

$rc = new ReflectionClass('Nette\AnnotatedClass3');
Assert::same( array(), AnnotationsParser::getAll($rc) );
