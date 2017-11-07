<?php 
/**
 * Plugin Name: Bigtext for Elementor
 * Description: Bigtext for Elementor makes lines of text fit in width, thanks to Bitext JS (https://github.com/zachleat/BigText
 * Plugin URI: http://arthos.fr
 * Version: 1.0.0
 * Author: Arthos
 * Author URI: http://arthos.fr
 * Text Domain: bigtext4elementor
 */
if( ! defined( 'ABSPATH' ) ) exit;

class ElementorCustomWidget {

	private static $instance = null;

	public static function get_instance() {
		if( ! self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	public function init() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style_and_script' ] );
	}

	public function widgets_registered() {
		if( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			$template_file = 'plugins/elementor/bigtext-for-elementor-widget.php';
			if( ! $template_file || ! is_readable( $template_file ) ) {
				$template_file = plugin_dir_path( __FILE__ ) . 'bigtext-for-elementor-widget.php';
			}
			if( $template_file && is_readable( $template_file ) ) {
				require_once $template_file;
			}
		} 
	}

	public function enqueue_style_and_script() {
		wp_enqueue_script( 'bigtext', plugins_url( 'js/bigtext.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'bigtext-for-elementor', plugins_url( 'js/bigtext-for-elementor.js', __FILE__ ), array( 'bigtext' ) );
		wp_enqueue_style( 'bigtext', plugins_url( 'css/bigtext-for-elementor.css', __FILE__ ) );
	}

}

ElementorCustomWidget::get_instance()->init();