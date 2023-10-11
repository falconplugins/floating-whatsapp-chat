<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * php version 8.2.0
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Floating WhatsApp Chat - Falcon
 * Plugin URI:        https://falconplugins.store/plugins/floating-whatsapp-chat
 * Description:       Enable WhatsApp chat via a floating button on your website.
 * Version:           1.0.0
 * Author:            Falcon Plugins
 * Author URI:        https://falconplugins.store/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dialog-chat
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC') ) {
    die;
}

if (! defined('DC_PLUGIN_PATH') ) {
    define('DC_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

if (! defined('DC_PLUGIN_URL') ) {
    define('DC_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (! defined('DC_WHATSAPP_API_URL') ) {
    define('DC_WHATSAPP_API_URL', 'https://api.whatsapp.com/send?phone=');
}

if (! defined('DC_WHATSAPP_WIDGET_ICON') ) {
    define(
        'DC_WHATSAPP_WIDGET_ICON', 
        DC_PLUGIN_URL . 'includes/assets/icons/whatsapp-icon.svg'
    );
}

if (! defined('DC_WHATSAPP_WIDGET_CLOSE_ICON') ) {
    define(
        'DC_WHATSAPP_WIDGET_CLOSE_ICON', 
        DC_PLUGIN_URL . 'includes/assets/icons/close-icon.png'
    );
}

if (! defined('DC_WHATSAPP_DEFAULT_SETTINGS') ) {
    define(
        'DC_WHATSAPP_DEFAULT_SETTINGS',
        array(
        'text'   => array(
                'close_title'        => 'Need Help?',
                'widget_title'       => "Let's Chat",
                'widget_description' => 'Click on any of the members shown below to chat on <strong>WhatsApp</strong>.', //phpcs:ignore
                'response_time_text' => 'Our team replies in a <strong>few minutes</strong>.', //phpcs:ignore
        ),
        'design' => array(
                'close_widget_button'   => '',
                'close_icon'            => '',
                'close_button_bg_color' => '#63d611',
                'close_title_size'      => '15',
                'close_title_color'     => '#000000',
                'close_title_bg_color'  => '#d3d3d3',
                'widget_title_size'     => '20',
                'widget_title_color'    => '#ffffff',
        ),
        )
    );
}

/**
 * Currently plugin version.
 */
define('DIALOG_CHAT_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dialog-chat-activator.php
 * 
 * @return NULL
 */
function Activate_Dialog_chat()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-dialog-chat-activator.php'; //phpcs:ignore
    Dialog_Chat_Activator::activate();

    if (! get_option('dc_admin_settings') ) {
        add_option('dc_admin_settings', DC_WHATSAPP_DEFAULT_SETTINGS, true);
    }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dialog-chat-deactivator.php
 * 
 * @return NULL
 */
function DeActivate_Dialog_chat()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-dialog-chat-deactivator.php'; //phpcs:ignore
    Dialog_Chat_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'Activate_Dialog_chat');
register_deactivation_hook(__FILE__, 'DeActivate_Dialog_chat');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-dialog-chat.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  1.0.0
 * @return NULL
 */
function Run_Dialog_chat()
{

    $plugin = new Dialog_Chat();
    $plugin->run();
}
Run_Dialog_chat();
