<?php
/**
 * @package bbguild
 * @copyright 2018 avathar.be
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace avathar\bbguild\controller;

use avathar\bbguild\views\viewnavigation;
use avathar\bbguild\model\games\game;

/**
 * Class view_controller
 *
* @package avathar\bbguild\controller
 */
class view_controller
{
	public $bb_games_table;
	public $bb_logs_table;
	public $bb_ranks_table;
	public $bb_guild_table;
	public $bb_players_table;
	public $bb_classes_table;
	public $bb_races_table;
	public $bb_gameroles_table;
	public $bb_factions_table;
	public $bb_language_table;
	public $bb_motd_table;
	public $bb_recruit_table;
	public $bb_achievement_track_table;
	public $bb_achievement_table;
	public $bb_achievement_rewards_table;
	public $bb_criteria_track_table;
	public $bb_achievement_criteria_table;
	public $bb_relations_table;
	public $bb_bosstable;
	public $bb_zonetable;
	public $bb_news;
	public $bb_plugins;


	/**
	 * @var \phpbb\config\config
	 */
	public $config;
	/**
	 * @var \phpbb\controller\helper
	 */
	public $helper;
	/**
	 * @var \phpbb\template\template
	 */
	public $template;
	/**
	 * @var \phpbb\db\driver\driver_interface
	 */
	public $db;
	/**
	 * @var \phpbb\request\request
	 */
	public $request;
	/**
	 * @var \phpbb\user
	 */
	public $user;
	/**
	 * @var string
	 */
	public $phpEx;
	/**
	 * @var \phpbb\pagination
	 */
	public $pagination;
	/**
	 * @var \phpbb\extension\manager
	 */
	public $phpbb_extension_manager;
	/**
	 * @var string
	 */
	public $ext_path;
	/**
	 * @var string
	 */
	public $ext_path_web;
	/**
	 * @var string
	 */
	public $ext_path_images;
	/**
	 * @var string
	 */
	public $root_path;
	/**
	 * @var array
	 */
	public $games;

	/**
	 * supported languages. The game related texts (class names etc) are not stored in language files but in the database.
	 * supported languages are en, fr, de : to add a new language you need to a) make language files b) make db installers in new language c) adapt this array
	 *
	 * @var array
	 */
	public $languagecodes;


	private $valid_views = array('roster', 'welcome', 'achievements');
	//private $valid_views = array('news', 'roster', 'standings', 'welcome', 'stats', 'player', 'raids');

	/**
	 * view_controller constructor.
	 *
	 * @param \phpbb\auth\auth                  $auth
	 * @param \phpbb\config\config              $config
	 * @param \phpbb\controller\helper          $helper
	 * @param $php_ext
	 * @param $root_path
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\extension\manager          $phpbb_extension_manager
	 * @param \phpbb\language\language          $language
	 * @param \phpbb\pagination                 $pagination
	 * @param \phpbb\path_helper                $path_helper
	 * @param \phpbb\template\template          $template
	 * @param \phpbb\request\request            $request
	 * @param \phpbb\user                       $user
	 * @param  string           $bb_games_table	name of game table
	 * @param  string           $bb_logs_table	name of logging table
	 * @param  string           $bb_ranks_table	name of ranks table
	 * @param  string           $bb_guild_table	name of guild table
	 * @param  string           $bb_players_table	name of players table
	 * @param  string           $bb_classes_table	name of classes table
	 * @param  string           $bb races_table		name of races table
	 * @param  string           $bb_gameroles_table	name of roles table
	 * @param  string           $bb_factions_table	name of factions table
	 * @param  string           $bb_language_table	name of language table
	 * @param  string           $bb_motd_table	name of motd table
	 * @param  string           $recruit_table	name of recruit table
	 * @param  string           $bb_achievement_track_table	name of achievement track table
	 * @param  string           $bb_achievement_table	name of achievement table
	 * @param  string           $bb_achievement_rewards_table	name of achievement rewards table
	 * @param  string           $bb_criteria_track_table	name of achievement criteria track table
	 * @param  string           $bb_achievement_criteria_table	name of achievement criteria table
	 * @param  string           $bb_relations_table 	name of relations table
	 * @param  string           $bb_bosstable	name of boss table
	 * @param  string           $bb_zonetable	name of zone table
	 * @param  string           $bb_news	name of news table
	 * @param  string           $bb_plugins	name of plugin table
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\controller\helper $helper,
		$php_ext,
		$root_path,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\extension\manager $phpbb_extension_manager,
		\phpbb\language\language $language,
		\phpbb\pagination $pagination,
		\phpbb\path_helper $path_helper,
		\phpbb\template\template $template,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$bb_games_table,
		$bb_logs_table,
		$bb_ranks_table,
		$bb_guild_table,
		$bb_players_table,
		$bb_classes_table,
		$bb_races_table,
		$bb_gameroles_table,
		$bb_factions_table,
		$bb_language_table,
		$bb_motd_table,
		$bb_recruit_table,
		$bb_achievement_track_table,
		$bb_achievement_table,
		$bb_achievement_rewards_table,
		$bb_criteria_track_table,
		$bb_achievement_criteria_table,
		$bb_relations_table,
		$bb_bosstable,
		$bb_zonetable,
		$bb_news,
		$bb_plugins
	)
	{

		$this->auth         = $auth;
		$this->config       = $config;
		$this->helper       = $helper;
		$this->php_ext      = $php_ext;
		$this->root_path  	= $root_path;
		$this->db           = $db;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->ext_path            = $this->phpbb_extension_manager->get_extension_path('avathar/bbguild', true);
		$this->language         = $language;
		$this->pagination     = $pagination;
		$this->path_helper    = $path_helper;
		$this->ext_path_web        = $this->path_helper->get_web_root_path();
		$this->ext_path_images    = $this->ext_path_web . 'ext/avathar/bbguild/images/';
		$this->template     = $template;
		$this->request      = $request;
		$this->user         = $user;
		$this->bb_games_table = $bb_games_table;
		$this->bb_logs_table = $bb_logs_table;
		$this->bb_ranks_table = $bb_ranks_table;
		$this->bb_guild_table = $bb_guild_table;
		$this->bb_players_table = $bb_players_table;
		$this->bb_classes_table = $bb_classes_table;
		$this->bb_races_table = $bb_races_table;
		$this->bb_gameroles_table = $bb_gameroles_table;
		$this->bb_factions_table = $bb_factions_table;
		$this->bb_language_table = $bb_language_table;
		$this->bb_motd_table = $bb_motd_table;
		$this->bb_recruit_table = $bb_recruit_table;
		$this->bb_achievement_track_table = $bb_achievement_track_table;
		$this->bb_achievement_table = $bb_achievement_table;
		$this->bb_achievement_rewards_table = $bb_achievement_rewards_table;
		$this->bb_criteria_track_table = $bb_criteria_track_table;
		$this->bb_achievement_criteria_table = $bb_achievement_criteria_table;
		$this->bb_relations_table = $bb_relations_table;
		$this->bb_bosstable = $bb_bosstable;
		$this->bb_zonetable =  $bb_zonetable;
		$this->bb_news = $bb_news;
		$this->bb_plugins = $bb_plugins;

		$this->languagecodes = array(
			'de' => $user->lang['LANG_DE'],
			'en' => $user->lang['LANG_EN'],
			'fr' => $user->lang['LANG_FR'],
			'it' => $user->lang['LANG_IT']
		);

		$listgames = new game($bb_classes_table, $bb_races_table, $bb_language_table, $bb_factions_table, $bb_games_table );
		$this->games = $listgames->games;
		unset($listgames);

	}

	/**
	 * View factory
	 *
	 * @param  $guild_id
	 * @param  $page
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handleview($guild_id, $page)
	{
		if (in_array($page, $this->valid_views))
		{
			$navigation = new viewnavigation($page, $this, $guild_id);
			$viewtype = "\\bbdkp\\bbguild\\views\\view". $page;
			$view = new $viewtype($navigation, $this);
			$response = $view->response;
			return $response;
		}
		else
		{
			$alert=$this->language->lang('NOVIEW');
			if (isset($alert))
			{
				trigger_error(sprintf($alert, $page));
			}
		}
	}
}
