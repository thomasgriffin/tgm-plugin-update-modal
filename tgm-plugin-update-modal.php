<?php
/**
 * Plugin Name: TGM Plugin Update Modal
 * Plugin URI:  https://github.com/thomasgriffin/tgm-plugin-update-modal
 * Description: This plugin gives a solid example for how to use the new WordPress 4.0 plugin update modal.
 * Author:      Thomas Griffin
 * Author URI:  http://thomasgriffin.io
 * Version:     1.0.0
 * Text Domain: tgm-pum
 * Domain Path: languages
 *
 * This plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this plugin. If not, see <http://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main class for the plugin.
 *
 * @since 1.0.0
 *
 * @package TGM_Plugin_Update_Modal
 * @author  Thomas Griffin
 */
class TGM_Plugin_Update_Modal {

	/**
     * Holds the plugin slug to query.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $plugin_slug = 'soliloquy-lite';

	/**
     * Holds the plugin section to query.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $section = 'changelog';

    /**
     * Constructor for the class.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Load the plugin textdomain.
        load_plugin_textdomain( 'tgm-pum', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Load our custom assets.
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

        // Generate the custom metabox to hold our example media manager.
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

    }

    /**
     * Loads any plugin assets we may have.
     *
     * @since 1.0.0
     *
     * @return null Return early if not on a page add/edit screen
     */
    public function assets() {

        // Bail out early if we are not on a page add/edit screen.
        if ( ! ( 'post' == get_current_screen()->base && 'page' == get_current_screen()->id ) ) {
            return;
        }

        // Loads in the required media files for the plugin update modal.
        wp_enqueue_style( 'plugin-install' );
        wp_enqueue_script( 'plugin-install' );

        // Register and enqueue our custom JS.
        wp_register_script( 'tgm-pum', plugins_url( '/js/modal.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'tgm-pum' );

    }

    /**
     * Create the custom metabox.
     *
     * @since 1.0.0
     */
    public function add_meta_boxes() {

        // This metabox will only be loaded for pages.
        add_meta_box( 'tgm-plugin-update-modal', __( 'TGM Plugin Update Modal Settings', 'tgm-pum' ), array( $this, 'metabox' ), 'page', 'normal', 'high' );

    }

    /**
     * Callback function to output our custom settings page.
     *
     * @since 1.0.0
     *
     * @param object $post Current post object data
     */
    public function metabox( $post ) {

        echo '<div id="tgm-plugin-update-modal-settings">';
            echo '<p>' . __( 'Click on the button below to open up the new WordPress 4.0 plugin update modal. You can view the code in the plugin to get an idea of what you need to create your own custom links. The important piece is the URL itself and the tgm-plugin-update-modal class on the link.', 'tgm-pum' ) . '</p>';
            echo '<p><a href="' . add_query_arg( array( 'tab' => 'plugin-information', 'plugin' => $this->plugin_slug, 'section' => $this->section, 'TB_iframe' => true, 'width' => 722, 'height' => 949 ), admin_url( 'plugin-install.php' ) ) . '" class="button button-primary tgm-plugin-update-modal" title="' . esc_attr__( 'Click Here to Open the Plugin Update Modal', 'tgm-pum' ) . '">' . __( 'Click Here to Open the Plugin Update Modal', 'tgm-pum' ) . '</a></p>';
        echo '</div>';

    }

}

// Instantiate the class.
$tgm_plugin_update_modal = new TGM_Plugin_Update_Modal();