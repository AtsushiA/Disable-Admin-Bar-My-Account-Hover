<?php
/**
 * Plugin Name: Disable Admin Bar My Account Hover
 * Plugin URI: https://next-season.net
 * Description: アドミンバーのトップセカンダリメニューのマウスオーバー機能を無効化します
 * Version: 1.0.0
 * Author: NExT-Season
 * Author URI: https://next-season.net
 * License: GPL v2 or later
 * Text Domain: disable-adminbar-my-account-hover
 */

if (!defined('ABSPATH')) {
    exit;
}

class Disable_AdminBar_Hover {

    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_styles'));
    }

    public function enqueue_admin_styles() {
        if (is_admin_bar_showing()) {
            wp_add_inline_style('admin-bar', $this->get_custom_css());
        }
    }

    public function enqueue_frontend_styles() {
        if (is_admin_bar_showing()) {
            wp_enqueue_style('admin-bar');
            wp_add_inline_style('admin-bar', $this->get_custom_css());
        }
    }

    private function get_custom_css() {
        return '
            /* アドミンバーのトップセカンダリメニューのホバー効果を無効化 */
            #wpadminbar #wp-admin-bar-top-secondary > .menupop:hover > .ab-item,
            #wpadminbar #wp-admin-bar-top-secondary > .menupop.hover > .ab-item {
                background: transparent !important;
            }

            /* サブメニューを非表示 */
            #wpadminbar #wp-admin-bar-top-secondary .menupop > .ab-sub-wrapper {
                display: none !important;
            }

            /* ホバー時のポインターイベントを無効化 */
            #wpadminbar #wp-admin-bar-top-secondary .menupop {
                pointer-events: none !important;
            }

            /* リンク自体のクリックは有効にする */
            #wpadminbar #wp-admin-bar-top-secondary .menupop > .ab-item {
                pointer-events: auto !important;
            }
        ';
    }
}

new Disable_AdminBar_Hover();
