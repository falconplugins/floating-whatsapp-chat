<?php

/**
 * Register all actions and filters for the plugin.
 * 
 * Required actions and filters with data will be initialized and
 * utilized in this class.
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
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat/includes
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
 */
class Dialog_Chat_Loader
{


    /**
     * The array of actions registered with WordPress.
     *
     * @since  1.0.0
     * @access protected
     * @var    array $actions actions fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @since  1.0.0
     * @access protected
     * @var    array    $filters    Filters fire when the plugin loads.
     */
    protected $filters;

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param string $hook          Name of action that is being registered.
     * @param object $component     Instance of object on which action is defined.
     * @param string $callback      Function definition on the $component.
     * @param int    $priority      Optional. The priority when should be fired.
     * @param int    $accepted_args Optional. The number of arguments.
     * 
     * @since  1.0.0
     * @return NULL
     */
    public function addAction( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) //phpcs:ignore
    {
        $this->actions = $this->_add(
            $this->actions, 
            $hook, 
            $component, 
            $callback, 
            $priority, 
            $accepted_args
        );
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param string $hook          Name of action that is being registered.
     * @param object $component     Instance of object on which action is defined.
     * @param string $callback      Function definition on the $component.
     * @param int    $priority      Optional. The priority when should be fired.
     * @param int    $accepted_args Optional. The number of arguments.
     * 
     * @since  1.0.0
     * @return NULL
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) //phpcs:ignore
    {
        $this->filters = $this->_add($this->filters, $hook, $component, $callback, $priority, $accepted_args); //phpcs:ignore
    }

    /**
     * A utility function that is used to register the actions and 
     * hooks into a single collection.
     * 
     * @param array  $hooks         Collection of hooks that is being registered.
     * @param string $hook          Name of action that is being registered.
     * @param object $component     Instance of object on which action is defined.
     * @param string $callback      Function definition on the $component.
     * @param int    $priority      Optional. The priority when should be fired.
     * @param int    $accepted_args Optional. The number of arguments.
     * 
     * @access private
     * 
     * @since  1.0.0
     * @return array Collection of actions and filters registered with WordPress.
     */
    private function _add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) //phpcs:ignore
    {

        $hooks[] = array(
        'hook'          => $hook,
        'component'     => $component,
        'callback'      => $callback,
        'priority'      => $priority,
        'accepted_args' => $accepted_args,
        );

        return $hooks;
    }

    /**
     * Register the filters and actions with WordPress.
     *
     * @since  1.0.0
     * @return NULL
     */
    public function run()
    {

        foreach ( $this->filters as $hook ) {
            add_filter($hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args']); //phpcs:ignore
        }

        foreach ( $this->actions as $hook ) {
            add_action($hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args']); //phpcs:ignore
        }
    }
}
