<?php
/**
 * Hero block template.
 *
 * @package CyperpunkTest
 */

$heading     = (string) get_field( 'title' );
$button_text = (string) get_field( 'button_text' );
$button_link = cyperpunk_test_normalize_link_field( get_field( 'button_link' ) );
$hero_images = cyperpunk_test_collect_repeater_images( get_field( 'images_list' ), 'img' );

if ( cyperpunk_test_is_empty( array( $heading, $button_text, $hero_images ) ) ) {
	return;
}
?>
<section <?php echo cyperpunk_test_get_section_attributes( 'cyperpunk-hero' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( ! cyperpunk_test_is_empty( $hero_images ) ) : ?>
		<div class="cyperpunk-hero__slides" aria-hidden="true">
			<?php foreach ( $hero_images as $index => $image ) : ?>
				<div class="cyperpunk-hero__slide<?php echo 0 === $index ? ' is-active' : ''; ?>">
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
					echo cyperpunk_test_render_responsive_picture(
						$image,
						array(
							'size'          => 'cyperpunk-hero',
							'class'         => 'cyperpunk-hero__slide-media',
							'sizes'         => '(max-width: 767px) 320vw, (max-width: 1279px) 140vw, 100vw',
							'loading'       => 'eager',
							'fetchpriority' => 0 === $index ? 'high' : '',
							'alt'           => '',
							'auto_sizes'    => false,
						)
					);
					?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="cy-container cyperpunk-hero__inner">
		<div class="cyperpunk-hero__panel">
			<?php if ( ! cyperpunk_test_is_empty( $heading ) ) : ?>
					<h1 class="cyperpunk-hero__title cy-display-title"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $button_text ) ) : ?>
				<div class="cyperpunk-hero__actions">
					<?php if ( ! cyperpunk_test_is_empty( $button_link ) ) : ?>
						<a class="cyperpunk-hero__button" href="<?php echo esc_url( $button_link['url'] ); ?>" target="<?php echo esc_attr( $button_link['target'] ); ?>" data-scroll-target="#cy-cta-section">
							<?php echo esc_html( $button_text ); ?>
						</a>
					<?php else : ?>
						<button class="cyperpunk-hero__button" type="button" data-scroll-target="#cy-cta-section">
							<?php echo esc_html( $button_text ); ?>
						</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
