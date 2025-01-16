
<?php 
/**
 * Archive page for get project
 * Task No 5
 */

get_header(); 

?>

<div class="container">
    <h1><?php post_type_archive_title(); ?></h1>
    <?php if ( have_posts() ) : ?>
        <div class="project-archive-list">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="project-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'medium' ); ?>
                        </a>
                    <?php endif; ?>
                    <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <p>No projects found.</p>
    <?php endif; ?>

    <!-- 
    Button for ajax call 
    Task No 6 
    -->

    <div class="ajax_post">
        <a class="btn btn_ajax_projects" href="javascript:void(0)">Get Projects</a>
    </div>
</div>

<?php get_footer(); ?>