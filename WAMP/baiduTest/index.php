<?php get_header(); ?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="box">
<div id="post-<?php the_ID(); ?>">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h2>
			
<!-- by <?php the_author() ?> -->

<?php the_content('Read more..'); ?>
</div>
</div>
		<?php endwhile; ?></br>
<div class="navigation">
			<div class="page_navi"><?php par_pagenavi(9); ?></div>
		</div>
	<?php else : ?>
	<?php endif; ?>
<?php get_footer(); ?>
