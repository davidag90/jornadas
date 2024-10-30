<?php
// Exit if accessed directly
defined('ABSPATH') || exit;

function show_disertantes() {
  ob_start();

  $args = [
    'post_type' => 'disertante',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title'
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    echo '<div class="col-12">';
    echo '<div id="search-disertantes" class="mb-5">';
    echo '<form>';
    echo '<div class="input-group">';
    echo '<input type="text" id="query-disertante" class="form-control bg-light bg-opacity-10 text-light" aria-label="Consulta de búsqueda de Disertantes" placeholder="Buscar disertante...">';
    echo '<span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>';
    echo '</div>';
    echo '</form>';
    echo '</div>'; // #search-disertantes
    echo '</div>'; // .col-12

    while ($query->have_posts()) {
      $query->the_post();
      $conferencias = get_field('conferencias');

      $thumb = get_the_post_thumbnail_url();

      if (!$thumb) {
        $thumb = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
      }

      echo '<div class="col-12 col-md-6 col-xl-4">';
      echo '<div class="disertante text-light mb-4 pb-4">';
      echo '<div class="row">';
      echo '<div class="col-4 d-flex flex-column justify-content-center">';
      echo '<img src="' . $thumb . '" class="rounded-circle border border-warning border-5" />';
      echo '</div>'; // .col-4
      echo '<div class="col-8 d-flex flex-column justify-content-center">';
      echo '<h2 class="h5">' . get_the_title() . '</h2>';
      if ($conferencias) {
        echo '<ul>';
        foreach ($conferencias as $conferencia) {
          $id = $conferencia->ID;

          $title = get_the_title($id);
          $permalink = get_the_permalink($id);

          echo '<li>';
          echo '<a class="link-light text-decoration-none" href="' . $permalink . '"><i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title . '</a>';
          echo '</li>';
        }
        echo '</ul>';
      }
      echo '</div>'; // .col-8
      echo '</div>'; // .row
      echo '</div>'; // .disertante
      echo '</div>'; // col-12 col-md-4 col-xl-3
    }
  }

  $output = ob_get_clean();

  return $output;
}

add_shortcode('show_disertantes', 'show_disertantes');
