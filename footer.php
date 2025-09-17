<?php
// Exit if accessed directly
defined('ABSPATH') || exit;
?>

<footer id="main-footer">
  <?php if (is_front_page()): ?>
    <div id="credits" class="w-100 d-flex justify-content-center align-items-center bg-primary-subtle text-dark bg-gradient py-2">
      <div>Organiza <a href="https://coc-cordoba.org.ar/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer/coc.png" alt="Circulo Odontológico de Córdoba"></a></div>
    </div>
  <?php endif; ?>
  <?php $upload_dir = wp_upload_dir(); ?>

  <nav class="navbar fixed-bottom bg-primary py-0">
    <div class="container-fluid justify-content-center border-top border-2 border-primary-subtle">
      <div class="navbar-nav w-100">
        <!-- Activate later
        <a href="<?php echo home_url(); ?>/programa-completo/" class="nav-link link-light d-block flex-column justify-content-center">
          <div class="footer-link-icon text-center fs-2">
            <i class="fa-solid mb-1 fa-file-lines"></i>
          </div>
          <div class="link-detail text-center">
            <span class="link-detail text-decoration-none">Programa</span>
          </div>
        </a>
        <a href="<?php echo home_url(); ?>/agenda/" class="nav-link link-light  d-block flex-column justify-content-center">
          <div class="footer-link-icon text-center fs-2">
            <i class="fa-solid my-1 fa-calendar-days"></i>
          </div>
          <div class="link-detail text-center">
            <span class="link-detail text-decoration-none">Agenda</span>
          </div>
        </a>
        -->
        <a href="<?php echo home_url(); ?>/disertantes/" class="nav-link link-light d-block flex-column justify-content-center">
          <div class="footer-link-icon text-center fs-2">
            <i class="fa-solid my-1 fa-user-tie"></i>
          </div>
          <div class="link-detail text-center">
            <span class="link-detail text-decoration-none">Disertantes</span>
          </div>
        </a>
        <a href="<?php echo home_url(); ?>/sede/" class="nav-link link-light d-block flex-column justify-content-center">
          <div class="footer-link-icon text-center fs-2">
            <i class="fa-solid my-1 fa-location-dot"></i>
          </div>
          <div class="link-detail text-center">
            <span class="link-detail text-decoration-none">Sede</span>
          </div>
        </a>
        <a href="<?php echo home_url(); ?>/contacto/" class="nav-link link-light d-block flex-column justify-content-center">
          <div class="footer-link-icon text-center fs-2">
            <i class="fa-solid my-1 fa-mobile-screen"></i>
          </div>
          <div class="link-detail text-center">
            <span class="link-detail text-decoration-none">Contacto</span>
          </div>
        </a>
      </div>
    </div>
  </nav>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>