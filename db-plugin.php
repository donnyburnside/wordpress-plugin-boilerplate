<?php
/**
 * Plugin Name:
 * Plugin Uri:
 * Description:
 * Version: 1.0.0
 * Author:
 * Author URI:
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'DB_Plugin' ) ) :

    final class DB_Plugin {

        /**
         * @var string
         */

        public $version = '1.0.0';



        /**
         * @var
         * The single instance of the class
         */

        protected static $_instance = null;



        /**
         * Main plugin instance
         *
         * Ensures only one instance of the plugin is loaded or can be loaded.
         *
         * @static
         * @return Main instance
         */

        public static function instance()
        {
            if ( is_null( self::$_instance ) )
            {
                self::$_instance = new self();
            }
            return self::$_instance;
        }



        /**
         * Constructor.
         */

        public function __construct() {
            // Define Constants
            $this->define_constants();

            // Include required files
            $this->includes();

            // Load Styles and Scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'load_styles_and_scripts' ) );
        }


        /* ==================================================================
            Init Methods
           ================================================================== */

        /**
         * Define Constants
         */

        private function define_constants()
        {
           define( 'DB_Plugin_PLUGIN_FILE', __FILE__ );
           define( 'DB_Plugin_VERSION', $this->version );
        }



        /**
         * Define Includes
         */

        private function includes()
        {}



        /**
         * Load stylesheets and scripts
         */
        public function load_styles_and_scripts()
        {
            $assets_path = str_replace( array( 'http:', 'https:' ), '', untrailingslashit( plugins_url( '/', __FILE__ ) ) ) . '/assets/';
            wp_register_style(
                'db-plugin',
                $assets_path . 'css/db-plugin.css',
                array(),
                DB_Plugin_VERSION
            );
            wp_register_script(
                'db-plugin',
                $assets_path . 'js/db-plugin.js',
                array('jquery'),
                DB_Plugin_VERSION,
                true
            );

            wp_enqueue_style( 'db-plugin' );
            wp_enqueue_script( 'db-plugin' );
        }



        /* ==================================================================
            Additional methods
           ================================================================== */

    }

endif;



/**
 * Returns the main instance of DB_Plugin to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return DB_Plugin
 */
function WP_DB_Plugin() {
    return DB_Plugin::instance();
}

WP_DB_Plugin();
