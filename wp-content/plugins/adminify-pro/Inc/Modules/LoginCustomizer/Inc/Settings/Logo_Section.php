<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

// Cannot access directly.
if (!defined('ABSPATH')) die;

class Logo_Section extends Customize_Model
{

    public function __construct()
    {
        $this->logo_section_customizer();
    }

    public function get_defaults()
    {

        return [
            'show_logo'      => true,
            'logo_settings'  => 'image-only',
            'logo_image'     => '',
            'logo_text'      => 'Website Name',
            'logo_login_url' => array(
                'url'    => 'https://wpadminify.com',
                'text'   => 'WP Adminify',
                'target' => '_blank'
            ),
            'login_page_title'  => '',
            'login_title_style' => array(
                'logo_heigh_width' => array(
                    'width'  => '100',
                    'height' => '50',
                    'unit'   => '%',
                ),
                'login_title_typography' => array(
                    'font-family' => 'Lato',
                    'font-weight' => '900',
                    'subset'      => 'latin',
                    'type'        => 'google',
                ),
                'logo_padding' => array(
                    'top'    => '',
                    'right'  => '',
                    'bottom' => '',
                    'left'   => ''
                )
            ),
        ];
    }


    public function logo_section_settings(&$logo_settings)
    {
        $login_title_style = [];
        $this->login_title_style_settings($login_title_style);

        $logo_settings[] =  array(
            'id'       => 'show_logo',
            'type'     => 'switcher',
            'title'    => __('Display Logo?', WP_ADMINIFY_TD),
            'default'  => $this->get_default_field('show_logo'),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
        );

        $logo_settings[] =  array(
            'id'      => 'logo_settings',
            'type'    => 'button_set',
            'title'   => __('Logo Type', WP_ADMINIFY_TD),
            'help'    => __('Select the way you want to display Logo', WP_ADMINIFY_TD),
            'options' => array(
                'text-only'  => __('Text', WP_ADMINIFY_TD),
                'image-only' => __('Image', WP_ADMINIFY_TD),
                'both'       => __('Image & Text', WP_ADMINIFY_TD),
                'none'       => __('None', WP_ADMINIFY_TD)
            ),
            'default'    => $this->get_default_field('logo_settings'),
            'dependency' => array('show_logo', '==', 'true'),
        );

        $logo_settings[] =  array(
            'id'           => 'logo_image',
            'type'         => 'media',
            'title'        => __('Logo Image', WP_ADMINIFY_TD),
            'library'      => 'image',
            'preview'      => true,
            'preview_size' => 'full',
            'dependency'   => array(
                array('show_logo|logo_settings|logo_settings', '==|!=|!=', 'true|text-only|none')
            ),
        );

        $logo_settings[] =  array(
            'id'          => 'logo_text',
            'type'        => 'text',
            'title'       => __('Text Logo', WP_ADMINIFY_TD),
            'default'     => $this->get_default_field('logo_text'),
            'placeholder' => __('Enter Logo Text here', WP_ADMINIFY_TD),
            'dependency'  => array(
                array('show_logo|logo_settings|logo_settings', '==|!=|!=', 'true|image-only|none', true)
            ),
        );

        $logo_settings[] =  array(
            'id'         => 'logo_login_url',
            'type'       => 'link',
            'title'      => 'Logo Link',
            'default'    => $this->get_default_field('logo_login_url'),
            'dependency' => array(
                array('show_logo|logo_settings', '==|!=', 'true|none')
            )
        );

        $logo_settings[] =  array(
            'id'          => 'login_page_title',
            'type'        => 'text',
            'title'       => __('Login Page Title', WP_ADMINIFY_TD),
            'placeholder' => __('Enter Login Page Title here', WP_ADMINIFY_TD)
        );

        $logo_settings[] =  array(
            'type'       => 'heading',
            'content'    => __('Logo Style', WP_ADMINIFY_TD),
            'dependency' => array(
                array('show_logo', '==', 'true')
            ),
        );

        $logo_settings[] =  array(
            'id'         => 'login_title_style',
            'type'       => 'fieldset',
            'dependency' => array(
                array('show_logo', '==', 'true')
            ),
            'fields' => $login_title_style,
        );
    }

    public function login_title_style_settings(&$login_title_style)
    {
        $login_title_style[] = array(
            'id'          => 'logo_heigh_width',
            'type'        => 'dimensions',
            'width_icon'  => 'width',
            'height_icon' => 'height',
            'units'       => array('px', '%', 'em', 'rem', 'pt'),
            'default'     => $this->get_default_field('login_title_style')['logo_heigh_width'],
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_title_style[] = array(
                'id'                 => 'login_title_typography',
                'type'               => 'typography',
                'title'              => __('Title Typography', WP_ADMINIFY_TD),
                'font_family'        => true,
                'font_weight'        => true,
                'font_style'         => true,
                'font_size'          => true,
                'line_height'        => true,
                'letter_spacing'     => true,
                'text_align'         => false,
                'text-transform'     => true,
                'color'              => true,
                'subset'             => false,
                'backup_font_family' => false,
                'font_variant'       => false,
                'word_spacing'       => false,
                'text_decoration'    => true,
                'default'            => $this->get_default_field('login_title_style')['login_title_typography'],
                'dependency'         => array(
                    array('show_logo', '==', 'true'),
                    array('logo_settings', '==', 'text-only', true)
                ),
            );
        } else {
            $login_title_style[] = array(
                'type'    => 'notice',
                'title'   => __('Title Typography', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(),
                'dependency'         => array(
                    array('show_logo', '==', 'true'),
                    array('logo_settings', '==', 'text-only', true)
                ),
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_title_style[] = array(
                'id'      => 'logo_padding',
                'type'    => 'spacing',
                'title'   => __('Padding', WP_ADMINIFY_TD),
                'default' => $this->get_default_field('login_title_style')['logo_padding'],
            );
        } else {
            $login_title_style[] = array(
                'type'    => 'notice',
                'title'   => __('Padding', WP_ADMINIFY_TD),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }
    }

    public function logo_section_customizer()
    {

        if (!class_exists('ADMINIFY')) return;

        $logo_settings = [];
        $this->logo_section_settings($logo_settings);

        /**
         * Section: Logo Section
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'jltwp_adminify_customizer_logo_section',
                'title'  => __('Logo', WP_ADMINIFY_TD),
                'fields' => $logo_settings
            )
        );
    }
}
