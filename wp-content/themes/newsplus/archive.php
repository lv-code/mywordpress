<?php
/**
 * The template for displaying Archive pages.
 */

global $pls_archive_template;
get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">
		<?php show_breadcrumbs();
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php

				if ( 'list-style' == $pls_archive_template )
					get_template_part( 'content-list' );
				elseif ( 'grid-style' == $pls_archive_template )
					get_template_part( 'content-grid' );
				elseif ( 'full-style' == $pls_archive_template )
					get_template_part( 'content-full' );
				else
					get_template_part( 'content-classic' );

		endif; ?>

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>