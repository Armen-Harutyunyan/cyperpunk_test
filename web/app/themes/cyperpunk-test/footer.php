<?php
/**
 * Theme footer template.
 *
 * @package CyperpunkTest
 */

$logo         = cyperpunk_test_normalize_image_field( null );
$partner_logo = cyperpunk_test_normalize_image_field( null );
$license_link = cyperpunk_test_normalize_link_field( null );
$privacy_link = cyperpunk_test_normalize_link_field( null );
$legal_text   = '';

if ( function_exists( 'get_field' ) ) {
	$logo         = cyperpunk_test_normalize_image_field( get_field( 'logo', 'option' ) );
	$partner_logo = cyperpunk_test_normalize_image_field( get_field( 'partner_logo', 'option' ) );
	$license_link = cyperpunk_test_normalize_link_field( get_field( 'license_link', 'option' ) );
	$privacy_link = cyperpunk_test_normalize_link_field( get_field( 'privacy_link', 'option' ) );
	$legal_text   = (string) get_field( 'legal_tex', 'option' );
}
?>
<?php if ( ! cyperpunk_test_is_empty( array( $logo, $partner_logo, $license_link, $privacy_link, $legal_text ) ) ) : ?>
	<footer class="cy-site-footer">
		<div class="cy-site-footer__top">
			<div class="cy-container cy-site-footer__container">
				<div class="cy-site-footer__brand">
					<?php if ( ! cyperpunk_test_is_empty( $logo ) ) : ?>
						<a class="cy-site-footer__logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'Home', 'cyperpunk-test' ); ?>">
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
							echo cyperpunk_test_render_responsive_picture(
								$logo,
								array(
									'size'    => 'full',
									'class'   => 'cy-site-footer__logo',
									'sizes'   => '(min-width: 1024px) 320px, 260px',
									'loading' => 'lazy',
								)
							);
							?>
						</a>
					<?php endif; ?>

					<?php if ( ! cyperpunk_test_is_empty( $partner_logo ) ) : ?>
						<div class="cy-site-footer__partner">
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
							echo cyperpunk_test_render_responsive_picture(
								$partner_logo,
								array(
									'size'    => 'full',
									'class'   => 'cy-site-footer__partner-logo',
									'sizes'   => '(min-width: 1024px) 172px, 140px',
									'loading' => 'lazy',
								)
							);
							?>
						</div>
					<?php endif; ?>
				</div>

				<div class="cy-site-footer__links">
					<?php if ( ! cyperpunk_test_is_empty( $license_link ) ) : ?>
						<a class="cy-site-footer__link" href="<?php echo esc_url( $license_link['url'] ); ?>" target="<?php echo esc_attr( $license_link['target'] ); ?>">
							<?php echo esc_html( $license_link['title'] ); ?>
						</a>
					<?php endif; ?>

					<?php if ( ! cyperpunk_test_is_empty( $privacy_link ) ) : ?>
						<a class="cy-site-footer__link" href="<?php echo esc_url( $privacy_link['url'] ); ?>" target="<?php echo esc_attr( $privacy_link['target'] ); ?>">
							<?php echo esc_html( $privacy_link['title'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( ! cyperpunk_test_is_empty( $legal_text ) ) : ?>
			<div class="cy-site-footer__bottom">
				<div class="cy-container">
					<p class="cy-site-footer__legal"><?php echo esc_html( $legal_text ); ?></p>
				</div>
			</div>
		<?php endif; ?>
	</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
