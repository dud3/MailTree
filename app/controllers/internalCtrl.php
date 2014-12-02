<?php

/**
 * InternalCtrl.
 * Simply share gloal data through all the views..
 */
class internalCtrl extends BaseController {

	/**
	 * Current enviroment
	 * @var [string]
	 */
	public $__g_enviroment;

	/**
	 * Production enviroment
	 * @var [string]
	 */
	public $__g_prod_enviroment;

	/**
	 * Current page
	 * @var [string]
	 */
	public $__g_currentPage;

	/**
	 * File uploads
	 * @var [string]
	 */
	public $__g_local_file_uploads;

	/**
	 * Remote file uploads
	 * @var [string]
	 */
	public $__g_remote_file_uploads;

	/**
	 * Max post size
	 * @var [long]
	 */
	public $__POST_MAX_SIZE;

	/**
	 * Max upload size
	 * @var [long]
	 */
	public $__UPLOAD_MAX_SIZE;

	/**
	 * Internal notifications
	 * @var [string]
	 */
	public $__g_enable_internal_notifications;

	/**
	 * Notifications to emails
	 * @var [string]
	 */
	public $__g_enable_notification_emails;

	/**
	 * Forward from email address.
	 * @var [string]
	 */
	public $__g_fwd_email_address;

	/**
	 * Forward email address name.
	 * @var [string]
	 */
	public $__g_fwd_email_address_full_name;


	/**
	 * User Interface
	 * @var [Interface]
	 */
	public $user;

	public function __construct() {

		$this->__g_enviroment = Config::get('constant.g_enviroment');
		$this->__g_prod_enviroment = Config::get('constant.g_prod_enviroment');
		$this->__g_currentPage = Config::get('constant.g_currentPage');
		$this->__g_local_file_uploads = Config::get('constant.g_local_file_uploads');
		$this->__g_remote_file_uploads = Config::get('constant.g_remote_file_uploads');
		$this->__POST_MAX_SIZE = Config::get('constant.POST_MAX_SIZE');
		$this->__UPLOAD_MAX_SIZE = Config::get('constant.UPLOAD_MAX_SIZE');
		$this->__g_enable_internal_notifications = Config::get('constant.g_enable_internal_notifications');
		$this->__g_enable_notification_emails = Config::get('constant.g_enable_notification_emails');
		$this->__g_fwd_email_address = Config::get('constant.g_fwd_email_address');
		$this->__g_fwd_email_address_full_name = Config::get('constant.g_fwd_email_address_full_name');

		view::share('__g_enviroment', $this->__g_enviroment);
		view::share('__g_prod_enviroment', $this->__g_prod_enviroment);
		view::share('__g_currentPage', $this->__g_currentPage);
		view::share('__g_local_file_uploads', $this->__g_local_file_uploads);
		view::share('__g_remote_file_uploads', $this->__g_remote_file_uploads);
		view::share('__POST_MAX_SIZE', $this->__POST_MAX_SIZE);
		view::share('__UPLOAD_MAX_SIZE', $this->__UPLOAD_MAX_SIZE);
		view::share('__g_enable_internal_notifications', $this->__g_enable_internal_notifications);
		view::share('__g_enable_notification_emails', $this->__g_enable_notification_emails);
		view::share('__g_fwd_email_address', $this->__g_fwd_email_address);
		view::share('__g_fwd_email_address_full_name', $this->__g_fwd_email_address_full_name);

	}

}
