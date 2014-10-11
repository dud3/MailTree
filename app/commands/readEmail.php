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
	
		$bool = $this->argument('html_bool');

		($bool == "true") ? $bool = true : $bool = false;

		$this->comment("Reading emails...");
		$this->emails->readMails($html_enable = $bool);
		$this->info("Emails has been readen.");

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('html_bool', InputArgument::REQUIRED, ' argument is required eother true or false.'),
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
			array('html_enable', null, InputOption::VALUE_OPTIONAL, 'Argument as option.', null),
		);
	}
	*/

	//
	// Further command-line color options...
	/*
	$this->info("This is a comment.");
	$this->question("This is a question.");
	$this->error("This is an error.");
	*/



}
