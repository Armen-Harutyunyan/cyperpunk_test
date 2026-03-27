<?php
/**
 * Front page template.
 *
 * @package CyperpunkTest
 */

get_header();
?>
<main class="cy-site-main--front">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>
<?php
get_footer();
