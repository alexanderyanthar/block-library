<?php
/**
 * Plugin Name: Blocks Library — Blocks
 * Description: Custom Gutenberg blocks for the Blocks Library sandbox.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'blb_register_blocks' );

function blb_register_blocks() {
	register_block_type(
		__DIR__ . '/build/accordion',
		[ 'render_callback' => 'blb_accordion_render' ]
	);
}

function blb_accordion_render( $attributes, $content ) {
	$title = wp_kses_post( $attributes['title'] ?? '' );
	$open  = ! empty( $attributes['initiallyOpen'] ) ? ' open' : '';
	return sprintf(
		'<div class="wp-block-blocks-library-accordion">
			<details%s>
				<summary>%s</summary>
				<div class="accordion-content">%s</div>
			</details>
		</div>',
		$open,
		$title,
		$content
	);
}
