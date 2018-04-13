<?php
namespace BigtextForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Bigtext_For_Elementor
 *
 * @since 2.0.0
 */
class Bigtext_For_Elementor extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'bigtext-for-elementor';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Bigtext for Elementor', 'bigtext-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-menu-toggle';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general-elements' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'bigtext', 'bigtext-for-elementor' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Bigtext', 'bigtext-for-elementor' ),
			]
		);

		$this->add_control(
			'container_width',
			[
				'label' => __( 'Width of the container (px)', 'bigtext-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default'	=> '420',
				'selectors'	=> [
					'{{WRAPPER}} .bigtext' => 'width: {{VALUE}}px;'
				]
			]
		);

		$this->add_control(
			'bigtext_text',
			[
				'label' 	=> __( 'Content to display', 'bigtext-for-elementor' ),
				'type'		=> Controls_Manager::WYSIWYG,
				'description'	=> __( 'Enter the text you want to display. Each line will be adapted to fit the width of the container.', 'bigtext-for-elementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'bigtext-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'bigtext-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme'	=> [
					'type'	=> Scheme_Color::get_type(),
					'value'	=> Scheme_Color::COLOR_1
				],
				'selectors' => [
					'{{WRAPPER}} .bigtext p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'	=> 'typography',
				'scheme'	=> Scheme_Typography::TYPOGRAPHY_1,
				'selectors'	=> '{{WRAPPER}} .bigtext p'
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' 	=> __( 'Hover animation', 'bigtext-for-elementor' ),
				'type'		=> Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();

		echo '<div class="bigtext">';
		echo $settings[ 'bigtext_text' ];
		echo '</div>';
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="bigtext">
			{{{ settings.bigtext_text }}}
		</div>
		<?php
	}
}
