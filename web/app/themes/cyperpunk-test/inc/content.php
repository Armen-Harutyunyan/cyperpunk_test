<?php
/**
 * Content rendering adjustments.
 *
 * @package CyperpunkTest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normalizes core/post-content classes for simpler layout control.
 *
 * @param string               $block_content Rendered block markup.
 * @param array<string, mixed> $block         Parsed block data.
 * @return string
 */
function cyperpunk_test_filter_post_content_classes( string $block_content, array $block ): string {
	if ( 'core/post-content' !== ( $block['blockName'] ?? '' ) || '' === $block_content ) {
		return $block_content;
	}

	if ( ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
		return $block_content;
	}

	$processor = new WP_HTML_Tag_Processor( $block_content );

	if ( ! $processor->next_tag() ) {
		return $block_content;
	}

	$processor->remove_class( 'entry-content' );
	$processor->remove_class( 'wp-block-post-content' );
	$processor->remove_class( 'is-layout-constrained' );
	$processor->remove_class( 'wp-block-post-content-is-layout-constrained' );
	$processor->add_class( 'w-full' );

	return $processor->get_updated_html();
}

add_filter( 'render_block', 'cyperpunk_test_filter_post_content_classes', 10, 2 );
