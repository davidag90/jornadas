<?php
// Exit if accessed directly
defined('ABSPATH') || exit;

get_header();
?>

<div id="content" class="site-content pt-4 text-light <?= apply_filters('bootscore/class/container', 'container-fluid'); ?>">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">
      <div class="entry-header">
        <div class="row">
          <div class="col">
            <div class="container-xl">
              <div class="row">
                <div class="col">
                  <h1 class="border-bottom border-light-subtle mb-4 pb-1"><?php the_title(); ?></h1>
                </div>
              </div>
            </div>
          </div><!-- .col -->
        </div><!-- .row -->
      </div><!-- .entry-header -->
      <div class="entry-content">
        <?php the_post(); ?>
        <?php the_content(); ?>
      </div>

    </main>

  </div>
</div>

<?php
get_footer();
