<?php
use Pentagonal\Project\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}

$this->partial('header');
$this->partial('footer');