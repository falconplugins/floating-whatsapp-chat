<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Admin file which loads CPT and settings at the first.
 * 
 * php version 8.2.0
 * 
 * @category   Dialog_Chat
 * @package    Dialog_Chat
 * @subpackage Dialog_Chat/includes
 * @author     Falcon Plugins <falcon@dialog-chat.com>
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link       https://dialog-chat.com
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat/admin
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 */
class Dialog_Chat_Admin
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
     * @param string $_plugin_name The name of this plugin.
     * @param string $_version     The version of this plugin.
     * 
     * @since  1.0.0
     * @return NULL
     */
    public function __construct( $_plugin_name, $_version )
    {

        $this->plugin_name = $_plugin_name;
        $this->version     = $_version;

        $this->loadDcAdminFiles();
    }

    /**
     * Load admin files.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function loadDcAdminFiles()
    {

        // Main ADMIN functions init file
        include_once plugin_dir_path(__FILE__) . 'partials/class-dialog-chat-admin-main.php'; //phpcs:ignore

        $DC_Admin = new Dialog_Chat_Admin_Main();
    }

    /**
     * Register the stylesheets for the admin area.
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
            $this->plugin_name, 
            plugin_dir_url(__FILE__) . 'css/dialog-chat-admin.css', 
            array(), 
            $this->version, 
            'all'
        );

        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script(
            $this->plugin_name, 
            plugin_dir_url(__FILE__) . 'js/dialog-chat-admin.js', 
            array( 
                'jquery', 
                'wp-color-picker' 
            ), 
            $this->version, 
            false
        );
    }
}
