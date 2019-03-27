<?php
/**
 *
 * Dark Mode extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace Aurelienazerty\darkMode\event;

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


	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template	$config	Config object
	 * @return \Aurelienazerty\darkMode\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\user $user)
	{
		$this->template = $template;
    $this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'		=> 'do_dark',
		);
	}
	
	public function do_dark($event)
	{
		$idDark = request_var('darkmode','',false,true);
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
			$class = "";
		}
		
		$this->template->append_var('BODY_CLASS', $class);
		$this->template->append_var('STYLE_DO_DARK', $styleDoDark);
		$this->template->append_var('STYLE_DO_LIGHT', $styleDoLight);
    
    $this->user->add_lang_ext('Aurelienazerty/darkMode', 'dark_mode');
		$this->template->assign_var('DO_DARK_MESSAGE'	, $this->user->lang['DO_DARK_MODE']);
		$this->template->assign_var('DO_LIGHT_MESSAGE'	, $this->user->lang['DO_LIGHT_MODE']);
	}
}
