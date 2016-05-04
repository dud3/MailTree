<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => 'mg.acsbill.com',
		'secret' => 'key-fc34a563f15ff887918a2257fa83841c',
	),

	'mandrill' => array(
		'secret' => 'Y43YmTMvJAFJTg8OFKJFBA',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

);
