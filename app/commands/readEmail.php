<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class readEmail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'email:read';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Read emails from the account.';

	/**
	 * [$emails description]
	 * @var [type]
	 */
	public $emails;

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
		$this->emails->readMails();
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
