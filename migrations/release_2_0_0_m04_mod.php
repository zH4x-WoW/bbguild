<?php
/**
 * bbGuild database installer
 *
 * @package bbguild v2.0
 * @copyright 2015 bbDKP <https://github.com/bbDKP>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace sajaki\bbguild\migrations;
use phpbb\db\migration\migration;

/**
 * Migration stage 4: module setup
 */
class release_2_0_0_m04_mod extends migration
{
    /**
     * Assign migration file dependencies for this migration
     *
     * @return array Array of migration files
     * @static
     * @access public
     */
    static public function depends_on()
    {
        return array('\sajaki\bbguild\migrations\release_2_0_0_m03_config');
    }

    /**
     * Add or update data in the database
     *
     * @return array Array of table data
     * @access public
     */
    public function update_data()
    {
        return array(

            /**
             * First, lets add bbguild category to the root.
             */
            //array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_BBGUILD')),
            array('module.add', array('acp', 0, 'ACP_CAT_BBGUILD')),

            array('module.add', array('acp', 'ACP_CAT_BBGUILD', 'ACP_BBGUILD_MAINPAGE')),

            array('module.add', array(
                'acp',
                'ACP_BBGUILD_MAINPAGE',
                array(
                    'module_basename' => '\sajaki\bbguild\acp\main_module',
                    'modes'           => array('panel', 'config', 'logs', 'index') ,
                )
            )),

            array('module.add', array(
                'acp',
                'ACP_BBGUILD_MAINPAGE',
                array(
                    'module_basename' => '\sajaki\bbguild\acp\game_module',
                    'modes'           => array('listgames', 'editgames', 'addfaction', 'addrace', 'addclass', 'addrole'),
                )
            )),

            array('module.add', array('acp', 'ACP_CAT_BBGUILD', 'ACP_BBGUILD_MEMBER')),

            array('module.add', array(
                'acp',
                'ACP_BBGUILD_MEMBER',
                array(
                    'module_basename' => '\sajaki\bbguild\acp\guild_module',
                    'modes'           => array('addguild', 'editguild', 'listguilds') ,
                )
            )),

            array('module.add', array(
                'acp',
                'ACP_BBGUILD_MEMBER',
                array(
                    'module_basename' => '\sajaki\bbguild\acp\mm_module',
                    'modes'           => array('mm_addmember', 'mm_listmembers') ,
                )
            )),

            array('module.add', array('ucp', '', 'UCP_BBGUILD')),
            array('module.add', array(
                'ucp',
                'UCP_BBGUILD',
                array(
                    'module_basename' => '\sajaki\bbguild\ucp\bbguild_module',
                    'modes'           => array('char', 'add') ,
                )
            )),


        );
    }
}