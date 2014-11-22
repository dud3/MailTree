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

		$__option_test_user_only = $this->option('test_user');

		$this->comment("Sending emails...");

		($__option_test_user_only) ? $this->comment("Test user: enabled") : $this->comment("Test user: disabled");

		$this->emails->sendMails($fwd_from = null, $__option_test_user_only);
		
		$this->info("Emails sent.");

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('options', null, InputOption::VALUE_OPTIONAL, 'Help', null),
			array('html_enable', null, InputOption::VALUE_REQUIRED, 'Argument as option.', null),
			array('email_search', null, InputOption::VALUE_REQUIRED, 'Type of email(New, seen, unseen...).', null),
			array('test_user', null, InputOption::VALUE_REQUIRED, 'Only Test user(s).', null),
		);
	}

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
