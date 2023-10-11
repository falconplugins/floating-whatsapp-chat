<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
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
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 */
class Dialog_Chat
{


    /**
     * The loader that's responsible for maintaining and registering all hooks
     * that power the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    Dialog_Chat_Loader $loader all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used in the plugin.
     * Load the dependencies, define the locale, and set the hooks for 
     * the admin area and the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('DIALOG_CHAT_VERSION') ) {
            $this->version = DIALOG_CHAT_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'dialog-chat';

        $this->_loadDependencies();
        $this->_setLocale();
        $this->_defineAdminHooks();
        $this->_definePublicHooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Dialog_Chat_Loader. Orchestrates the hooks of the plugin.
     * - Dialog_Chat_I18n. Defines internationalization functionality.
     * - Dialog_Chat_Admin. Defines all hooks for the admin area.
     * - Dialog_Chat_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _loadDependencies()
    {
        // @codingStandardsIgnoreStart
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        include_once plugin_dir_path(__DIR__) . 'includes/class-dialog-chat-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(__DIR__) . 'includes/class-dialog-chat-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        include_once plugin_dir_path(__DIR__) . 'admin/class-dialog-chat-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        include_once plugin_dir_path(__DIR__) . 'public/class-dialog-chat-public.php';

        if (! is_admin() ) {
            include_once plugin_dir_path(__DIR__) . 'public/partials/dialog-chat-public-display.php';
        }

        $this->loader = new Dialog_Chat_Loader();

        // @codingStandardsIgnoreEnd

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Dialog_Chat_I18n class in order to set the domain and to register
     * the hook with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _setLocale()
    {

        $plugin_i18n = new Dialog_Chat_I18n();

        $this->loader->addAction(
            'plugins_loaded', 
            $plugin_i18n, 
            'loadPluginTextdomain'
        );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _defineAdminHooks()
    {

        $plugin_admin = new Dialog_Chat_Admin(
            $this->getPluginName(), 
            $this->getVersion()
        );

        $this->loader->addAction(
            'admin_enqueue_scripts', 
            $plugin_admin, 
            'enqueueStyles'
        );
        $this->loader->addAction(
            'admin_enqueue_scripts', 
            $plugin_admin, 
            'enqueueScripts'
        );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return NULL
     */
    private function _definePublicHooks()
    {

        $plugin_public = new Dialog_Chat_Public(
            $this->getPluginName(), 
            $this->getVersion()
        );

        $this->loader->addAction(
            'wp_enqueue_scripts', 
            $plugin_public, 
            'enqueueStyles'
        );
        $this->loader->addAction(
            'wp_enqueue_scripts', 
            $plugin_public, 
            'enqueueScripts'
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return Dialog_Chat_Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}
