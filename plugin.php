<?php
namespace Byttek_MasonryGrid;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function widget_styles() {
		wp_register_style( 'bmgb-style', plugins_url( '/assets/css/style.css', __FILE__ ), [], '1.0.033' );
	}

	public function widget_scripts() {
		wp_register_script( 'isotope', plugins_url( '/assets/js/isotope.pkgd.min.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_register_script( 'isotope-packery', plugins_url( '/assets/js/packery-mode.pkgd.min.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_register_script( 'bmgb-script', plugins_url( '/assets/js/bmgb.js', __FILE__ ), [ 'jquery', 'isotope', 'isotope-packery' ], '1.0.033', true );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		// Its is now safe to include Widgets files
		require_once( __DIR__ . '/widgets/byttek-masonry-grid.php' );

		// Register Widgets
		$widgets_manager->register( new Widgets\Byttek_Masonry_Grid() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		// Register widget styles
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}
}

// Instantiate Plugin Class
Plugin::instance();
