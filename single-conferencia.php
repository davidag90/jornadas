<?php

/**
 * Template Post Type: conferencia
 *
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

get_header();
?>

<div id="content" class="site-content <?= apply_filters('bootscore/class/container', 'container-fluid', 'single'); ?> ' text-light py-5">
  <div id="primary" class="content-area">
    <div class="row">
      <div class="col">
        <div class="container">
          <div class="row">
            <div class="col">
              <main id="main" class="site-main">
                <?php the_post(); ?>

                <div class="entry-header">
                  <h1><?php the_title(); ?></h1>
                </div>

                <?php $disertantes = get_field('disertantes'); ?>

                <div class="entry-content">

                  <?php if ($disertantes): ?>
                    <div class="detalle-disertantes float-end p-3 bg-light text-dark rounded border-dark">
                      <h2 class="h5">Conferencia a cargo de</h2>
                      <ul class="list-group list-group-flush">
                        <?php foreach ($disertantes as $disertante): ?>
                          <li class="list-group-item list-group-item-light"><a href="<?php echo $disertante->post_permalink; ?>"><?php echo $disertante->post_title; ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    </div><!-- .detalle-disertantes -->
                  <?php endif; ?>
                  <!-- <pre class="text-dark"><?php var_dump($disertantes); ?></pre> -->
                  <?php the_content(); ?>
                </div>

                <div class="entry-footer clear-both">
                  <!-- Related posts using bS Swiper plugin -->
                  <?php if (function_exists('bootscore_related_posts')) bootscore_related_posts(); ?>
                </div><!-- .entry-footer -->
              </main>
            </div><!-- .col -->
          </div><!-- .row -->
        </div><!-- .container -->
      </div><!-- .row -->
    </div><!-- .col -->
  </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
