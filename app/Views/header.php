<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}
?><!--
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-     _____  ____  ______  ___  ______  _____  ____  ______ ______   ___    -
-    /  __ \/ __ \/  __  \/  /_ \___  \/ __  \/ __ \/  __  \\___  \ /  /    -
-    / /_/ /  ___/  / /  /  __//  _   / /_/  / /_/ /  / /  /  _   //  /     -
-   /  .__/\____/\_/ /__/\____/\___._/\__   /\____/\_/ /__/\___._//  /      -
-  /  /  _________________________  ____/  /                     /  /____   -
- /__/  \________________________/ /______/                     ._______/   -
-                                                                           -
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-->
<!DOCTYPE html>
<html lang="id" class="no-js" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->multiByteEntities($this->getAttribute('title'), true);?></title>
  <link rel="canonical" href="<?= $this->getAttribute('base:url');?>">
  <script type="text/javascript">
    var map,
        jsBody= <?= json_encode(
        [
            "jquery" => $this->getAttribute('base:url') . '/assets/js/jquery.js',
            "waypoints" => $this->getAttribute('base:url') . '/assets/js/waypoints.js',
            "jssor" => $this->getAttribute('base:url') . '/assets/js/jssor.slider-22.1.6.mini.js',
            "layout" => $this->getAttribute('base:url') . '/assets/js/layout.js',
            "map" => $this->getAttribute('base:url') . '/assets/js/map.js',
        ]
    );?>,
        BaseUrl = <?= json_encode($this->getAttribute('base:url'));?>,
        MapLatLong = {lat: <?= $this->getAttribute('map:latitude')?: '-7.9240115';?>, lng: <?= $this->getAttribute('map:longitude')?: '112.5958141';?>},
        MarkerContainer = <?= json_encode($this->getAttribute('map:marker'));?>,
        initMap = function (){};
  </script>
  <link rel="stylesheet" href="<?= $this->getAttribute('base:url');?>/assets/css/normalize.min.css">
  <link rel="stylesheet" href="<?= $this->getAttribute('base:url');?>/assets/css/layout.css">
  <link href="<?= $this->getAttribute('base:url');?>/google-fonts/Lato:300,400,700-Lobster.css" rel="stylesheet" type="text/css">
  <!-- common meta -->
  <meta name="title" content="<?= $this->multiByteEntities($this->getAttribute('title:meta') ?: $this->getAttribute('title'), true);?>">
  <meta name="description" content="<?= $this->multiByteEntities($this->getAttribute('description:meta') ?: $this->getAttribute('description'));?>">
  <meta name="keywords" content="<?= $this->multiByteEntities($this->getAttribute('keywords:meta') ?: $this->getAttribute('keywords'));?>">
  <!-- open graph -->
  <meta property="og:title" content="<?= $this->multiByteEntities($this->getAttribute('title:og') ?: $this->getAttribute('title'), true);?>">
  <meta property="og:type" content="website">
  <meta property="og:description" content="<?= $this->multiByteEntities($this->getAttribute('description:og')?:$this->getAttribute('description'), true);?>">
  <meta property="og:url" content="<?= $this->getAttribute('base:url');?>">
  <meta property="og:locale" content="id_ID">
</head>
<body>
  <div class="wrap">
