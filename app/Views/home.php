<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}

$this->partial('header');
?>
    <section id="top" class="full-vh">
      <div id="nav-button">
        expand
      </div>
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
        <div class="contain-top">
          <div class="main-title">
            <h1 class="main">ALMIRA</h1>
            <h3 class="desc">TRANS WISATA</h3>
          </div>
        </div>
      </div>
    </section>
  <section id="city">
    <div id="car-scroll">
      <div class="building"></div>
      <div class="scroll-infinity road">
        <div class="car-jazz">
          <div class="inner">
            <img class="tire first rotate" src="<?= $this->getAttribute('base:url');?>/assets/images/animated/tire.png">
            <img src="<?= $this->getAttribute('base:url');?>/assets/images/animated/jazz.png">
            <img class="tire last rotate" src="<?= $this->getAttribute('base:url');?>/assets/images/animated/tire.png">
          </div>
        </div>
      </div>
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
