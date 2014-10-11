<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class sendEmail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'email:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends emails store into the DB(database).';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(EmailsRepositoryInterface $emails)
	{

		$this->emails = $emails;

		parent::__construct();

	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->comment("Sending emails...");
		$this->emails->sendMails();
		$this->info("Emails sent.");
	}


	// ========================
	// :: No arguments for now
	// ========================

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	/*
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}
	*/

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	/*
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
	*/

}
