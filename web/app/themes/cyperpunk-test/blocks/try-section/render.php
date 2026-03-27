<?php
/**
 * Try section block template.
 *
 * @package CyperpunkTest
 */

$heading     = (string) get_field( 'title' );
$description = cyperpunk_test_format_text_content( get_field( 'description' ) );
$list        = cyperpunk_test_normalize_repeater_field( get_field( 'list' ) );
$button_text = (string) get_field( 'button_text' );
$button_link = cyperpunk_test_normalize_link_field( get_field( 'button_link' ) );
$main_image  = cyperpunk_test_first_non_empty_image(
	get_field( 'main_image' ),
	get_field( 'product_image' )
);
$logos       = cyperpunk_test_collect_repeater_images( get_field( 'logos' ), 'image' );

if ( cyperpunk_test_is_empty( $logos ) ) {
	$logos = array_filter(
		array(
			cyperpunk_test_normalize_image_field( get_field( 'logo_left' ) ),
			cyperpunk_test_normalize_image_field( get_field( 'logo_right' ) ),
		),
		static fn( array $logo ): bool => ! cyperpunk_test_is_empty( $logo )
	);
}

if ( cyperpunk_test_is_empty( array( $heading, $description, $list, $button_text, $main_image, $logos ) ) ) {
	return;
}
?>
<section <?php echo cyperpunk_test_get_section_attributes( 'cy-try' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="cy-container cy-try__container">
		<div class="cy-try__media">
			<?php if ( ! cyperpunk_test_is_empty( $main_image ) ) : ?>
				<div class="cy-try__product">
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
					echo cyperpunk_test_render_responsive_picture(
						$main_image,
						array(
							'size'  => 'cyperpunk-card-sm',
							'sizes' => '(min-width: 1024px) 460px, 100vw',
						)
					);
					?>
				</div>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $logos ) ) : ?>
				<div class="cy-try__logos">
					<?php foreach ( array_values( $logos ) as $index => $logo ) : ?>
						<div class="cy-try__logo-item">
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
							echo cyperpunk_test_render_responsive_picture(
								$logo,
								array(
									'size'    => 'cyperpunk-logo',
									'class'   => 'cy-try__logo',
									'sizes'   => '(min-width: 1024px) 220px, 140px',
									'loading' => 'lazy',
								)
							);
							?>
						</div>
						<?php if ( $index < count( $logos ) - 1 ) : ?>
							<span class="cy-try__logo-separator" aria-hidden="true"></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="cy-try__content">
			<?php if ( ! cyperpunk_test_is_empty( $heading ) ) : ?>
					<h2 class="cy-try__title cy-display-title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $description ) ) : ?>
				<div class="cy-try__description cy-body-copy"><?php echo wp_kses_post( $description ); ?></div>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $list ) ) : ?>
				<ul class="cy-try__list">
					<?php foreach ( $list as $item ) : ?>
						<?php
						$item_icon  = cyperpunk_test_normalize_image_field( $item['icon'] ?? null );
						$item_title = isset( $item['title'] ) && is_string( $item['title'] ) ? $item['title'] : '';
						?>
						<?php if ( ! cyperpunk_test_is_empty( $item_title ) ) : ?>
							<li class="cy-try__list-item">
								<?php if ( ! cyperpunk_test_is_empty( $item_icon ) ) : ?>
									<?php
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
									echo cyperpunk_test_render_responsive_picture(
										$item_icon,
										array(
											'size'    => 'thumbnail',
											'class'   => 'cy-try__list-icon',
											'sizes'   => '28px',
											'loading' => 'lazy',
										)
									);
									?>
								<?php endif; ?>
								<span><?php echo esc_html( $item_title ); ?></span>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $button_text ) ) : ?>
				<div class="cy-try__actions">
					<?php if ( ! cyperpunk_test_is_empty( $button_link ) ) : ?>
						<a class="cy-try__button" href="<?php echo esc_url( $button_link['url'] ); ?>" target="<?php echo esc_attr( $button_link['target'] ); ?>" data-scroll-target="#cy-cta-section">
							<?php echo esc_html( $button_text ); ?>
						</a>
					<?php else : ?>
						<button class="cy-try__button" type="button" data-scroll-target="#cy-cta-section">
							<?php echo esc_html( $button_text ); ?>
						</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
