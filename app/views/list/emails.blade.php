@extends('layouts.internal')
@section('main')

<h1>Hi List goes here...</h1>


<?php 

	/** @var $message \Fetch\Message */
	foreach ($_inbox as $message) {
		echo "<pre>";
		var_dump($message->getSubject());
	    // echo "Subject: {$message->getSubject()}\nBody: {$message->getMessageBody()}\n";
	}

?>

@stop