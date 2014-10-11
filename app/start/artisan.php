<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
$email = new EmailsRepository;
Artisan::add(new readEmail($email));
Artisan::add(new sendEmail($email));
Artisan::add(new cleanEmail());

Artisan::resolve('readEmail');