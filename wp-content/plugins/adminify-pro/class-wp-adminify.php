<?php

namespace WPAdminify;

use WPAdminify\Inc\Classes\Assets;
use WPAdminify\Inc\Admin\Admin;
use WPAdminify\Inc\Admin\AdminSettings;

// No, Direct access Sir !!!
if (!defined('ABSPATH')) exit;

if (!class_exists('WP_Adminify')) {

    class WP_Adminify
    {

        const VERSION = WP_ADMINIFY_VER;
        private static $instance = null;

        public function __construct()
        {
            add_action('plugins_loaded', [$this, 'jltwp_adminify_plugins_loaded'], 999);
            add_filter('plugin_action_links_' . WP_ADMINIFY_BASE, [$this, 'plugin_action_links']);
            add_filter('network_admin_plugin_action_links_' . WP_ADMINIFY_BASE, [$this, 'plugin_action_links']);

            add_filter('admin_body_class', [$this, 'jltwp_adminify_body_class']);
            $this->jltwp_is_plugin_row_meta();
            $this->jltwp_adminify_include_files();
            //jltwp_adminify()->add_filter('freemius_pricing_js_path', [$this, 'jltwp_new_freemius_pricing_js']);
        }

        public function jltwp_is_plugin_row_meta()
        {
            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                if (jltwp_adminify()->is_plan__premium_only('agency')) {
                    $jltwp_adminify_wl_plugin_row_links = AdminSettings::get_instance()->get('jltwp_adminify_wl_plugin_row_links');
                    if (!empty($jltwp_adminify_wl_plugin_row_links)) {
                        return;
                    } else {
                        add_filter('plugin_row_meta', [$this, 'jltwp_adminify_plugin_row_meta'], 10, 2);
                        add_filter('network_admin_plugin_row_meta', [$this, 'jltwp_adminify_plugin_row_meta'], 10, 2);
                    }
                }
            } else {
                add_filter('plugin_row_meta', [$this, 'jltwp_adminify_plugin_row_meta'], 10, 2);
                add_filter('network_admin_plugin_row_meta', [$this, 'jltwp_adminify_plugin_row_meta'], 10, 2);
            }
        }
        /**
         * Add Body Class
         */
        public function jltwp_adminify_body_class($classes)
        {
            $classes .= ' wp-adminify ';

            if (is_rtl()) {
                $classes .= ' adminify-rtl ';
            }
            return $classes;
        }


        /**
         * Plugin action links
         *
         * @param   array  $links
         *
         * @return array
         */
        public function plugin_action_links($links)
        {
            $links[] = sprintf(
                '<a class="adminify-plugin-settings" href="%1$s">%2$s</a>',
                admin_url('admin.php?page=wp-adminify-settings'),
                __('Settings', WP_ADMINIFY_TD)
            );

            // Check If Pro/Free
            if (!jltwp_adminify()->can_use_premium_code__premium_only()) {
                $links[] = sprintf(
                    '<a href="%1$s" class="adminify-upgrade-pro" target="_blank" style="color: orangered;font-weight: bold;">%2$s</a>',
                    'https://wpadminify.com/pricing',
                    __('Go Pro', WP_ADMINIFY_TD)
                );
            }

            return $links;
        }

        public function jltwp_adminify_plugin_row_meta($plugin_meta, $plugin_file)
        {
            if (WP_ADMINIFY_BASE === $plugin_file) {
                $row_meta = [
                    'docs' => sprintf(
                        '<a href="%1$s" target="_blank">%2$s</a>',
                        esc_url_raw('https://wpadminify.com/kb'),
                        __('Docs', WP_ADMINIFY_TD)
                    ),
                    'changelogs' => sprintf(
                        '<a href="%1$s" target="_blank">%2$s</a>',
                        esc_url_raw('https://wpadminify.com/changelogs/'),
                        __('Changelogs', WP_ADMINIFY_TD)
                    ),
                    'tutorials' => '<a href="https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8" aria-label="' . esc_attr(__('View WP Adminify Video Tutorials', WP_ADMINIFY_TD)) . '" target="_blank">' . __('Video Tutorials', WP_ADMINIFY_TD) . '</a>',
                ];

                $plugin_meta = array_merge($plugin_meta, $row_meta);
            }

            return $plugin_meta;
        }

        public function jltwp_adminify_plugins_loaded()
        {
            self::jltwp_adminify_activation_hook();
        }

        public function jltwp_adminify_include_files()
        {
            new Assets();
            new Admin();

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                if (!class_exists('Adminify_Pro')) {
                    new \WPAdminify\Pro\Classes\Adminify_Pro();
                }
            }
        }


        public function jltwp_adminify_init()
        {

            $this->jltwp_adminify_load_textdomain();

            //Redirect Hook
            // add_action('admin_init', [$this, 'jltwp_adminify_redirect_hook']);
        }

        // Text Domains
        public function jltwp_adminify_load_textdomain()
        {
            $domain = 'wp-adminify';
            $locale = apply_filters('plugin_locale', get_locale(), $domain);

            load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
            load_plugin_textdomain($domain, false, dirname(WP_ADMINIFY_BASE) . '/languages/');
        }


        /*
		 * Activation Plugin redirect hook
		 */
        public function jltwp_adminify_redirect_hook()
        {
            wp_redirect('admin.php?page=wp-adminify-settings');
            exit;
        }


        // Activation Hook
        public static function jltwp_adminify_activation_hook()
        {
            if (get_option('jltwp_adminify_activation_time') === false)
                update_option('jltwp_adminify_activation_time', strtotime("now"));

            update_option('wp_adminify_version', self::VERSION);
        }



        // Deactivation Hook
        public static function jltwp_adminify_deactivation_hook()
        {
            delete_option('jltwp_adminify_activation_time');
            delete_option('jltwp_adminify_customizer_flush_url');
        }

        public function jltwp_new_freemius_pricing_js($default_pricing_js_path)
        {
            return WP_ADMINIFY_PATH . '/lib/freemius-pricing/freemius-pricing.js';
        }


        /**
         * Returns the singleton instance of the class.
         */

        public static function get_instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof WP_Adminify)) {
                self::$instance = new WP_Adminify();
                self::$instance->jltwp_adminify_init();
            }

            return self::$instance;
        }
    }

    WP_Adminify::get_instance();
}
