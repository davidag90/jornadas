<?php
// Exit if accessed directly
defined('ABSPATH') || exit;

function show_disertantes()
{
  ob_start();

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

  $query_ext_high = new WP_Query([
    'post_type' => 'disertante',
    'posts_per_page' => -1,
    'meta_query' => [
      'relation' => 'AND',
      'nac_clause' => [
        'key' => 'nacionalidad',
        'value' => 'ar',
        'compare' => 'NOT LIKE'
      ],
      'prio_clause' => [
        'key' => 'prioridad',
        'compare' => '=',
        'value' => 'prioritario'
      ],
      'order_clause' => [
        'key' => 'orden',
        'compare' => 'EXISTS'
      ]
    ],
    'orderby' => 'meta_value_num',
    'meta_key' => 'orden',
    'order' => 'ASC'
  ]);


  if ($query_ext_high->have_posts()) {
    while ($query_ext_high->have_posts()) {
      $query_ext_high->the_post();
      $especialidades = get_field('especialidad');
      $actividades = get_field('actividades');
      $flag = get_field('nacionalidad');
      $thumb = get_the_post_thumbnail_url();

      if (!$thumb) {
        $thumb = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
      }

      echo '<div class="disertante col-12 col-md-6 col-xl-4">';
      echo '<div class="text-light mb-4 pb-4">';
      echo '<div class="row">';
      echo '<div class="col-4 d-flex flex-column justify-content-start">';
      echo '<img src="' . $thumb . '" class="rounded-circle border border-warning border-5" />';
      echo '</div>'; // .col-4
      echo '<div class="col-8 d-flex flex-column justify-content-start">';
      echo '<h2 class="h5"><span class="fi fi-' . $flag . ' me-2"></span>' . get_the_title() . '</h2>';

      if ($especialidades) {
        $especialidades_name = [];

        foreach ($especialidades as $especialidad) {
          array_push($especialidades_name, $especialidad->name);
        }

        echo '<p class="text-uppercase opacity-75"><small>' . implode(' - ', $especialidades_name) . '</small></p>';
      }

      if ($actividades) {
        echo '<ul>';
        foreach ($actividades as $actividad) {
          $id = $actividad->ID;

          $title = get_the_title($id);
          $permalink = get_the_permalink($id);

          echo '<li>';
          echo '<i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title; // Alternative temporary layout
          // echo '<a class="link-light text-decoration-none" href="' . $permalink . '"><i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title . '</a>';
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

  $query_ext = new WP_Query([
    'post_type' => 'disertante',
    'posts_per_page' => -1,
    'meta_query' => [
      'relation' => 'AND',
      'nac_clause' => [
        'key' => 'nacionalidad',
        'value' => 'ar',
        'compare' => 'NOT LIKE'
      ],
      'prio_clause' => [
        'key' => 'prioridad',
        'compare' => 'LIKE',
        'value' => 'no-prioritario'
      ],
      'ap_clause' => [
        'key' => 'apellido',
        'compare' => 'EXISTS'
      ]
    ],
    'orderby' => [
      'prio_clause' => 'DESC',
      'ap_clause' => 'ASC'
    ],
    'meta_key' => 'prioridad',
    'order' => [
      'prioridad' => 'DESC',
      'apellido' => 'ASC'
    ]
  ]);


  if ($query_ext->have_posts()) {
    while ($query_ext->have_posts()) {
      $query_ext->the_post();
      $especialidades = get_field('especialidad');
      $actividades = get_field('actividades');
      $flag = get_field('nacionalidad');
      $thumb = get_the_post_thumbnail_url();

      if (!$thumb) {
        $thumb = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
      }

      echo '<div class="disertante col-12 col-md-6 col-xl-4">';
      echo '<div class="text-light mb-4 pb-4">';
      echo '<div class="row">';
      echo '<div class="col-4 d-flex flex-column justify-content-start">';
      echo '<img src="' . $thumb . '" class="rounded-circle border border-warning border-5" />';
      echo '</div>'; // .col-4
      echo '<div class="col-8 d-flex flex-column justify-content-start">';
      echo '<h2 class="h5"><span class="fi fi-' . $flag . ' me-2"></span>' . get_the_title() . '</h2>';

      if ($especialidades) {
        $especialidades_name = [];

        foreach ($especialidades as $especialidad) {
          array_push($especialidades_name, $especialidad->name);
        }

        echo '<p class="text-uppercase opacity-75"><small>' . implode(' - ', $especialidades_name) . '</small></p>';
      }

      if ($actividades) {
        echo '<ul>';
        foreach ($actividades as $actividad) {
          $id = $actividad->ID;

          $title = get_the_title($id);
          $permalink = get_the_permalink($id);

          echo '<li>';
          echo '<i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title; // Alternative temporary layout
          // echo '<a class="link-light text-decoration-none" href="' . $permalink . '"><i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title . '</a>';
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

  $query_arg = new WP_Query([
    'post_type' => 'disertante',
    'posts_per_page' => -1,
    'meta_query' => [
      'relation' => 'AND',
      'nac_clause' => [
        'key' => 'nacionalidad',
        'value' => 'ar',
        'compare' => 'LIKE'
      ],
      'prio_clause' => [
        'key' => 'prioridad',
        'compare' => 'EXISTS'
      ],
      'ap_clause' => [
        'key' => 'apellido',
        'compare' => 'EXISTS'
      ]
    ],
    'orderby' => [
      'prio_clause' => 'DESC',
      'ap_clause' => 'ASC'
    ],
    'meta_key' => 'prioridad',
    'order' => [
      'prioridad' => 'DESC',
      'apellido' => 'ASC'
    ]
  ]);

  if ($query_arg->have_posts()) {
    while ($query_arg->have_posts()) {
      $query_arg->the_post();
      $actividades = get_field('actividades');
      $especialidades = get_field('especialidad');
      $flag = get_field('nacionalidad');
      $thumb = get_the_post_thumbnail_url();

      if (!$thumb) {
        $thumb = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
      }

      echo '<div class="disertante col-12 col-md-6 col-xl-4">';
      echo '<div class="text-light mb-4 pb-4">';
      echo '<div class="row">';
      echo '<div class="col-4 d-flex flex-column justify-content-start">';
      echo '<img src="' . $thumb . '" class="rounded-circle border border-warning border-5" />';
      echo '</div>'; // .col-4
      echo '<div class="col-8 d-flex flex-column justify-content-start">';
      echo '<h2 class="h5"><span class="fi fi-' . $flag . ' me-2"></span>' . get_the_title() . '</h2>';
      if ($especialidades) {
        $especialidades_name = [];

        foreach ($especialidades as $especialidad) {
          array_push($especialidades_name, $especialidad->name);
        }

        echo '<p class="text-uppercase opacity-75"><small>' . implode(' - ', $especialidades_name) . '</small></p>';
      }

      if ($actividades) {
        echo '<ul>';
        foreach ($actividades as $actividad) {
          $id = $actividad->ID;

          $title = get_the_title($id);
          $permalink = get_the_permalink($id);

          echo '<li>';
          echo '<i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title; // Alternative temporary layout
          // echo '<a class="link-light text-decoration-none" href="' . $permalink . '"><i class="fa-solid fa-asterisk fa-xs me-1"></i>' . $title . '</a>';
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



function show_sponsors_logos()
{
  ob_start();

  $query = new WP_Query([
    'post_type' => 'sponsor',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title'
  ]);

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

    echo '</div>'; // .sponsors-container
  }

  wp_reset_postdata();

  $output = ob_get_clean();

  return $output;
}

add_shortcode('show_sponsors_logos', 'show_sponsors_logos');


function show_adhesiones()
{
  ob_start();

  $query = new WP_Query([
    'post_type' => 'adhesion',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title'
  ]);

  if ($query->have_posts()) {
    echo '<div class="instituciones-container">';
    while ($query->have_posts()) {
      $query->the_post();

      $name = get_the_title();
      $link = get_field('link');
      $logo = get_the_post_thumbnail_url();

      echo '<div class="institucion">';
      if ($link) echo '<a href="' . $link . '" target="_blank" rel="noopener noreferrer">';
      echo '<img src="' . $logo . '" alt="' . $name . '" />';
      if ($link) echo '</a>';
      echo '</div>'; // .institucion
    }

    echo '</div>'; // .instituciones-container
  }

  wp_reset_postdata();

  $output = ob_get_clean();

  return $output;
}

add_shortcode('show_adhesiones', 'show_adhesiones');



function cat_pre_order()
{
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
      echo '<div id="cat_inscripcion_help" class="form-text text-light">Por favor, elija con cuidado la categoría de inscripción adecuada, recuerde que pos-inscripción deberá acreditarla ante el personal del evento</div>';
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



function get_agenda_events()
{
  ob_start();

  $actividad_fields = acf_get_fields('group_673e15fe9bfb2');

  $salones = [];

  foreach ($actividad_fields as $field) {
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
  }

  wp_reset_postdata();

  $query_program = new WP_Query([
    'post_type' => 'attachment',
    'post_status' => 'any',
    'name' => 'programa-completo'
  ]);

  $url_program = get_permalink($query_program->post);

  wp_reset_postdata();

  echo '<div id="agenda-controls" class="mb-3">';
  echo '<div class="row">';
  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  // echo '<label for="filter-salon" class="form-label">Salón</label>';
  echo '<select class="form-select jnd-filter" name="filter-salon" id="filter-salon" jnd-filter-target="jnd-salon">';
  echo '<option value="all" selected>Elegir un salón</option>';
  foreach ($salones as $value => $label) {
    echo '<option value="' . $value . '">' . $label . '</option>';
  }
  echo '</select>';
  echo '</div>';

  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<select class="form-select jnd-filter" name="filter-especialidad" id="filter-especialidad" jnd-filter-target="jnd-especialidad">';
  echo '<option value="all" selected>Elegir una especialidad</option>';

  foreach ($especialidades as $especialidad) {
    echo '<option value="' . $especialidad->slug . '">' . $especialidad->name . '</option>';
  }

  echo '</select>';
  echo '</div>';

  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<select class="form-select jnd-filter" name="filter-disertante" id="filter-disertante" jnd-filter-target="jnd-disertante">';
  echo '<option value="all" selected>Elegir un disertante</option>';

  foreach ($disertantes as $disertante) {
    echo '<option value="' . $disertante['slug'] . '">' . $disertante['apellido'] . ', ' . $disertante['nombre'] . '</option>';
  }

  echo '</select>';
  echo '</div>';
  echo '</div>'; // .row
  echo '<div class="row">';
  echo '<div class="col-12 col-md-6 col-xl-4 mb-3">';
  echo '<button type="button" class="btn btn-dark jnd-filter-reset">Limpiar filtros</button>';
  if ($url_program) echo '<a href="' . $url_program . '" target="_blank" class="btn btn-warning ms-1">Descargar programa</a>';
  echo '</div>'; // .col-12
  echo '</div>'; // .row
  echo '</div>'; // #agenda-controls

  $args = [
    'post_type' => 'actividad',
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'meta_type' => 'DATETIME',
    'meta_key' => 'inicio',
    'order' => 'ASC'
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    echo '<div class="col-12">';
    echo '<div id="agenda-events">';
    while ($query->have_posts()) {
      $query->the_post();

      $evt = [
        "id" => get_the_ID(),
        "title" => get_the_title(),
        "terms_objs" => get_the_terms(get_the_ID(), 'especialidad') ?? null,
        "disertantes" => get_field('disertantes') ?? null,
        "salon" => get_field('salon') ?? '',
        "link" => get_the_permalink() ?? null,
      ];

      (get_field('inicio')) ? $evt["start"] = new DateTime(get_field('inicio')) : $evt['start'] = null;
      (get_field('fin')) ? $evt["end"] = new DateTime(get_field('fin')) : $evt['end'] = null;

      /* $key_check = true;
      foreach ($evt as $evt_key) {
        if (! isset($evt_key)) {
          $key_check = false;
        }
      } */

      // if ($key_check) {
      $especialidades_name = [];
      $especialidades_slug = [];

      foreach ($evt['terms_objs'] as $especialidad) {
        array_push($especialidades_name, $especialidad->name);
        array_push($especialidades_slug, $especialidad->slug);
      }

      $disertantes = [];
      $disertantes_slug = [];

      foreach ($evt['disertantes'] as $disertante) {
        array_push(
          $disertantes,
          array(
            'nombre' => $disertante->post_title,
            'nacionalidad' => get_field('nacionalidad', $disertante->ID)
          )
        );
        array_push($disertantes_slug, $disertante->post_name);
      }

      echo '<div class="agenda-event mb-4 p-3 d-block border-start border-5 border-dark bg-light-subtle rounded-end" jnd-salon="';
      echo (isset($evt['salon']['value'])) ? $evt['salon']["value"] : '';
      echo '" jnd-especialidad="';
      echo (isset($especialidades_slug[0])) ? implode(' ', $especialidades_slug) : 'none';
      echo '" jnd-disertante="' . implode(' ', $disertantes_slug) . '" jnd-event-id="' . $evt['id'] . '">';
      if ($evt["link"]) echo '<a href="' . $evt['link'] . '" class="text-decoration-none">';
      echo '<h3 class="h5">' . $evt['title'] . '</h3>';
      echo '<div class="event-details mb-0 text-dark">';
      if ($especialidades_name) echo '<span><i class="fa-solid fa-book-bookmark me-2"></i>' . implode(', ', $especialidades_name) . '</span>';
      if (isset($evt['salon']['label'])) echo '<span><i class="fa-solid fa-location-dot me-2"></i>' . $evt['salon']['label'] . '</span>';
      echo '<span>';

      foreach ($disertantes as $disertante) {
        echo '<span class="d-block d-md-inline me-2"><span class="fi fi-' . $disertante['nacionalidad'] . ' me-1"></span>' . $disertante['nombre'] . '</span>';
      }

      echo '</span>';
      if ($evt['start'] && $evt['end']) {
        echo '<span><i class="fa-regular fa-calendar-days me-2"></i>' . wp_date('j \d\e F \d\e Y', $evt['start']->getTimestamp()) . '</span>';
        echo '<span><i class="fa-regular fa-clock me-2"></i>' . $evt['start']->format('H:i') . ' a ' . $evt['end']->format('H:i') . ' hs.</span>';
      }
      echo '</div>'; // .event-details
      if ($evt["link"]) echo '</a>';
      echo '</div>'; // .agenda-event
      // }
    }
    echo '</div>'; // #agenda-events
    echo '</div>'; // .col-12
  } else {
    echo '<p>Contenidos no encontrados.</p>';
  }

  $output = ob_get_clean();

  return $output;
}

add_shortcode('get_agenda_events', 'get_agenda_events');



function show_frontpage_destacado()
{
  ob_start();

  $query = new WP_Query([
    'post_type' => 'destacado',
    'posts_per_page' => '-1'
  ]);

  if ($query->have_posts()) {
    echo '<div id="front-page-highlight">';
    while ($query->have_posts()) {
      $query->the_post();

      $link = get_field('link');
      $img_mobile = get_field('img_mobile');
      $img_desktop = get_field('img_desktop');

      if ($link) echo '<a href="' . $link . '" class="front-page-highlight__link" target="_blank">';
      echo '<picture>';
      echo '<source srcset="' . esc_url($img_mobile) . '" class="d-block w-100 front-page-highlight__mobile" media="(max-width:768px)">';
      echo '<img src="' . esc_url($img_desktop) . '" class="d-block w-100 front-page-highlight__desktop">';
      echo '</picture>';
      if ($link) echo '</a>'; // .front-page-highlight__link
    }
    echo '</div>';
  }

  $output = ob_get_clean();

  return $output;
}

add_shortcode('show_frontpage_destacado', 'show_frontpage_destacado');
