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

  wp_reset_postdata();

  $output = ob_get_clean();

  return $output;
}

add_shortcode('show_disertantes', 'show_disertantes');

function show_sponsors_logos() {
  ob_start();

  $args = [
    'post_type' => 'sponsor',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title'
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    echo '<div class="sponsors-container">';
    while ($query->have_posts()) {
      $query->the_post();

      $name = get_the_title();
      $link = get_field('link');
      $logo = get_the_post_thumbnail_url();

      echo '<div class="sponsor">';
      if ($link) echo '<a href="' . $link . '" target="_blank" rel="noopener noreferrer">';
      echo '<img src="' . $logo . '" alt="' . $name . '" />';
      if ($link) echo '</a>';
      echo '</div>'; // .sponsor
    }

    echo '</div>'; // .sponsors-containers
  }

  wp_reset_postdata();

  $output = ob_get_clean();

  return $output;
}

add_shortcode('show_sponsors_logos', 'show_sponsors_logos');


function cat_pre_order() {
  ob_start();

  $products = wc_get_products([
    'status' => 'publish'
  ]);

  $inscripcion_id = 0;

  if ($products) {
    foreach ($products as $product) {
      $product_slug = $product->get_slug();

      if ($product_slug === 'inscripcion') {
        $inscripcion_id = $product->get_id();
      }
    }
  } else {
    echo '<p>Error de sistema, intente nuevamente más tarde</p>';

    $output = ob_get_clean();

    return $output;
  }

  $inscripcion = wc_get_product($inscripcion_id);

  if ($inscripcion) {
    $variations = $inscripcion->get_children();

    if ($variations) {
      echo '<div id="cat_pre_order">';
      echo '<div class="mb-3">';
      echo '<label for="cat_inscripcion" class="form-label">Elija una categoría para su inscripción</label>';
      echo '<select id="cat_inscripcion" class="form-select" aria-label="Elija la categoría de su inscripción" aria-describedby="passwordHelpBlock">';
      echo '<option value="" selected>Seleccione una categoría...</option>';
      foreach ($variations as $variation) {
        $variation_product = wc_get_product($variation);
        echo '<option value="' . $variation_product->get_id() . '">' . $variation_product->get_attribute('categoria') . '</option>';
      }
      echo '</select>';
      echo '<div id="cat_inscripcion_help" class="form-text">Por favor, elija con cuidado la categoría de inscripción adecuada, recuerde que pos-inscripción deberá acreditarla ante el personal del evento</div>';
      echo '</div>'; // .mb-3
      echo '<div class="mb-3">';
      echo '<a id="btn_pre_order" class="btn btn-warning disabled" href="' . esc_url(home_url() . '/finalizar-compra/?add-to-cart=') . '">Iniciar inscripción <i class="fa-solid fa-caret-right"></i></a>';
      echo '</div>'; // .mb-3
      echo '</div>'; // #cat_pre_order
    } else {
      ob_end_clean();

      return;
    }
  } else {
    echo "<p>Error de sistema, intente nuevamente más tarde</p>";
  }

  $output = ob_get_clean();

  return $output;
}

add_shortcode('cat_pre_order', 'cat_pre_order');
