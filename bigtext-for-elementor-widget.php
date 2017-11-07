<?php 
namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

if( ! defined( 'ABSPATH' ) ) exit;

class Bigtext_For_Elementor extends Widget_Base {

	public $hash = null;

	public function get_hash() {
		if( null === $this->hash ):
			$this->hash = $this->get_random();
		else:
			$this->hash = $this->hash;
		endif;

		return $this->hash;
	}

	public function get_name() {
		return 'bigtext-for-elementor';
	}

	public function get_title() {
		return __( 'Bigtext for Elementor', 'bigtext4elementor' );
	}

	public function get_icon() {
		return 'fa fa-bars';
	}

	public function get_script_depends() {
		return [ 'bigtext' ];
	}

	public function get_random() {
		return rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label'		=> __( 'Bigtext', 'bigtext4elementor' ),
			]
		);

		$this->add_control(
			'container_width',
			[
				'label'		=> __( 'Largeur du container (en px)', 'bigtext4elementor' ),
				'type'		=> Controls_Manager::TEXT,
				'default'	=> '420',
				'selectors'	=> [
					'#bigtext-container-' . $this->get_hash() => 'width: {{VALUE}}px'
				]
			]
		);

		$this->add_control(
			'bigtext_text',
			[
				'label'	=> __( 'Contenu à afficher', 'bigtext4elementor' ),
				'type'	=> Controls_Manager::WYSIWYG
			]
		);

		$this->add_control(
			'explication',
			[
				'type'	=> Controls_Manager::RAW_HTML,
				'raw'	=> __( 'Dans le champs ci-dessus, vous pouvez mettre le texte que vous voulez faire apparaître. Chaque ligne sera ajustée par le script pour faire la même longueur (déterminée par la largeur renseignée dans le premier champ.', 'bigtext4elementor' )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Typographie', 'bigtext4elementor' ),
				'tab'	=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'color',
			[
				'label' 	=> __( 'Couleur du texte', 'bigtext4elementor' ),
				'type'		=> Controls_Manager::COLOR,
				'scheme'	=> [
					'type'	=> Scheme_Color::get_type(),
					'value'	=> Scheme_Color::COLOR_1
				],
				'selectors'	=> [
					'#bigtext-container-' . $this->get_hash() => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'		=> 'typography',
				'scheme'	=> Scheme_Typography::TYPOGRAPHY_1,
				'selectors'	=> '#bigtext-container-' . $this->get_hash()
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label'	=> __( 'Animation au survol', 'bigtext4elementor' ),
				'type'	=> Controls_Manager::HOVER_ANIMATION
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings 			= $this->get_settings();
		if( empty( $settings['bigtext_text'] ) ) return;
		$container_id 		= $this->get_hash();
		$container_width 	= $settings['container_width'];
		$texte 				= $settings['bigtext_text'];
		printf(
			'<div id="bigtext-container-%1$s" class="bigtext" style="/*width: %2$spx;*/">%3$s</div><!-- .bigtext -->',
			$container_id,
			$container_width,
			$texte
		);

		add_action( 'wp_footer', [ $this, 'bigtext_for_elementor_styles' ] );

	}

	public function bigtext_for_elementor_styles() {
		$settings 			= $this->get_settings();
		$container_id 		= $this->get_hash();
		$container_width 	= $settings['container_width'];
		$color 				= $settings['color'];
		$font_family 		= ( '' != $settings['typography_font_family'] ) ? "'" . $settings['typography_font_family'] . "'" : "inherit";
		$font_weight 		= ( '' != $settings['typography_font_weight'] ) ? $settings['typography_font_weight'] : '400';
		$text_transform		= ( '' != $settings['typography_text_transform'] ) ? $settings['typography_text_transform'] : 'inherit';
		$prop_css 			= '#bigtext-container-' . $container_id . ' { width: ' . $container_width . 'px; color: ' . $color . '; font-family: ' . $font_family . '; font-weight: ' . $font_weight . '; text-transform: ' . $text_transform . '; }';

		echo '<style>' . $prop_css . '</style>';

	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Bigtext_For_Elementor() );
