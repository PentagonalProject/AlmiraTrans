<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}

$this->partial('header');
?>
    <section id="top" class="full-vh">
      <header id="header">
        <div class="navigation">
          <nav class="nav-header">
            <div class="container">
              <ul class="nav">
                <li class="active"><a href="#top">Beranda</a></li>
                <li><a href="#armada">Armada</a></li>
                <li><a href="#package">Paket Wisata</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#contact">Hubungi Kami</a></li>
              </ul>
            </div>
          </nav>
        </div>
      </header>
      <div id="top-feature" class="full-content">
        <div class="overlayed deep-5"></div>
      </div>
    </section>
    <section id="armada" class="full-vh">

    </section>
    <section id="package" class="full-vh">

    </section>
    <section id="about" class="full-vh">
        <div id="map" class="map-preload"></div>
    </section>
    <section id="contact" class="footer">
      <div class="container">
        <footer id="footer">
          <h2>Hubungi Kami</h2>
          <div class="copyright">
            <p>&copy; <?=@date('Y');?></p>
          </div>
        </footer>
      </div>
    </section>
<?php
$this->partial('footer');
