<?php
/**
 * File:  mail.php
 * Creation Date: 27/06/2017
 * description:
 *
 * @author: canals
 */

require __DIR__ . '/../src/vendor/autoload.php';

$mailer = new Swift_Mailer( new Swift_SmtpTransport('mail', 1025, '') );

$message = (new Swift_Message('test subject'))
     ->setFrom( ['john.doe@mix.com'=>'john doe'])
     ->setTo(['gerome.canals@gmail.com'=>'gerome canals'])
     ->setBody("Hi gerome \n  This is a test message from the docker boilerplate web_test container ...");

$mailer->send($message);

echo "mail sent ! <br>";