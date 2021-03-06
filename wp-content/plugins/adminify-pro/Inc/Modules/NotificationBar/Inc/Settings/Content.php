<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Notification_Customize;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Content extends Notification_Customize
{
    public function __construct()
    {
        $this->content_notif_bar_customizer();
    }


    public function get_defaults()
    {
        return [
            'notif_bar_content_section'   => array(
                'notif_bar_content'  => 'This is your default message which you can use to announce a sale or discount.',
                'show_notif_bar_btn' => false,
                'notif_btn'          => 'Learn More',
                'notif_btn_url'      => array(
                    'url'    => 'https://wordpress.org/plugins/adminify/',
                    'text'   => __('WP Adminify', WP_ADMINIFY_TD),
                    'target' => '_blank'
                ),
                'mobile_show_notif_bar_content' => false,
                'mobile_notif_bar_content'      => __('This is your default message which you can use to announce a sale or discount.', WP_ADMINIFY_TD),
                'mobile_show_notif_bar_btn'     => false,
                'mobile_notif_btn'              => '',
                'mobile_notif_btn_url'          => '',
                'mobile_show_btn_close'         => true,
            ),
            'typography_sets'     => array(
                'color'       => '#fff',
                'font-family' => 'inherit',
                'font-size'   => '12',
                'unit'        => 'px',
                'type'        => 'google',
            ),
        ];
    }



    /**
     * Notification Bar: Content Section
     */
    public function content_notif_bar_settings(&$content_notif_settings)
    {
        $desktop_fields = [];
        $this->notif_bar_desktop_fields($desktop_fields);
        // $mobile_fields = [];
        // $this->notif_bar_mobile_fields($mobile_fields);

        $content_notif_settings[] = array(
            'id'   => 'notif_bar_content_section',
            'type' => 'tabbed',
            'tabs' => array(
                array(
                    'title'  => __('Content', WP_ADMINIFY_TD),
                    'fields' => $desktop_fields
                ),
                // array(
                //     'title'  => __('Mobile', WP_ADMINIFY_TD),
                //     'fields' => $mobile_fields
                // )
            )
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $content_notif_settings[] = array(
                'id'             => 'typography_sets',
                'type'           => 'typography',
                'title'          => __('Fonts Settings', WP_ADMINIFY_TD),
                'text_align'     => false,
                'text_transform' => false,
                'font_size'      => true,
                'font_weight'    => false,
                'line_height'    => false,
                'letter_spacing' => false,
                'color'          => false,
                'default'        => $this->get_default_field('typography_sets')
            );
        } else {
            $content_notif_settings[] = array(
                'type'    => 'notice',
                'title'   => __('Font Settings', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }
    }


    public function notif_bar_desktop_fields(&$desktop_fields)
    {
        $desktop_fields[] = array(
            'id'      => 'notif_bar_content',
            'type'    => 'textarea',
            'title'   => __('Content', WP_ADMINIFY_TD),
            'help'    => __('Notification Bar contents here', WP_ADMINIFY_TD),
            'default' => $this->get_default_field('notif_bar_content_section')['notif_bar_content'],
            // 'dependency' => array('show_notif_bar', '==', 'true', true),
        );
        $desktop_fields[] = array(
            'id'       => 'show_notif_bar_btn',
            'type'     => 'switcher',
            'title'    => __('Show "Learn More" Button?', WP_ADMINIFY_TD),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
            'default'  => $this->get_default_field('notif_bar_content_section')['show_notif_bar_btn'],
            // 'dependency' => array('show_notif_bar', '==', 'true', true),
        );
        $desktop_fields[] = array(
            'id'         => 'notif_btn',
            'type'       => 'text',
            'title'      => __('Button Text', WP_ADMINIFY_TD),
            'default'    => $this->get_default_field('notif_bar_content_section')['notif_btn'],
            'dependency' => array('show_notif_bar_btn', '==', 'true', true),
        );

        $desktop_fields[] = array(
            'id'         => 'notif_btn_url',
            'type'       => 'link',
            'title'      => __('Button URL', WP_ADMINIFY_TD),
            'default'    => $this->get_default_field('notif_bar_content_section')['notif_btn_url'],
            'add_title'  => __('Button Link', WP_ADMINIFY_TD),
            'dependency' => array('show_notif_bar_btn', '==', 'true', true),
        );
    }


    public function notif_bar_mobile_fields(&$mobile_fields)
    {
        $mobile_fields[] = array(
            'id'       => 'mobile_show_notif_bar_content',
            'type'     => 'switcher',
            'title'    => __('Show Different Content on Mobile?', WP_ADMINIFY_TD),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
            'default'  => $this->get_default_field('notif_bar_content_section')['mobile_show_notif_bar_content'],
        );

        $mobile_fields[] = array(
            'id'         => 'mobile_notif_bar_content',
            'type'       => 'textarea',
            'title'      => __('Content', WP_ADMINIFY_TD),
            'help'       => __('Notification Bar contents here', WP_ADMINIFY_TD),
            'default'    => $this->get_default_field('notif_bar_content_section')['mobile_notif_bar_content'],
            'dependency' => array('mobile_show_notif_bar_content', '==', 'true', true),
        );
        $mobile_fields[] = array(
            'id'         => 'mobile_show_notif_bar_btn',
            'type'       => 'switcher',
            'title'      => __('Show Button?', WP_ADMINIFY_TD),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'class'      => 'wp-adminify-cs',
            'default'    => $this->get_default_field('notif_bar_content_section')['mobile_show_notif_bar_btn'],
            'dependency' => array('mobile_show_notif_bar_content', '==', 'true', true),
        );

        $mobile_fields[] = array(
            'id'         => 'mobile_notif_btn',
            'type'       => 'text',
            'title'      => __('Button Text', WP_ADMINIFY_TD),
            'default'    => $this->get_default_field('notif_bar_content_section')['mobile_notif_btn'],
            'dependency' => array('mobile_show_notif_bar_btn|mobile_show_notif_bar_content', '==|==', 'true|true', true),
        );

        $mobile_fields[] = array(
            'id'         => 'mobile_notif_btn_url',
            'type'       => 'link',
            'title'      => __('Button URL', WP_ADMINIFY_TD),
            'default'    => $this->get_default_field('notif_bar_content_section')['mobile_notif_btn_url'],
            'dependency' => array('mobile_show_notif_bar_btn|mobile_show_notif_bar_content', '==|==', 'true|true', true),
        );

        $mobile_fields[] = array(
            'id'       => 'mobile_show_btn_close',
            'type'     => 'switcher',
            'title'    => __('Show Close Button?', WP_ADMINIFY_TD),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
            'default'  => $this->get_default_field('notif_bar_content_section')['mobile_show_btn_close'],
        );
    }

    /**
     * Notification bar: Content
     *
     * @return void
     */
    public function content_notif_bar_customizer()
    {

        $content_notif_settings = [];
        $this->content_notif_bar_settings($content_notif_settings);

        /**
         * Section: Content Settings
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'content_section',
                'title'  => __('Content Section', WP_ADMINIFY_TD),
                'fields' => $content_notif_settings
            )
        );
    }
}
