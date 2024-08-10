<?php

use MydPro\Includes\Fdm_products_show;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor widget for DROPE Delivery main page.
 *
 * @since 1.0
 */
class Widget_Delivery_Page extends \Elementor\Widget_Base {
	/**
	 * Prefix to prevent name conflics.
	 */
	protected static $prefix = 'myd_delivery_page';

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'myd-delivery-page';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'DROPE Delivery', 'drope-delivery' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'myd', 'delivery', 'products' ];
	}

	/**
	 * Get product categories to use on select option
	 *
	 * @return array
	 */
	public function get_product_categories_options() {
		if( defined( '\DRP_CURRENT_VERSION' ) && version_compare( \DRP_CURRENT_VERSION, '1.0.0', '<' ) ) {
			return array(
				'all' => esc_html__( 'All Categories', 'drope-delivery' ),
			);
		}

		$product_categories = get_option( 'fdm-list-menu-categories' );
		if ( empty( $product_categories ) ) {
			return array();
		}

		$product_categories = explode( ",", $product_categories );
		$product_categories = array_map( 'trim', $product_categories );
		$product_categories_options = array(
			'all' => esc_html__( 'All Categories', 'drope-delivery' ),
		);
		foreach ( $product_categories as $category ) {
			$product_categories_options[ $category ] = $category;
		}

		return $product_categories_options;
	}

	/**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Filter and search - content
		 */
		$this->start_controls_section(
			self::$prefix . '_filter_search_content_section',
			[
				'label' => esc_html__( 'Filter & Search', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			self::$prefix . '_filter_search_type',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Type', 'drope-delivery' ),
				'options' => [
					'complete' => esc_html__( 'Complete', 'drope-delivery' ),
					'hide_filter' => esc_html__( 'Hide filter', 'drope-delivery' ),
					'hide_search' => esc_html__( 'Hide search', 'drope-delivery' ),
					'hide' => esc_html__( 'Hide all', 'drope-delivery' ),
				],
				'default' => 'complete',
			]
		);

		$this->add_control(
			self::$prefix . '_filter_search_product_category',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Product Category', 'drope-delivery' ),
				'options' => $this->get_product_categories_options(),
				'default' => 'all',
			]
		);

		$this->end_controls_section();

		/**
		 * Product grid - content
		 */
		$this->start_controls_section(
			self::$prefix . '_product_grid_content_section',
			[
				'label' => esc_html__( 'Product Grid', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_grid_columns',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Columns', 'drope-delivery' ),
				'options' => [
					'1' => esc_html__( '1 column', 'drope-delivery' ),
					'2' => esc_html__( '2 columns', 'drope-delivery' ),
					'3' => esc_html__( '3 columns', 'drope-delivery' ),
				],
				'desktop_default' => '2',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'selectors' => [
					'{{WRAPPER}} .myd-product-list' => 'grid-template-columns: repeat({{VALUE}},1fr);',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_grid_gap',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Gap', 'drope-delivery' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'desktop_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .myd-product-list' => 'grid-gap: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product card - content
		 */
		$this->start_controls_section(
			self::$prefix . '_product_card_content_section',
			[
				'label' => esc_html__( 'Product Card', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			self::$prefix . '_product_card_img_align',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Image alignment', 'drope-delivery' ),
				'options' => [
					'row' => esc_html__( 'Right', 'drope-delivery' ),
					'row-reverse' => esc_html__( 'Left', 'drope-delivery' ),
				],
				'default' => 'row',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'flex-direction: {{VALEU}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_card_items_gap',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Itemns gap', 'drope-delivery' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'gap: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Filter and search - style
		 */
		$this->start_controls_section(
			self::$prefix . '_filter_search_style_section',
			[
				'label' => esc_html__( 'Filter & Search container', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name' => self::$prefix . '_filter_search_type',
							'operator' => '!==',
							'value' => 'hide',
						],
					],
				],
			]
		);

		$this->add_control(
			self::$prefix . '_filter_search_container_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'drope-delivery' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .myd-content-filter' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_filter_search_container_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '12',
					'right' => '12',
					'bottom' => '12',
					'left' => '12',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .myd-content-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_filter_search_container_margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Margin', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .myd-content-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_filter_search_container_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .myd-content-filter',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_filter_search_container_border',
				'label' => esc_html__( 'Border', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .myd-content-filter',
			]
		);

		$this->end_controls_section();

		/**
		 * Product card - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_card_style_section',
			[
				'label' => esc_html__( 'Product Card', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_card__background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'drope-delivery' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_card_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_product_card_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .myd-product-item',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_product_card_border',
				'label' => esc_html__( 'Border', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .myd-product-item',
			]
		);

		$this->end_controls_section();

		/**
		 * Product title - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_title_style_section',
			[
				'label' => esc_html__( 'Product title', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_title_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'drope-delivery' ),
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_product_title_font',
				'selector' => '{{WRAPPER}} .myd-product-item__title',
			]
		);

		$this->end_controls_section();

		/**
		 * Product description - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_description_style_section',
			[
				'label' => esc_html__( 'Product description', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_description_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'drope-delivery' ),
				'default' => '#717171',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_product_description_font',
				'selector' => '{{WRAPPER}} .myd-product-item__desc',
			]
		);

		$this->end_controls_section();

		/**
		 * Product price - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_price_style_section',
			[
				'label' => esc_html__( 'Product price', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_price_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'drope-delivery' ),
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item__price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_product_price_font',
				'selector' => '{{WRAPPER}} .myd-product-item__price',
			]
		);

		$this->end_controls_section();

		/**
		 * Product popup - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_popup_style_section',
			[
				'label' => esc_html__( 'Product popup', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_popup_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .fdm-popup-product-content' => 'background: {{VALUE}};',
					'{{WRAPPER}} .fdm-popup-product-action' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			self::$prefix . '_product_popup_button_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Button color', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .fdm-add-to-cart-popup' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_popup_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .fdm-popup-product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_popup_border_radius',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Border radius', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .fdm-popup-product-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_product_popup_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .fdm-popup-product-content',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_product_popup_border',
				'label' => esc_html__( 'Border', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .fdm-popup-product-content',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart float button - style
		 */
		$this->start_controls_section(
			self::$prefix . '_cart_float_button_style_section',
			[
				'label' => esc_html__( 'Cart float button', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_cart_float_button_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .myd-float' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_cart_float_button_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .myd-float' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_cart_float_button_font',
				'selector' => '{{WRAPPER}} .myd-float__title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_cart_float_button_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .myd-float',
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_cart_float_button_border_radius',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Border radius', 'drope-delivery' ),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .myd-float' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_cart_float_button_border',
				'label' => esc_html__( 'Border', 'drope-delivery' ),
				'selector' => '{{WRAPPER}} .myd-float',
			]
		);

		$this->end_controls_section();

		/**
		 * Side cart navigation - style
		 */
		$this->start_controls_section(
			self::$prefix . '_side_cart_navigation_style_section',
			[
				'label' => esc_html__( 'Side cart navigation', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_navigation_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__nav' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_navigation_buttons_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Buttons color', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__nav-back' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__nav-close' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__nav--active svg' => 'fill: {{VALUE}} !important;',
					'{{WRAPPER}} .myd-cart__nav--active .myd-cart__nav-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Side cart content - style
		 */
		$this->start_controls_section(
			self::$prefix . '_side_cart_content_style_section',
			[
				'label' => esc_html__( 'Side cart content', 'drope-delivery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_content_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__content' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_content_buttons_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Buttons color', 'drope-delivery' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__button' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__checkout-option--active' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__finished-track-order' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render template based on model in DROPE Delivery
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$args = array(
			'filter_type' => $settings[ self::$prefix . '_filter_search_type' ],
			'product_category' => $settings[ self::$prefix . '_filter_search_product_category' ],
		);

		if( defined( '\DRP_CURRENT_VERSION' ) && version_compare( \DRP_CURRENT_VERSION, '1.0.0', '<' ) ) {
			echo __( 'To use this widget you need DROPE Delivery version 1.0.0 or later.', 'drope-delivery' );
			return;
		}

		if ( class_exists( 'MydPro\Includes\Fdm_products_show' ) ) {
			$delivey_template = new Fdm_products_show();
			echo $delivey_template->fdm_list_products_html( $args );
			return;
		}

		echo __( 'Please, install DROPE Delivery to use this widget.', 'drope-delivery' );
	}
}
