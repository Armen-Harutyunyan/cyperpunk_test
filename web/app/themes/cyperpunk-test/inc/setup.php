<?php
/**
 * Theme supports and global setup.
 *
 * @package CyperpunkTest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers base theme supports for block-first development.
 */
function cyperpunk_test_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/style.css' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'appearance-tools' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-units' );

	add_image_size( 'cyperpunk-card-sm', 460, 0, false );
	add_image_size( 'cyperpunk-card-lg', 788, 0, false );
	add_image_size( 'cyperpunk-section-half', 960, 0, false );
	add_image_size( 'cyperpunk-hero-md', 1440, 0, false );
	add_image_size( 'cyperpunk-hero', 1920, 0, false );
	add_image_size( 'cyperpunk-logo', 220, 0, false );
}

add_action( 'after_setup_theme', 'cyperpunk_test_setup' );

/**
 * Enqueues shared frontend assets.
 */
function cyperpunk_test_enqueue_frontend_assets(): void {
	$style_asset_path  = get_theme_file_path( 'assets/css/style.css' );
	$script_asset_path = get_theme_file_path( 'assets/js/app.js' );

	if ( file_exists( $style_asset_path ) ) {
		$style_asset_version = (string) filemtime( $style_asset_path );

		wp_register_style(
			'cyperpunk-test-critical',
			false,
			array(),
			$style_asset_version
		);
		wp_enqueue_style( 'cyperpunk-test-critical' );
		wp_add_inline_style( 'cyperpunk-test-critical', cyperpunk_test_get_critical_css() );

		wp_enqueue_style(
			'cyperpunk-test-style',
			get_theme_file_uri( 'assets/css/style.css' ),
			array(),
			$style_asset_version
		);
	}

	if ( file_exists( $script_asset_path ) ) {
		wp_enqueue_script(
			'cyperpunk-test-script',
			get_theme_file_uri( 'assets/js/app.js' ),
			array(),
			(string) filemtime( $script_asset_path ),
			true
		);
	}
}

add_action( 'wp_enqueue_scripts', 'cyperpunk_test_enqueue_frontend_assets' );

/**
 * Disables emoji assets and smilie conversion on the frontend.
 */
function cyperpunk_test_disable_emoji_assets(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
	add_filter( 'option_use_smilies', '__return_false' );
}

add_action( 'init', 'cyperpunk_test_disable_emoji_assets' );

/**
 * Disables Contact Form 7 base stylesheet because the theme provides full form styling.
 *
 * @return bool
 */
function cyperpunk_test_disable_cf7_styles(): bool {
	return false;
}

add_filter( 'wpcf7_load_css', 'cyperpunk_test_disable_cf7_styles' );

/**
 * Preloads theme fonts used above the fold.
 *
 * @param array<int, array<string, string>> $preload_resources Existing preload resources.
 * @return array<int, array<string, string>>
 */
function cyperpunk_test_preload_theme_fonts( array $preload_resources ): array {
	$fonts = array(
		'assets/fonts/Archangelsk.woff2',
		'assets/fonts/Roboto-Regular.woff2',
		'assets/fonts/Roboto-Bold.woff2',
	);

	foreach ( $fonts as $font_path ) {
		$preload_resources[] = array(
			'href'        => get_theme_file_uri( $font_path ),
			'as'          => 'font',
			'type'        => 'font/woff2',
			'crossorigin' => 'anonymous',
		);
	}

	return $preload_resources;
}

add_filter( 'wp_preload_resources', 'cyperpunk_test_preload_theme_fonts' );

/**
 * Returns critical CSS for the above-the-fold header and hero layout.
 *
 * @return string
 */
function cyperpunk_test_get_critical_css(): string {
	return <<<'CSS'
html{scroll-behavior:smooth}body{margin:0;background:#000;color:#fff;font-family:Roboto,Arial,sans-serif}.home .cy-site-main--front{padding-top:0}.cy-container{width:100%;max-width:1280px;margin-left:auto;margin-right:auto;padding-left:12px;padding-right:12px}img{display:block;max-width:100%;height:auto}picture{display:block}.cy-display-title{font-family:Archangelsk,"Arial Narrow",sans-serif;font-size:30px;line-height:1}.cy-site-header{position:fixed;left:0;z-index:50;width:100%;background:transparent}.cy-site-header__container{display:flex;flex-direction:column;align-items:center;gap:10px;padding-top:20px;padding-bottom:20px}.cy-site-header__logo-link{display:inline-flex;align-items:center;justify-content:center;color:inherit;text-decoration:none}.cy-site-header__logo{display:block;width:100%;max-width:296px;height:auto}.cy-site-header__socials{width:100%}.cy-site-header__social-list{display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:30px;margin:0;padding:0;list-style:none}.cy-site-header__social-link{display:inline-flex;align-items:center;justify-content:center;width:24px;min-height:25px;color:inherit;text-decoration:none}.cy-site-header__social-icon{display:block;width:auto;max-width:100%;height:25px;object-fit:contain}.cyperpunk-hero{position:relative;isolation:isolate;display:flex;align-items:flex-end;min-height:100vh;overflow:hidden;background:linear-gradient(180deg,#d7deea 0%,#f4f7fb 100%);padding-top:0;padding-bottom:0}.cyperpunk-hero:after{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(180deg,rgba(255,255,255,.05) 0%,rgba(0,0,0,.18) 100%),linear-gradient(90deg,rgba(0,0,0,.22) 0%,rgba(0,0,0,0) 38%,rgba(0,0,0,.28) 100%)}.cyperpunk-hero__slides,.cyperpunk-hero__slide{position:absolute;inset:0}.cyperpunk-hero__slides{z-index:0;width:100%;max-width:100%}.cyperpunk-hero__slide{opacity:0;transform:scale(1.02);overflow:hidden;z-index:0}.cyperpunk-hero__slide.is-active,.cyperpunk-hero__slide:only-child{opacity:1;transform:none;z-index:1}.cyperpunk-hero__slide-media,.cyperpunk-hero__slide picture,.cyperpunk-hero__slide img{width:100%;height:100%}.cyperpunk-hero__slide img{display:block;object-fit:cover;object-position:center top}.cyperpunk-hero__inner{position:relative;z-index:2;display:flex;align-items:flex-end;width:100%;min-height:inherit;padding-top:48px;padding-bottom:0}.cyperpunk-hero__inner.cy-container{padding-left:0;padding-right:0}.cyperpunk-hero__panel{position:relative;width:100%;max-width:424px;margin-left:auto;padding:30px 12px;background:#f8f200;clip-path:polygon(12% 0,100% 0,100% 84%,84% 100%,0 100%,0 16%);box-shadow:0 32px 60px rgba(0,0,0,.24)}.cyperpunk-hero__title{color:#000;line-height:1.02;text-align:center}.cyperpunk-hero__actions{margin-top:24px}.cyperpunk-hero__button{font-family:Archangelsk,"Arial Narrow",sans-serif;width:100%;max-width:244px;padding:10px;border:0;background:#000;color:#f8f200;line-height:40px;font-size:20px;text-decoration:none;margin-left:auto;margin-right:auto;text-align:center;display:block;cursor:pointer}@media (min-width:768px){.cy-container{padding-left:36px;padding-right:36px}.cy-display-title{font-size:62px}.cy-site-header__container{flex-direction:row;justify-content:space-between;gap:32px}.cy-site-header__logo{max-width:340px}.cy-site-header__social-list{gap:40px;justify-content:flex-end}.cy-site-header__social-link{width:30px;min-height:30px}.cy-site-header__social-icon{height:30px}.cyperpunk-hero__inner{padding-top:64px}.cyperpunk-hero__inner.cy-container{padding-left:36px;padding-right:36px}.cyperpunk-hero__panel{width:100%;padding:70px;max-width:624px}.cyperpunk-hero__title{text-align:left}.cyperpunk-hero__button{margin-left:0;font-size:24px;line-height:40px}}@media (min-width:1284px){.cy-container{max-width:1352px}.cy-site-header__socials{width:auto}.cyperpunk-hero__inner{padding-top:72px}.cyperpunk-hero__inner.cy-container{padding-right:0;padding-left:0}.cyperpunk-hero__panel{width:624px;margin-right:0;padding:70px 70px 60px}}
CSS;
}

/**
 * Converts the main theme stylesheet into a non-blocking preload.
 *
 * @param string $html   The link tag for the enqueued style.
 * @param string $handle The style handle.
 * @param string $href   The stylesheet URL.
 * @param string $media  The media attribute value.
 * @return string
 */
function cyperpunk_test_defer_main_stylesheet( string $html, string $handle, string $href, string $media ): string {
	if ( is_admin() || 'cyperpunk-test-style' !== $handle ) {
		return $html;
	}

	$media_attribute = 'all';

	if ( '' !== trim( $media ) && 'all' !== $media ) {
		$media_attribute = $media;
	}

	$preload = sprintf(
		'<link rel="preload" id="%1$s" href="%2$s" as="style" onload="this.onload=null;this.rel=\'stylesheet\';this.media=\'%3$s\'">',
		esc_attr( $handle . '-css' ),
		esc_url( $href ),
		esc_attr( $media_attribute )
	);

	$fallback = sprintf(
		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet -- Required noscript fallback for deferred stylesheet loading.
		'<noscript><link rel="stylesheet" id="%1$s-fallback" href="%2$s" media="%3$s"></noscript>',
		esc_attr( $handle . '-css' ),
		esc_url( $href ),
		esc_attr( $media_attribute )
	);

	return $preload . $fallback;
}

add_filter( 'style_loader_tag', 'cyperpunk_test_defer_main_stylesheet', 10, 4 );
