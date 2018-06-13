<?php get_header(); ?>
<section id="project">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<h3><?php the_title(); ?></h3>
		<?php the_content(); ?>
	<?php endwhile; else: ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif; ?>
	<?php db_presentations(); ?>
	<?php db_recommend_link(); ?>
</section>
<?php get_sidebar() ?>
<?php comments_template(); ?>
<?php get_footer(); ?>
