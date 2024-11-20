<?php
// Exit if accessed directly
defined('ABSPATH') || exit;
?>

<footer id="main-footer">
  <div id="credits" class="w-100 d-flex justify-content-center align-items-center bg-primary-subtle text-dark bg-gradient py-2">
    <div>Organiza <a href="https://coc-cordoba.org.ar/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer/coc.png" alt="Circulo Odontológico de Córdoba"></a></div>
  </div>

  <nav class="navbar fixed-bottom bg-primary py-0">
    <div class="container-fluid justify-content-center border-top border-2 border-primary-subtle">
      <div class="navbar-nav w-100">
        <a href="<?php echo home_url(); ?>/disertantes" class="nav-link link-light text-center"><i class="fa-solid fs-2 my-1 fa-user-tie d-block"></i><span class="link-detail d-block text-decoration-none">Disertantes</a>
        <!-- <a href="#" class="nav-link link-light text-center"><i class="fa-solid fs-1 mb-1 fa-file-lines d-block"></i><span class="link-detail d-block text-decoration-none">Programa</a> -->
        <a href="<?php echo home_url(); ?>/agenda" class="nav-link link-light text-center"><i class="fa-solid fs-2 my-1 fa-calendar-days d-block"></i><span class="link-detail d-block text-decoration-none">Agenda</a>
        <a href="<?php echo home_url(); ?>/sede" class="nav-link link-light text-center"><i class="fa-solid fs-2 my-1 fa-location-dot d-block"></i><span class="link-detail d-block text-decoration-none">Sede</a>
        <a href="<?php echo home_url(); ?>/contacto" class="nav-link link-light text-center"><i class="fa-solid fs-2 my-1 fa-mobile-screen d-block"></i><span class="link-detail d-block text-decoration-none">Contacto</a>
      </div>
    </div>
  </nav>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>