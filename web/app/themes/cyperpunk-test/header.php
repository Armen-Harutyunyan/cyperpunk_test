<?php
/**
 * Theme header template.
 *
 * @package CyperpunkTest
 */

$logo    = cyperpunk_test_normalize_image_field( null );
$socials = array();

if ( function_exists( 'get_field' ) ) {
	$logo    = cyperpunk_test_normalize_image_field( get_field( 'logo', 'option' ) );
	$socials = cyperpunk_test_normalize_repeater_field( get_field( 'socials', 'option' ) );
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( ! cyperpunk_test_is_empty( array( $logo, $socials ) ) ) : ?>
	<header class="cy-site-header">
		<div class="cy-container cy-site-header__container">
			<?php if ( ! cyperpunk_test_is_empty( $logo ) ) : ?>
				<a class="cy-site-header__logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'Home', 'cyperpunk-test' ); ?>">
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
					echo cyperpunk_test_render_responsive_picture(
						$logo,
						array(
							'size'          => 'full',
							'class'         => 'cy-site-header__logo',
							'sizes'         => '(min-width: 1024px) 296px, 260px',
							'loading'       => 'eager',
							'fetchpriority' => 'high',
						)
					);
					?>
				</a>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $socials ) ) : ?>
				<nav class="cy-site-header__socials" aria-label="<?php echo esc_attr__( 'Social links', 'cyperpunk-test' ); ?>">
					<ul class="cy-site-header__social-list">
						<?php foreach ( $socials as $social ) : ?>
							<?php
							$icon = cyperpunk_test_normalize_image_field( $social['icon'] ?? null );
							$url  = isset( $social['url'] ) && is_string( $social['url'] ) ? trim( $social['url'] ) : '';
							$label = cyperpunk_test_get_social_link_label( $url, $icon );
							?>
							<?php if ( ! cyperpunk_test_is_empty( array( $icon, $url ) ) ) : ?>
								<li class="cy-site-header__social-item">
									<a class="cy-site-header__social-link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noreferrer noopener" aria-label="<?php echo esc_attr( $label ); ?>">
										<?php
										// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
										echo cyperpunk_test_render_responsive_picture(
											$icon,
											array(
												'size'    => 'full',
												'class'   => 'cy-site-header__social-icon',
												'sizes'   => '32px',
												'loading' => 'eager',
											)
										);
										?>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
		</div>
	</header>
<?php endif; ?>
