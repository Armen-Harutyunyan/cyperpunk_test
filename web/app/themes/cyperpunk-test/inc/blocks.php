<?php
/**
 * Gutenberg block registration.
 *
 * @package CyperpunkTest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds a custom block category for the project blocks.
 *
 * @param array<int, array<string, string>> $categories Existing categories.
 * @return array<int, array<string, string>>
 */
function cyperpunk_test_register_block_category( array $categories ): array {
	$categories[] = array(
		'slug'  => 'cyperpunk-test',
		'title' => __( 'Cyperpunk Test', 'cyperpunk-test' ),
		'icon'  => null,
	);

	return $categories;
}

add_filter( 'block_categories_all', 'cyperpunk_test_register_block_category' );

/**
 * Registers every ACF block from the theme blocks directory.
 */
function cyperpunk_test_register_blocks(): void {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$blocks_dir = get_theme_file_path( 'blocks' );

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$directory = new DirectoryIterator( $blocks_dir );

	foreach ( $directory as $block_directory ) {
		if ( $block_directory->isDot() || ! $block_directory->isDir() ) {
			continue;
		}

		$block_path = $block_directory->getPathname();

		if ( file_exists( $block_path . '/block.json' ) ) {
			register_block_type( $block_path );
		}
	}
}

add_action( 'acf/init', 'cyperpunk_test_register_blocks' );
