<?php

/**
 * Test: Nette\Mail\Mail - textual body.
 *
 * @author     Stork Dork
 * @package    Nette\Application
 * @subpackage UnitTests
 */

// tests/run-tests.sh -p php tests/Mail/Mail.008.phpt

use Nette\Mail\Mail;



require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/Mail.inc';



$mail = new Mail();

$mail->setFrom('John Doe <doe@example.com>');
$mail->addTo('Lady Jane <jane@example.foo>');
$mail->addTo('williams@example.foo');
$mail->addTo('Řehoř Řízek <rizek@example.foo>');
$mail->addTo('Luboš Smažák <smazak@example.foo>');
$mail->setSubject('Hello Jane!');

$mail->setBody('Žluťoučký kůň');

$mail->send();

Assert::match( <<<EOD
MIME-Version: 1.0
X-Mailer: Nette Framework
Date: %a%
From: John Doe <doe@example.com>
To: Lady Jane <jane@example.foo>,
	williams@example.foo,
	=?UTF-8?B?xZhlaG/FmSDFmMOtemVr?= <rizek@example.foo>,
	=?UTF-8?B?THVib8WhIFNtYcW+w6Fr?= <smazak@example.foo>
Subject: Hello Jane!
Message-ID: <%S%@localhost>
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit

Žluťoučký kůň
EOD
, TestMailer::$output );