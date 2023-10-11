<?php

/**
 * The public-facing functionality of the plugin.
 * 
 * Public file for the plugin.
 * 
 * php version 8.2.0
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, _version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @category   Dialog_Chat
 * @package    Dialog_Chat
 * @subpackage Dialog_Chat/public
 * @author     Falcon Plugins <falcon@dialog-chat.com>
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link       https://dialog-chat.com
 * @since      1.0.0
 */
class Dialog_Chat_Public
{


    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $_plugin_name    The ID of this plugin.
     */
    private $_plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $_version    The current version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $_plugin_name The name of the plugin.
     * @param string $_version     The version of this plugin.
     */
    public function __construct( $_plugin_name, $_version )
    {

        $this->_plugin_name = $_plugin_name;
        $this->_version     = $_version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function enqueueStyles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Dialog_Chat_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Dialog_Chat_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style(
            $this->_plugin_name, 
            plugin_dir_url(__FILE__) . 'css/dialog-chat-public.css', 
            array(), 
            $this->_version, 
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function enqueueScripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Dialog_Chat_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Dialog_Chat_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $dc_options = get_option('dc_admin_settings');

        $dc_widget_icon = wp_get_attachment_image_src( $dc_options['design']['close_widget_button'], 'single-post-thumbnail' )[0] ?? ''; //phpcs:ignore
        $dc_close_icon  = wp_get_attachment_image_src( $dc_options['design']['close_icon'], 'single-post-thumbnail' )[0] ?? ''; //phpcs:ignore

        if (! $dc_widget_icon ) {
            $dc_widget_icon = DC_WHATSAPP_WIDGET_ICON;
        }

        if (! $dc_close_icon ) {
            $dc_close_icon = DC_WHATSAPP_WIDGET_CLOSE_ICON;
        }

        wp_register_script(
            $this->_plugin_name, 
            plugin_dir_url(__FILE__) . 'js/dialog-chat-public.js', 
            array( 'jquery' ), 
            $this->_version, 
            false
        );

        wp_localize_script(
            $this->_plugin_name,
            'dc_local_data',
            array(
            'dc_widget_icon' => $dc_widget_icon,
            'dc_close_icon'  => $dc_close_icon,
            )
        );

        wp_enqueue_script($this->_plugin_name);
    }
}
