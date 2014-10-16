<?php get_header(); ?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="box">
<div id="post-<?php the_ID(); ?>">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <span class="date"><?php the_time('F jS, Y') ?></span></h2>
				
<!-- by <?php the_author() ?> -->

<?php the_excerpt('Read more..'); ?>
</div>
</div>
		<?php endwhile; ?>

<div class="box">
<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
<div class="clear"></div>
</div>

	<?php else : ?>

<div class="box">
<h2>Not Found</h2>
<p>Sorry, but you are looking for something that isn't here.</p>
</div>
	<?php endif; ?>

	

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
