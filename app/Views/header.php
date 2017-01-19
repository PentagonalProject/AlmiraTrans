<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}
?><!DOCTYPE html>
<html lang="id" class="no-js" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->multiByteEntities($this->getAttribute('title'), true);?></title>
  <link rel="canonical" href="<?= $this->getAttribute('base:url');?>">
  <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?callback=initMap" defer></script>
  <script type="text/javascript">
    var jsBody= <?= json_encode(
        [
            "jquery" => $this->getAttribute('base:url') . '/assets/js/jquery.js',
            "waypoints" => $this->getAttribute('base:url') . '/assets/js/waypoints.js',
            "layout" => $this->getAttribute('base:url') . '/assets/js/layout.js'
        ]
    );?>;
  </script>
  <link rel="stylesheet" href="<?= $this->getAttribute('base:url');?>/assets/css/normalize.min.css">
  <link rel="stylesheet" href="<?= $this->getAttribute('base:url');?>/assets/css/layout.css">
  <!-- common meta -->
  <meta name="title" content="<?= $this->multiByteEntities($this->getAttribute('title:meta') ?: $this->getAttribute('title'), true);?>">
  <meta name="description" content="<?= $this->multiByteEntities($this->getAttribute('description:meta') ?: $this->getAttribute('description'));?>">
  <meta name="keywords" content="<?= $this->multiByteEntities($this->getAttribute('keywords:meta') ?: $this->getAttribute('keywords'));?>">
  <!-- open graph -->
  <meta property="og:title" content="<?= $this->multiByteEntities($this->getAttribute('title:og') ?: $this->getAttribute('title:og'), true);?>">
  <meta property="og:type" content="website">
  <meta property="og:description" content="<?= $this->multiByteEntities($this->getAttribute('description:og')?:$this->getAttribute('description'), true);?>">
  <meta property="og:url" content="<?= $this->getAttribute('base:url');?>">
  <meta property="og:locale" content="id_ID">
</head>
<body>
  <div class="wrap">
