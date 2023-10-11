<?php

/**
 * The admin-specific functionality of the plugin.
 * 
 * Metabox functionality regarding maintaining and setting time availability
 * for each users will be done with this class.
 *
 * php version 8.2.0
 *
 * @category Dialog_Chat
 * @package  Dialog_Chat/admin
 * @author   Falcon Plugins <falcon@dialog-chat.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link     https://dialog-chat.com
 * @since    1.0.0
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
class Dialog_Chat_Whatsapp_Acc_Time
{

    /**
     * Settings and maintaining time availabilty per user.
     *
     * @since  1.0.0
     * @return NULL
     */
    public static function whatsappAccTimeMb()
    {

        $dc_days_list = array(
        __('sunday', 'dialog-chat'),
        __('monday', 'dialog-chat'),
        __('tuesday', 'dialog-chat'),
        __('wednesday', 'dialog-chat'),
        __('thursday', 'dialog-chat'),
        __('friday', 'dialog-chat'),
        __('saturday', 'dialog-chat'),
        );

        $dc_time_val = unserialize(get_post_meta(get_the_ID(), 'dc_whatsapp_time', true)); //phpcs:ignore

        ob_start();

        ?>
            <div class="dc_whatsapp_meta_box_time">

                <p class="meta-options dc_always_online">
                    <label for="dc_whatsapp_time[always_online]">
                        <?php _e('Always Show Online', 'dialog-chat'); ?>
                    </label>
                    <input 
                        id="dc_whatsapp_time[always_online]"
                        class="dc_always_online_checkbox"
                        type="checkbox" 
                        name="dc_whatsapp_time[always_online]"
        <?php echo ( ! empty($dc_time_val['always_online']) || ! isset($dc_time_val['always_online']) ) ? "checked='checked'" : ''; //phpcs:ignore ?>>
                </p>
                
        <?php
        foreach ( $dc_days_list as $day ) {
            ?>
            <p class="meta-options dc_whatsapp_meta_time" style="display: none;">
                <label for="dc_whatsapp_time_<?php echo $day; ?>">
                    <?php echo ucfirst($day); ?>
                </label>
                <span>From</span>
                <input id="dc_whatsapp_time_<?php echo $day; ?>" 
                    type="time" 
                    name="dc_whatsapp_time[<?php echo $day; ?>][from]"
                    value="<?php echo $dc_time_val[ $day ]['from']; ?>">
                <span>To</span>
                <input 
                    type="time" 
                    name="dc_whatsapp_time[<?php echo $day; ?>][to]"
                    value="<?php echo $dc_time_val[ $day ]['to']; ?>">
            </p>
            <?php
        }
        ?>
            </div>
        <?php

        echo ob_get_clean();
    }

    /**
     * Save time availabilty per user.
     * 
     * @param $post_id int POST ID for which the time needs to be saved.
     *
     * @since  1.0.0
     * @return NULL
     */
    public static function saveWhatsappAccTimeMb( $post_id )
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }
        if ($parent_id = wp_is_post_revision($post_id) ) {
            $post_id = $parent_id;
        }
        $fields = array(
        'dc_whatsapp_account_number',
        'dc_whatsapp_account_name',
        'dc_job_post',
        );
        foreach ( $fields as $field ) {
            if (array_key_exists($field, $_POST) ) {
                update_post_meta(
                    $post_id, $field, 
                    sanitize_text_field($_POST[ $field ])
                );
            }
        }
    }
}
