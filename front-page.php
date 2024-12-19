<?php
// Exit if accessed directly
defined('ABSPATH') || exit;

get_header();
?>

<div id="content" class="site-content">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">
      <?php $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>

      <div class="entry-header featured-full-width-img front-page-header bg-dark text-light" style="background-image: url('<?= $thumb['0']; ?>')">
        <div id="front-data-container" class="<?= apply_filters('bootscore/class/container', 'container-fluid', 'page-full-width-image'); ?> h-100">
          <h1 class="entry-title d-none"><?php the_title(); ?></h1>
          <div id="front-data" class="d-flex flex-column align-items-center justify-content-center h-100">
            <div class="logos d-flex flex-column align-items-center">
              <div class="logos-row mb-3">
                <img id="logo-100" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/front-page/logo-100.png" alt="Círculo Odontológico de Córdoba - 100 años">
              </div>
              <div class="logos-row d-flex flex-row justify-content-center">
                <img id="logo-jornadas" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/front-page/logo-jornadas.svg" alt="23° Jornadas Odontológicas Internacionales del Centro" class="me-3">
                <img id="logo-encuentro" src=" <?php echo get_stylesheet_directory_uri() ?>/assets/img/front-page/logo-encuentro.png" alt="37° Encuentro de la Sociedad de Cirugía BMF de Córdoba">
              </div>
            </div><!-- .logos -->
            <div id="fecha" class="text-uppercase text-center fw-bold">
              24, 25 y 26 <br class="d-md-none">de Septiembre de 2025
              <br><span class="fs-6">Córdoba, Argentina</span>
            </div>
            <div id="inscripcion">
              <a href="<?php echo home_url(); ?>/inscripciones" class="btn btn-warning btn-lg"><i class="fa-solid fa-pencil-square me-1"></i> Inscripciones</a>
            </div>
            <img id="logo-5to-cent" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/front-page/logo-5to-cent.svg" alt="Hotel Quinto Centenario (ex-Sheraton)">
          </div><!-- #front-data -->
        </div><!-- .entry-header -->
      </div>

      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </main><!-- #main -->
  </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
