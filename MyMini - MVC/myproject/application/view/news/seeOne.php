<?php $this->layout('layout') ?>
<div class="container">
    <h1><?= $noticia->titulo ?></h1>
    <p><?= $noticia->cuerpo ?></p>
    <p><i><?= "Publicado con fecha de: " . $noticia->fecha_publicacion ?></i></p>
</div>