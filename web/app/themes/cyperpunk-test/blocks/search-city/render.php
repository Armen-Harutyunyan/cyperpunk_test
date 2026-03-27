<?php
/**
 * Search city block template.
 *
 * @package CyperpunkTest
 */

$heading            = (string) get_field( 'title' );
$description_raw    = (string) get_field( 'description' );
$description_markup = cyperpunk_test_format_text_content( $description_raw );
$images             = cyperpunk_test_collect_repeater_images( get_field( 'images_list' ), 'img' );

if ( cyperpunk_test_is_empty( array( $heading, $description_markup, $images ) ) ) {
	return;
}
?>
<section <?php echo cyperpunk_test_get_section_attributes( 'cy-city' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="cy-container cy-city__container">
		<div class="cy-city__content">
			<?php if ( ! cyperpunk_test_is_empty( $heading ) ) : ?>
					<h2 class="cy-city__title cy-display-title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $description_markup ) ) : ?>
				<div class="cy-city__description cy-body-copy">
					<?php echo $description_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Formatted with wp_kses_post via helper. ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! cyperpunk_test_is_empty( $images ) ) : ?>
			<div class="cy-city__gallery">
				<?php foreach ( $images as $index => $image ) : ?>
					<?php $item_classes = 2 === $index ? 'cy-city__image cy-city__image--large' : 'cy-city__image'; ?>
					<div class="<?php echo esc_attr( $item_classes ); ?>">
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
						echo cyperpunk_test_render_responsive_picture(
							$image,
							array(
								'size'  => 2 === $index ? 'cyperpunk-card-lg' : 'cyperpunk-card-sm',
								'sizes' => 2 === $index
									? '(min-width: 1284px) 788px, 100vw'
									: '(min-width: 1284px) 460px, (min-width: 768px) 50vw, 100vw',
							)
						);
						?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
