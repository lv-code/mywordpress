<?php
/**
 * Content Loop for archives - Full Post Style.
 */

global $pls_hide_post_meta, $pls_hide_blog_full_images;
if ( ! have_posts() ) : ?>
    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'newsplus' ); ?></h1>
        </header>
        <div class="entry-content">
            <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'newsplus' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
<?php endif;
while ( have_posts() ) :
	the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-classic clear' ); ?>>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <?php if ( 'true' != $pls_hide_post_meta ) { ?>
        <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_post_meta(); ?></aside>
        <?php } // hide post meta
		if ( 'true' !== $pls_hide_blog_full_images ) {
			get_template_part( 'formats/format', get_post_format() );
		}
        the_content( __( 'Read more', 'newsplus' ) ); ?>
    </article><!-- #post-<?php the_ID(); ?> -->
<?php endwhile; // End the loop
newsplus_content_nav( 'nav-below' ); ?>