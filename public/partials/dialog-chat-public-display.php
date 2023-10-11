<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * php version 8.2.0
 *
 * @category   Dialog_Chat
 * @package    Dialog_Chat
 * @subpackage Dialog_Chat/public/partials
 * @author     Falcon Plugins <falcon@dialog-chat.com>
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link       https://dialog-chat.com
 * @since      1.0.0
 */

// Public view of WhatsApp dialog chat.
add_action('init', 'Show_data');

/**
 * Fires on init hook. This function is solely responsible for front-end renders.
 *
 * @since  1.0.0
 * @return NULL
 */
function Show_data()
{

    global $wpdb;

    $dc_options = get_option('dc_admin_settings');

    $dc_whatsapp_accounts = get_posts(
        array(
        'post_type'   => 'dialog-chat',
        'post_status' => 'publish',
        'numberposts' => -1,
        )
    );

    if (! current_user_can('manage_options') && empty($dc_whatsapp_accounts) ) {
        return;
    }

    $dc_widget_icon = wp_get_attachment_image_src(
        $dc_options['design']['close_widget_button'],
        'thumbnail'
    )[0]
    ??
    DC_WHATSAPP_WIDGET_ICON;

    $dc_allowed_esc_tags = array( 'p' => array(), 'strong' => array() );

    ob_start();

    ?>
        <div class="dc_whatsapp_chat_wrap">
            <style scoped>
                .dc_chat_popup__text {
                    background-color:<?php echo $dc_options['design']['close_title_bg_color']; //phpcs:ignore ?>;
                }

                .dc_chat_popup__text span{
					color:<?php echo $dc_options['design']['close_title_color']; //phpcs:ignore ?>;
                    font-size:<?php echo $dc_options['design']['close_title_size']; //phpcs:ignore ?>px;
                }

                .dc_chat_popup__button,
                .dc_chat__title {
                    background-color:<?php echo $dc_options['design']['close_button_bg_color']; //phpcs:ignore ?>;
                }

                .dc_chat__head_text {
                    font-size:<?php echo $dc_options['design']['widget_title_size']; //phpcs:ignore ?>px;
                }

                .dc_chat__head_texts {
					color:<?php echo $dc_options['design']['widget_title_color']; //phpcs:ignore ?>
                }

                .dc_chat__head_response_time {
					color:<?php echo $dc_options['design']['close_title_color']; //phpcs:ignore ?>
                }

                .dc_account_link_tile {
                    border-left:5px solid <?php echo $dc_options['design']['close_button_bg_color']; //phpcs:ignore ?>;
                }

            </style>
            
            <div class="dc_chat_popup_button" style="display: none;">
                <div class="dc_chat_popup__text">
                    <span>
                        <?php echo esc_html($dc_options['text']['close_title']); ?>
                    </span>
                </div>
                <div class="dc_chat_popup__button">
                    <img 
                        data-src="<?php echo esc_attr($dc_widget_icon); ?>" 
                        src ="<?php echo esc_attr($dc_widget_icon); ?>" 
                    />
                </div>
            </div>

            <div class="dc_chat_popup" style="display: none;">
                <div class="dc_chat__title">
                    <div class="dc_chat__head_texts">
                        <div class="dc_chat__head_text">
                            <?php 
                            echo esc_html(
                                $dc_options['text']['widget_title']
                            );
                            ?>
                        </div>
                        <p class="dc_chat__head_desc">
                            <?php 
                                echo wp_kses( 
                                    $dc_options['text']['widget_description'], 
                                    $dc_allowed_esc_tags 
                                );
                            ?>
                        </p>
                    </div>
                    <div class="dc_chat__brand">
                        <img 
                            data-src="<?php echo esc_html($dc_widget_icon); ?>" 
                            src ="<?php echo esc_html($dc_widget_icon); ?>" 
                        />
                    </div>
                </div>
                <div class="dc_chat__accounts_wrap">
                    <div class="dc_chat__head_response_time">
                        <p class="dc_chat__head_response_text">
                            <?php 
                            echo wp_kses(
                                $dc_options['text']['response_time_text'],
                                $dc_allowed_esc_tags
                            );
                            ?>
                        </p>
                        <div class="dc_chat__accounts">

                            <?php
                            if (empty($dc_whatsapp_accounts) ) {
                                echo "<p class='dc_no_accounts'>";
                                esc_html_e(
                                    "<b>Oops!</b> No accounts found. 
                                    Please add some accounts 
                                    <a target='_blank' href='" .
                                    esc_ul(
                                        admin_url('edit.php?post_type=dialog-chat')
                                    )
                                    . "'>here
                                    </a>",
                                    'dialog-chat'
                                );
                                echo '</p>';
                            }
                            ?>
                            
                            <?php
                            // @codingStandardsIgnoreStart
                            foreach ( $dc_whatsapp_accounts as $dc_whatsapp_account ) { 
            $dc_account_name            = get_post_meta($dc_whatsapp_account->ID, "dc_whatsapp_account_name", true);
            $dc_account_job_post        = get_post_meta($dc_whatsapp_account->ID, "dc_job_post", true);
            $dc_account_number          = get_post_meta($dc_whatsapp_account->ID, "dc_whatsapp_account_number", true);
            $dc_account_avatar          = wp_get_attachment_image_src(get_post_thumbnail_id($dc_whatsapp_account->ID), 'single-post-thumbnail')[0] ?? "";
            $dc_account_availability    = unserialize(get_post_meta($dc_whatsapp_account->ID, "dc_whatsapp_time", true));

            if ( $dc_account_availability ) {
                                    $always_online = ( ! empty( $dc_account_availability["always_online"] ) ) ? "yes" : "no";

                                    $status = "online";

                                    if ("no" === $always_online ) {
                                        
                                        $current_day = date( 'l' );

                                        if ( !empty( $current_day_availability = $dc_account_availability[ strtolower( $current_day ) ] ) ) {

                                            $current_time       = strtotime( date( "H:i" ) );
                                            $availability_from  = strtotime( $current_day_availability['from'] );
                                            $availability_to    = strtotime( $current_day_availability['to'] );

                                            if ( $current_time < $availability_from || $current_time > $availability_to ) {
                                                $status = "offline";
                                            }

                                        }

                                                        }

            }

            // @codingStandardsIgnoreEnd

                                ?>
                            <div class="dc_chat__account">
                                <a 
                                    class="dc_account_link_tile <?php echo $status; //phpcs:ignore ?>" 
                                    target="_blank" 
                                    href="<?php echo ( "offline" === $status ) ? "#" : DC_WHATSAPP_API_URL . $dc_account_number; //phpcs:ignore ?>"
                                >
                                    <div class="dc_chat__account_avatar">
                                        <img 
                                            src="
                                <?php
                            echo !empty($dc_account_avatar) ? $dc_account_avatar : DC_WHATSAPP_WIDGET_ICON; //phpcs:ignore
                                ?>
                                            " />
                                    </div>
                                    <div class="dc_chat__account_info">
                                        <p 
                                            class="dc_chat__account_title">
                                <?php echo $dc_account_name; ?>
                                            <span class="dc_offline_tag">
                                                <?php 
                                                _e('offline', 'dialog-chat');
                                                ?>
                                            </span>
                                        </p>
                                        <p 
                                            class="dc_chat__account_position"
                                        >
                                <?php echo $dc_account_job_post; ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php

    echo ob_get_clean();
}

?>
