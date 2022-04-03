<?php
/**
 *
 * Dark Mode extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace aurelienazerty\darkmode\event;

/**
 * Event listener
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user $user */
	protected $user;
	/** @var \phpbb\request\request */
	protected $request;
	/** @var \phpbb\config\config */
	protected $config;


	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template	$template Template object
	 * @param \phpbb\user					$user User object
	 * @param \phpbb\request\request		$request Request object
	 * @param \phpbb\config\config			$config	Config object
	 * @return \aurelienazerty\darkmode\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request,\phpbb\config\config $config)
	{
		$this->template = $template;
		$this->user 	= $user;
		$this->request 	= $request;
		$this->config	= $config;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'				=> 'do_dark',
			'core.adm_page_header'		=> 'do_dark',
		);
	}

	public function do_dark($event)
	{
		$cookie_darkmode_name = $this->config['cookie_name'] . '_darkmode';

		$dark_case = $this->request->variable($cookie_darkmode_name, false, false, \phpbb\request\request_interface::COOKIE);
		if ($dark_case)
		{
			$style_do_light = "";
			$style_do_dark = "display: none;";
			$class = "darkmode";
		}
		else
		{
			$style_do_light = "display: none;";
			$style_do_dark = "";
			$class = "lightmode";
		}

		$this->user->add_lang_ext('aurelienazerty/darkmode', 'dark_mode');

		$this->template->assign_vars(array(
			'S_DARKMODE_ROOT_CLASS'				=> 	$class,
			'STYLE_DO_DARK'						=> 	$style_do_dark,
			'STYLE_DO_LIGHT'					=> 	$style_do_light,
			'DO_DARK_MESSAGE'					=> 	$this->user->lang['DO_DARK_MODE'],
			'DO_LIGHT_MESSAGE'				=> 	$this->user->lang['DO_LIGHT_MODE'],
			'S_COOKIE_DARKMODE_NAME'	=>	$cookie_darkmode_name,
		));
	}
}
