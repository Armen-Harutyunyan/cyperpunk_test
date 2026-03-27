<?php
/**
 * Shared template helper functions.
 *
 * @package CyperpunkTest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determines whether the provided value should be treated as empty in templates.
 *
 * @param mixed $value Value to inspect.
 * @return bool
 */
function cyperpunk_test_is_empty( $value ): bool {
	if ( null === $value ) {
		return true;
	}

	if ( is_string( $value ) ) {
		return '' === trim( $value );
	}

	if ( is_bool( $value ) ) {
		return false === $value;
	}

	if ( is_int( $value ) || is_float( $value ) ) {
		return 0 === $value;
	}

	if ( is_array( $value ) ) {
		if ( array() === $value ) {
			return true;
		}

		foreach ( $value as $key => $item ) {
			if ( 'target' === $key && '_self' === $item ) {
				continue;
			}

			if ( ! cyperpunk_test_is_empty( $item ) ) {
				return false;
			}
		}

		return true;
	}

	return empty( $value );
}

/**
 * Normalizes ACF repeater values and removes empty rows.
 *
 * @param mixed $rows Raw repeater value.
 * @return array<int, mixed>
 */
function cyperpunk_test_normalize_repeater_field( $rows ): array {
	if ( ! is_array( $rows ) ) {
		return array();
	}

	$normalized_rows = array();

	foreach ( $rows as $row ) {
		if ( cyperpunk_test_is_empty( $row ) ) {
			continue;
		}

		$normalized_rows[] = $row;
	}

	return array_values( $normalized_rows );
}

/**
 * Returns the first non-empty normalized image from the provided values.
 *
 * @param mixed ...$image_values Raw image field values.
 * @return array{id:int,url:string,alt:string}
 */
function cyperpunk_test_first_non_empty_image( ...$image_values ): array {
	foreach ( $image_values as $image_value ) {
		$image = cyperpunk_test_normalize_image_field( $image_value );

		if ( ! cyperpunk_test_is_empty( $image ) ) {
			return $image;
		}
	}

	return cyperpunk_test_normalize_image_field( null );
}

/**
 * Collects normalized images from a repeater field by sub field name.
 *
 * @param mixed  $rows Raw repeater value.
 * @param string $image_key Repeater image sub field key.
 * @return array<int, array{id:int,url:string,alt:string}>
 */
function cyperpunk_test_collect_repeater_images( $rows, string $image_key ): array {
	$images = array();

	foreach ( cyperpunk_test_normalize_repeater_field( $rows ) as $row ) {
		if ( ! is_array( $row ) || ! array_key_exists( $image_key, $row ) ) {
			continue;
		}

		$image = cyperpunk_test_normalize_image_field( $row[ $image_key ] );

		if ( cyperpunk_test_is_empty( $image ) ) {
			continue;
		}

		$images[] = $image;
	}

	return $images;
}

/**
 * Returns escaped block wrapper attributes for a section element.
 *
 * @param string $class_name Section class name.
 * @param string $style Optional inline style string.
 * @return string
 */
function cyperpunk_test_get_section_attributes( string $class_name, string $style = '' ): string {
	$attributes = array(
		'class' => $class_name,
	);

	if ( ! cyperpunk_test_is_empty( $style ) ) {
		$attributes['style'] = $style;
	}

	return wp_kses_data( get_block_wrapper_attributes( $attributes ) );
}

/**
 * Builds an accessible label for icon-only social links.
 *
 * @param string                              $url Social profile URL.
 * @param array{id:int,url:string,alt:string} $icon Normalized social icon data.
 * @return string
 */
function cyperpunk_test_get_social_link_label( string $url, array $icon ): string {
	if ( ! cyperpunk_test_is_empty( $icon['alt'] ?? '' ) ) {
		return (string) $icon['alt'];
	}

	$host = wp_parse_url( $url, PHP_URL_HOST );

	if ( is_string( $host ) && '' !== $host ) {
		$host = preg_replace( '/^www\./i', '', $host );

		if ( is_string( $host ) && '' !== $host ) {
			return sprintf(
				/* translators: %s: social network domain */
				__( 'Visit profile on %s', 'cyperpunk-test' ),
				$host
			);
		}
	}

	return __( 'Visit social profile', 'cyperpunk-test' );
}
