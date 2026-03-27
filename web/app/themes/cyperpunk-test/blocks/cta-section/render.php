<?php
/**
 * CTA section block template.
 *
 * @package CyperpunkTest
 */

$promo        = (string) get_field( 'promo' );
$heading      = (string) get_field( 'title' );
$description  = cyperpunk_test_format_text_content( get_field( 'description' ) );
$contact_form = absint( get_field( 'contact_form' ) );
$images       = cyperpunk_test_collect_repeater_images( get_field( 'images' ), 'img' );
$form_markup  = '';

if ( 0 < $contact_form && shortcode_exists( 'contact-form-7' ) ) {
	$form_markup = do_shortcode(
		sprintf(
			'[contact-form-7 id="%d" html_class="cy-cta__form novalidate"]',
			$contact_form
		)
	);

	if ( is_string( $form_markup ) ) {
		$form_markup = preg_replace( '/<br\s*\/?>/i', '', $form_markup );
		$form_markup = str_replace(
			'class="wpcf7-form init cy-cta__form novalidate"',
			'class="wpcf7-form init cy-cta__form novalidate wpcf7-acceptance-as-validation"',
			$form_markup
		);
		$form_markup = is_string( $form_markup ) ? $form_markup : '';
	}
}

if ( cyperpunk_test_is_empty( array( $promo, $heading, $description, $form_markup, $images ) ) ) {
	return;
}
?>
<section id="cy-cta-section" <?php echo cyperpunk_test_get_section_attributes( 'cy-cta' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="cy-container cy-cta__container">
		<div class="cy-cta__content">
			<div class="cy-cta__copy">
				<?php if ( ! cyperpunk_test_is_empty( $promo ) ) : ?>
					<div class="cy-cta__promo" aria-hidden="true">
						<span><?php echo esc_html( $promo ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! cyperpunk_test_is_empty( $heading ) ) : ?>
					<h2 class="cy-cta__title cy-display-title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( ! cyperpunk_test_is_empty( $description ) ) : ?>
					<div class="cy-cta__description cy-body-copy"><?php echo wp_kses_post( $description ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( ! cyperpunk_test_is_empty( $form_markup ) ) : ?>
				<div class="cy-cta__form-wrap">
					<?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! cyperpunk_test_is_empty( $images ) ) : ?>
			<div class="cy-cta__media" aria-hidden="true">
				<div class="cy-cta__media-layer cy-cta__media-layer--yellow"></div>
				<div class="cy-cta__media-layer cy-cta__media-layer--blue"></div>
				<?php foreach ( array_values( $images ) as $index => $image ) : ?>
					<div class="cy-cta__media-item cy-cta__media-item--<?php echo esc_attr( (string) ( $index + 1 ) ); ?>">
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
						echo cyperpunk_test_render_responsive_picture(
							$image,
							array(
								'size'    => 'cyperpunk-card-sm',
								'class'   => 'cy-cta__media-image',
								'sizes'   => '(min-width: 1284px) 460px, (min-width: 768px) 360px, 42vw',
								'loading' => 'lazy',
							)
						);
						?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
