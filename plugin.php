<?php
namespace BigtextForElementor;

use BigtextForElementor\Widgets\Bigtext_For_Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );

		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Register the scripts
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function enqueue_scripts() {
		
		wp_register_script( 'bigtext', plugins_url( '/assets/js/bigtext.min.js', ELEMENTOR_BIGTEXT__FILE__ ), [ 'jquery' ], false, true );
		wp_register_script( 'bigtext-for-elementor', plugins_url( '/assets/js/bigtext-for-elementor.js', ELEMENTOR_BIGTEXT__FILE__ ), [ 'bigtext' ], false, true );
		wp_enqueue_script( 'bigtext' );
		wp_enqueue_script( 'bigtext-for-elementor' );

	}

	/**
	 * Enqueue styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'bigtext-for-elementor', plugins_url( '/assets/css/bigtext-for-elementor.css', ELEMENTOR_BIGTEXT__FILE__ ) );

	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require __DIR__ . '/widgets/bigtext-for-elementor.php';
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Bigtext_For_Elementor() );
	}
}

new Plugin();
