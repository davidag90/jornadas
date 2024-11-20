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
    'slug' => 'inscripcion'
  ]);

  $inscripcion_id = 0;

  if (sizeof($products) == 1) {
    $inscripcion_id = $products[0]->get_id();
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


function get_agenda_events() {
  ob_start();

  $conferencia_fields = acf_get_fields('group_671964041a098');

  $salones = [];

  foreach ($conferencia_fields as $field) {
    if ($field['type'] == 'select' && $field['name'] == 'salon') {
      $salones = $field['choices'];

      break;
    }
  }

  $especialidades = get_terms([
    'taxonomy' => 'especialidad'
  ]);

  $query_disertantes = new WP_Query([
    'post_type' => 'disertante',
    'posts_per_page' => -1,
    'orderby' => array(
      'apellido' => 'ASC',
      'nombre' => 'ASC'
    ),
    'meta_query' => array(
      'apellido' => array(
        'key' => 'apellido',
        'compare' => 'EXISTS'
      ),
      'nombre' => array(
        'key' => 'nombre',
        'compare' => 'EXISTS'
      )
    )
  ]);

  $disertantes = [];

  if ($query_disertantes->have_posts()) {
    while ($query_disertantes->have_posts()) {
      $query_disertantes->the_post();

      $disertante_nombre = get_field('nombre');
      $disertante_apellido = get_field('apellido');
      $disertante_slug = get_post_field('post_name');

      array_push($disertantes, [
        "nombre" => $disertante_nombre,
        "apellido" => $disertante_apellido,
        "slug" => $disertante_slug
      ]);
    }

    wp_reset_postdata();
  }

  echo '<div id="agenda-controls" class="mb-3">';
  echo '<div class="row">';
  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<label for="filter-salon" class="form-label">Salón</label>';
  echo '<select class="form-select jnd-filter" name="filter-salon" id="filter-salon" jnd-filter-target="jnd-salon">';
  echo '<option value="all" selected>Todos los salones</option>';
  foreach ($salones as $value => $label) {
    echo '<option value="' . $value . '">' . $label . '</option>';
  }
  echo '</select>';
  echo '</div>';

  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<label for="filter-especialidad" class="form-label">Especialidad</label>';
  echo '<select class="form-select jnd-filter" name="filter-especialidad" id="filter-especialidad" jnd-filter-target="jnd-especialidad">';
  echo '<option value="all" selected>Todas las especialidades</option>';

  foreach ($especialidades as $especialidad) {
    echo '<option value="' . $especialidad->slug . '">' . $especialidad->name . '</option>';
  }

  echo '</select>';
  echo '</div>';

  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<label for="filter-disertante" class="form-label">Disertante</label>';
  echo '<select class="form-select jnd-filter" name="filter-disertante" id="filter-disertante" jnd-filter-target="jnd-disertante">';
  echo '<option value="all" selected>Todos los disertantes</option>';

  foreach ($disertantes as $disertante) {
    echo '<option value="' . $disertante['slug'] . '">' . $disertante['apellido'] . ', ' . $disertante['nombre'] . '</option>';
  }

  echo '</select>';
  echo '</div>';
  echo '</div>'; // .row
  echo '<div class="row">';
  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<button type="button" class="btn btn-dark jnd-filter-reset">Limpiar filtros</button>';
  echo '</div>'; // .col-12
  echo '</div>'; // .row
  echo '</div>'; // #agenda-controls

  $args = [
    'post_type' => 'conferencia',
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'meta_type' => 'DATETIME',
    'meta_key' => 'inicio',
    'order' => 'ASC'
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    echo '<div id="agenda-events" class="text-bg-light rounded border-light">';
    while ($query->have_posts()) {
      $query->the_post();

      $evt = [
        "id" => get_the_ID(),
        "title" => get_the_title(),
        "start" => new DateTime(get_field('inicio')),
        "end" => new DateTime(get_field('fin')),
        "terms_objs" => get_the_terms(get_the_ID(), 'especialidad'),
        "disertantes" => get_field('disertantes'),
        "salon" => get_field('salon'),
        "link" => get_the_permalink()
      ];

      $key_check = true;
      foreach ($evt as $evt_key) {
        if (! isset($evt_key)) {
          $key_check = false;
        }
      }

      if ($key_check) {
        $especialidades_name = [];
        $especialidades_slug = [];

        foreach ($evt['terms_objs'] as $especialidad) {
          array_push($especialidades_name, $especialidad->name);
          array_push($especialidades_slug, $especialidad->slug);
        }

        $disertantes = [];
        $disertantes_slug = [];

        foreach ($evt['disertantes'] as $disertante) {
          array_push($disertantes, $disertante->post_title);
          array_push($disertantes_slug, $disertante->post_name);
        }

        echo '<div class="agenda-event py-3 d-block" jnd-salon="' . $evt['salon']['value'] . '" jnd-especialidad="' . implode(' ', $especialidades_slug) . '" jnd-disertante="' . implode(' ', $disertantes_slug) . '" jnd-event-id="' . $evt['id'] . '">';
        echo '<div class="event-especialidades mb-1">';
        foreach ($especialidades_name as $especialidad) {
          echo '<span class="badge text-bg-secondary"><small>' . $especialidad . '</small></span>';
        }
        echo '</div>';
        echo '<h3 class="h5"><a href="' . $evt['link'] . '">' . $evt['title'] . '</a></h3>';
        echo '<p class="mb-0">';
        echo '<span class="me-3 d-block d-md-inline"><i class="fa-solid fa-location-dot me-1"></i>' . $evt['salon']['label'] . '</span>';
        echo '<span class="me-3 d-block d-md-inline"><i class="fa-regular fa-calendar-days me-1"></i>' . wp_date('j \d\e F \d\e Y', $evt['start']->getTimestamp()) . '</span>';
        echo '<span class="d-block d-md-inline"><i class="fa-regular fa-clock me-1"></i>' . $evt['start']->format('H:i') . ' a ' . $evt['end']->format('H:i') . ' hs.</span>';
        echo '</p>';
        echo '</div>'; // .agenda-event
      }
    }
    echo '</div>'; // #agenda-events
  } else {
    echo '<p>Contenidos no encontrados.</p>';
  }

  $output = ob_get_clean();

  return $output;
}

add_shortcode('get_agenda_events', 'get_agenda_events');
