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


	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template	$template Template object
	 * @param \phpbb\user								$user User object
	 * @param \phpbb\request\request		$request
	 * @return \aurelienazerty\darkmode\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request)
	{
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'			=> 'do_dark',
			'core.adm_page_header'	=> 'do_dark',
		);
	}
	
	public function do_dark($event)
	{
		$idDark = $this->request->variable('darkmode', false, true, \phpbb\request\request_interface::COOKIE);
		if ($idDark)
		{
			$styleDoLight = "";
			$styleDoDark = "display: none;";
			$class = "darkmode";
		}
		else
		{
			$styleDoLight = "display: none;";
			$styleDoDark = "";
			$class = "lightmode";
		}
		
		$this->template->append_var('BODY_CLASS', $class);
		$this->template->append_var('STYLE_DO_DARK', $styleDoDark);
		$this->template->append_var('STYLE_DO_LIGHT', $styleDoLight);
    
		$this->user->add_lang_ext('aurelienazerty/darkmode', 'dark_mode');
		$this->template->assign_var('DO_DARK_MESSAGE'	, $this->user->lang['DO_DARK_MODE']);
		$this->template->assign_var('DO_LIGHT_MESSAGE'	, $this->user->lang['DO_LIGHT_MODE']);
	}
}
