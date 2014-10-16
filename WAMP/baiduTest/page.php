<?php get_header(); ?>

	<div class="box">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>  
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		</div>
		<?php endwhile; endif; ?>
	<p class="dpost"><?php the_tags('Tags: ', ', ', ' <br> '); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?><?php if(function_exists('the_views')) { the_views(); } ?>

	</div>
<div class="box">
	<?php comments_template(); ?>
	</div>


<?php get_footer(); ?>