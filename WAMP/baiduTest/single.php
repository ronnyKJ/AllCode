<?php get_header(); ?>

	<div class="box">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		

		<div id="post-<?php the_ID(); ?>">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" onclick="return false"><?php the_title(); ?></a> <span class="date"><?php the_time('F jS, Y') ?></span></h2>

				<?php the_content(); ?>
				

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<p class="dpost"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?><?php if(function_exists('the_views')) { the_views(); } ?> </p>

				


		</div>
	</div>
	
	<div class="box">
	<?php comments_template(); ?>
	</div>

	<?php endwhile; else: ?>

		<div class="box">
<h2>Not Found</h2>
<p>Sorry, but you are looking for something that isn't here.</p>
</div>

<?php endif; ?>



<?php get_footer(); ?>
