<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Form_Section extends Customize_Model
{
    public function __construct()
    {
        $this->form_customizer();
    }

    public function get_defaults()
    {
        return [
            'login_form_bg_type'  => 'color',
            'login_form_bg_color' => array(
                'background-color'      => '',
                'background-position'   => 'center center',
                'background-repeat'     => 'repeat-x',
                'background-attachment' => 'fixed',
                'background-size'       => 'cover',
            ),
            'login_form_bg_gradient' =>  array(
                'background-color'              => '#009e44',
                'background-gradient-color'     => '#81d742',
                'background-gradient-direction' => '135deg'
            ),
            'login_form_height_width' =>  array(
                'width'  => '',
                'height' => '',
                'unit'   => 'px',
            ),
            'login_form_margin'        => '',
            'login_form_padding'       => '',
            'login_form_border'        => '',
            'login_form_border_radius' => '',
            'login_form_box_shadow'    => array(
                'bs_color'      => 'transparent',
                'bs_hz'         => '',
                'bs_ver'        => '',
                'bs_blur'       => '',
                'bs_spread'     => '',
                'bs_spread_pos' => '',
            )
        ];
    }


    /**
     * Login Form Box Shadow
     *
     * @param [type] $login_form_box_shadow
     *
     * @return void
     */
    public function login_form_box_shadow_settings(&$login_form_box_shadow)
    {

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_box_shadow[] = array(
                'id'      => 'bs_color',
                'type'    => 'color',
                'title'   => __('Color', WP_ADMINIFY_TD),
                'default' => $this->get_default_field('login_form_box_shadow')['bs_color'],
                'class'   => 'wp-adminify-cs',
            );
        } else {
            $login_form_box_shadow[] = array(
                'type'       => 'notice',
                'title'   => __('Color', WP_ADMINIFY_TD),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_box_shadow[] = array(
                'id'      => 'bs_hz',
                'type'    => 'slider',
                'title'   => __('Horizontal', WP_ADMINIFY_TD),
                'default' => $this->get_default_field('login_form_box_shadow')['bs_hz'],
            );
        } else {
            $login_form_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Horizontal', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_box_shadow[] = array(
                'id'      => 'bs_ver',
                'type'    => 'slider',
                'title'   => __('Vertical', WP_ADMINIFY_TD),
                'default' => $this->get_default_field('login_form_box_shadow')['bs_ver'],
            );
        } else {
            $login_form_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Vertical', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_box_shadow[] = array(
                'id'      => 'bs_blur',
                'type'    => 'slider',
                'title'   => __('Blur', WP_ADMINIFY_TD),
                'default' => $this->get_default_field('login_form_box_shadow')['bs_blur'],
            );
        } else {
            $login_form_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Blur', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_box_shadow[] = array(
                'id'      => 'bs_spread',
                'type'    => 'slider',
                'title'   => __('Spread', WP_ADMINIFY_TD),
                'default' => $this->get_default_field('login_form_box_shadow')['bs_spread'],
            );
        } else {
            $login_form_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Spread', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_box_shadow[] = array(
                'id'      => 'bs_spread_pos',
                'type'    => 'select',
                'title'   => __('Position', WP_ADMINIFY_TD),
                'options' => array(
                    ''      => 'Outline',
                    'inset' => 'Inset'
                ),
                'default' => $this->get_default_field('login_form_box_shadow')['bs_spread_pos'],
            );
        } else {
            $login_form_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Position', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }
    }

    /**
     * Login Form Settings
     */
    public function login_form_settings(&$login_form_settings)
    {

        $login_form_box_shadow = [];
        $this->login_form_box_shadow_settings($login_form_box_shadow);

        $login_form_settings[] = array(
            'type'    => 'subheading',
            'content' => __('Background', WP_ADMINIFY_TD),
        );

        $login_form_settings[] = array(
            'id'      => 'login_form_bg_type',
            'type'    => 'button_set',
            'options' => array(
                'color'    => __('Color & Image', WP_ADMINIFY_TD),
                'gradient' => __('Gradient', WP_ADMINIFY_TD),

            ),
            'default' => $this->get_default_field('login_form_bg_type'),
        );

        $login_form_settings[] = array(
            'id'         => 'login_form_bg_color',
            'type'       => 'background',
            'title'      => __('Background', WP_ADMINIFY_TD),
            'default'    => $this->get_default_field('login_form_bg_color'),
            'dependency' => array('login_form_bg_type', '==', 'color', 'all'),
        );



        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_settings[] = array(
                'id'                    => 'login_form_bg_gradient',
                'type'                  => 'background',
                'title'                 => __('Background Option with Gradient Color', WP_ADMINIFY_TD),
                'background_color'      => true,
                'background_image'      => false,
                'background_position'   => false,
                'background_repeat'     => false,
                'background_attachment' => false,
                'background_size'       => false,
                'background_origin'     => false,
                'background_clip'       => false,
                'background_blend_mode' => false,
                'background_gradient'   => true,
                'default'               => $this->get_default_field('login_form_bg_gradient'),
                'dependency'            => array('login_form_bg_type', '==', 'gradient', 'all'),
            );
        } else {
            $login_form_settings[] = array(
                'type'       => 'notice',
                'title'      => __('Background Option with Gradient Color', WP_ADMINIFY_TD),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array('login_form_bg_type', '==', 'gradient', 'all'),
            );
        }



        $login_form_settings[] = array(
            'type'    => 'subheading',
            'content' => __('Form Width & Height', WP_ADMINIFY_TD),
        );

        $login_form_settings[] = array(
            'id'      => 'login_form_height_width',
            'type'    => 'dimensions',
            'title'   => __('Width & Height', WP_ADMINIFY_TD),
            'default' => $this->get_default_field('login_form_height_width'),
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_settings[] = array(
                'id'      => 'login_form_margin',
                'title'   => __('Margin', WP_ADMINIFY_TD),
                'type'    => 'spacing',
                'default' => $this->get_default_field('login_form_margin'),
            );
        } else {
            $login_form_settings[] = array(
                'type'       => 'notice',
                'title'   => __('Margin', WP_ADMINIFY_TD),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_settings[] = array(
                'id'      => 'login_form_padding',
                'title'   => __('Padding', WP_ADMINIFY_TD),
                'type'    => 'spacing',
                'default' => $this->get_default_field('login_form_padding'),
            );
        } else {
            $login_form_settings[] = array(
                'type'       => 'notice',
                'title'   => __('Padding', WP_ADMINIFY_TD),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }

        $login_form_settings[] = array(
            'type'  => 'subheading',
            'title' => __('Border', WP_ADMINIFY_TD),
        );

        $login_form_settings[] = array(
            'id'      => 'login_form_border',
            'type'    => 'border',
            'default' => $this->get_default_field('login_form_border'),
            'title'   => __('Border', WP_ADMINIFY_TD),
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_settings[] = array(
                'id'      => 'login_form_border_radius',
                'type'    => 'spacing',
                'default' => $this->get_default_field('login_form_border_radius'),
                'title'   => __('Border Radius', WP_ADMINIFY_TD)
            );
        } else {
            $login_form_settings[] = array(
                'type'    => 'notice',
                'title'   => __('Border Radius', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }



        $login_form_settings[] = array(
            'type'    => 'subheading',
            'content' => __('Box Shadow', WP_ADMINIFY_TD)
        );


        $login_form_settings[] = array(
            'id'     => 'login_form_box_shadow',
            'type'   => 'fieldset',
            'fields' => $login_form_box_shadow
        );
    }


    public function form_customizer()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $login_form_settings = [];
        $this->login_form_settings($login_form_settings);

        /**
         * Section: Form Options
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'jltwp_adminify_customizer_login_form_section',
                'title'  => __('Login Form', WP_ADMINIFY_TD),
                'fields' => $login_form_settings
            )
        );
    }
}
