<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class DashboardWidgets extends AdminSettingsModel
{
    public function __construct()
    {
        $this->dasboard_widgets_settings();
    }

    public function get_defaults()
    {
        return [
            'dashboard_widgets' => [
                'dashboard_widgets_user_roles' => [],
                'dashboard_widgets_list'       => []
            ]
        ];
    }

    public function dasboard_widgets_settings()
    {

        if (!class_exists('ADMINIFY')) {
            return;
        }

        // Dashboard Widgets Section
        \ADMINIFY::createSection($this->prefix, array(
            'title'  => __('Dashboard Widgets', WP_ADMINIFY_TD),
            'icon'   => 'dashicons dashicons-dashboard',
            'parent' => 'widget_settings',
            'id'     => 'dashboard_widgets',
            'fields' => array(
                array(
                    'type'    => 'subheading',
                    'content'   => Utils::adminfiy_help_urls(
                        __('Dashboard Widgets Settings', WP_ADMINIFY_TD),
                        'https://wpadminify.com/kb/wp-widget-settings/',
                        'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                        'https://www.facebook.com/groups/jeweltheme',
                        'https://wpadminify.com/support/'
                    )
                ),
                array(
                    'id'          => 'dashboard_widgets_user_roles',
                    'type'        => 'select',
                    'title'       => __('Visible for', WP_ADMINIFY_TD),
                    'placeholder' => __('Select User roles you want to show', WP_ADMINIFY_TD),
                    'options'     => 'roles',
                    'multiple'    => true,
                    'chosen'      => true,
                    'default'     => $this->get_default_field('dashboard_widgets')['dashboard_widgets_user_roles'],
                ),
                array(
                    'id'      => 'dashboard_widgets_list',
                    'type'    => 'checkbox',
                    'title'   => __('Remove unwanted Widgets', WP_ADMINIFY_TD),
                    'options' => '\WPAdminify\Inc\Classes\DashboardWidgets::render_dashboard_checkboxes',
                    'default' => $this->get_default_field('dashboard_widgets')['dashboard_widgets_list'],
                )

            )
        ));
    }
}
