<?php
namespace TenUp\Primary_Tag\Core;

/**
 * Default setup routine
 *
 * @uses add_action()
 * @uses do_action()
 *
 * @return void
 */
function setup() {
    $n = function( $function ) {
        return __NAMESPACE__ . "\\$function";
    };

    add_action( 'init', $n( 'i18n' ) );
    add_action( 'init', $n( 'init' ) );

    do_action( 'primarytag_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @uses apply_filters()
 * @uses get_locale()
 * @uses load_textdomain()
 * @uses load_plugin_textdomain()
 * @uses plugin_basename()
 *
 * @return void
 */
function i18n() {
    $locale = apply_filters( 'plugin_locale', get_locale(), 'primarytag' );
    load_textdomain( 'primarytag', WP_LANG_DIR . '/primarytag/primarytag-' . $locale . '.mo' );
    load_plugin_textdomain( 'primarytag', false, plugin_basename( PRIMARYTAG_PATH ) . '/languages/' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @uses do_action()
 *
 * @return void
 */
function init() {
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions/utils.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class-loader.php';
    $loader = new \NeedBee\PrimaryTag\Loader;
    $loader->init();

    do_action( 'primarytag_init' );
}

/**
 * Activate the plugin
 *
 * @uses init()
 * @uses flush_rewrite_rules()
 *
 * @return void
 */
function activate() {
    // First load the init scripts in case any rewrite functionality is being loaded
    init();
    flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {

}
