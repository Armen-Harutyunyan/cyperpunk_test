<?php
/**
 * Buy section block template.
 *
 * @package CyperpunkTest
 */

$heading        = (string) get_field( 'title' );
$list_title     = (string) get_field( 'list_title' );
$list_items     = cyperpunk_test_normalize_repeater_field( get_field( 'list_items' ) );
$platform_title = (string) get_field( 'platform_title' );
$platform_icons = cyperpunk_test_normalize_repeater_field( get_field( 'platform_icons' ) );
$section_image  = cyperpunk_test_first_non_empty_image(
	get_field( 'image' ),
	get_field( 'cover_image' )
);

if ( cyperpunk_test_is_empty( array( $heading, $list_title, $list_items, $platform_title, $platform_icons, $section_image ) ) ) {
	return;
}
?>
<section <?php echo cyperpunk_test_get_section_attributes( 'cy-buy' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="cy-container cy-buy__container">
		<div class="cy-buy__media">
			<?php if ( ! cyperpunk_test_is_empty( $section_image ) ) : ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
				echo cyperpunk_test_render_responsive_picture(
					$section_image,
					array(
						'size'  => 'cyperpunk-section-half',
						'sizes' => '(min-width: 1284px) 50vw, (min-width: 768px) 332px, 100vw',
					)
				);
				?>
			<?php else : ?>
				<div class="cy-buy__media-placeholder">
					<span><?php echo esc_html__( 'Cover collage', 'cyperpunk-test' ); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<div class="cy-buy__content">
			<?php if ( ! cyperpunk_test_is_empty( $heading ) ) : ?>
					<h2 class="cy-buy__title cy-display-title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $list_title ) ) : ?>
				<h3 class="cy-buy__subtitle"><?php echo esc_html( $list_title ); ?></h3>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $list_items ) ) : ?>
				<ul class="cy-buy__list">
					<?php foreach ( $list_items as $item ) : ?>
						<?php
						$item_icon  = cyperpunk_test_normalize_image_field( $item['icon'] ?? null );
						$item_title = isset( $item['title'] ) && is_string( $item['title'] ) ? $item['title'] : '';
						?>
						<?php if ( ! cyperpunk_test_is_empty( $item_title ) ) : ?>
							<li class="cy-buy__list-item">
								<?php if ( ! cyperpunk_test_is_empty( $item_icon ) ) : ?>
									<?php
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
									echo cyperpunk_test_render_responsive_picture(
										$item_icon,
										array(
											'size'    => 'thumbnail',
											'class'   => 'cy-buy__list-icon',
											'sizes'   => '24px',
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

			<?php if ( ! cyperpunk_test_is_empty( $platform_title ) ) : ?>
				<h3 class="cy-buy__subtitle cy-buy__subtitle--platforms"><?php echo esc_html( $platform_title ); ?></h3>
			<?php endif; ?>

			<?php if ( ! cyperpunk_test_is_empty( $platform_icons ) ) : ?>
				<div class="cy-buy__platforms">
					<?php foreach ( $platform_icons as $platform ) : ?>
						<?php $platform_icon = cyperpunk_test_normalize_image_field( $platform['icon'] ?? null ); ?>
						<?php if ( ! cyperpunk_test_is_empty( $platform_icon ) ) : ?>
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped picture markup.
							echo cyperpunk_test_render_responsive_picture(
								$platform_icon,
								array(
									'size'    => 'medium',
									'class'   => 'cy-buy__platform-icon',
									'sizes'   => '(min-width: 1024px) 160px, 120px',
									'loading' => 'lazy',
								)
							);
							?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
