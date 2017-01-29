<?php $this->layout('layout') ?>

<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h1 style="color:green;font-size:60px">Noticias</h1>
    <?php if(count($publicadas) == 0): ?>
        <p>No hay noticias que mostrar</p>
    <?php else: ?>
        <?php foreach($publicadas as $noticia): ?>
            <article>
                <a href="/News/seeOne/<?= $noticia->slug ?>"><h2><?= $noticia->titulo ?></h2></a>
                <p>Publicada con fecha de: <?= $noticia->fecha_publicacion ?></p>
            </article>
            <hr>
        <?php endforeach ?>
    <?php endif ?>
</div>