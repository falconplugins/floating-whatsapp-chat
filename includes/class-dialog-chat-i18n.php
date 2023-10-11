<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 * 
 * php version 8.2.0
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat/includes
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat/includes
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 */
class Dialog_Chat_I18n
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function loadPluginTextdomain()
    {

        load_plugin_textdomain(
            'dialog-chat',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
