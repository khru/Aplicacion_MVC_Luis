<?php $this->layout('layout') ?>
<div class="container">
    <a href="/News/insert">Nueva noticia</a>
</div>
<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h2 style="color:brown">Noticias Publicadas</h2>
    <?php if(count($publicadas) == 0): ?>
        <p>No se encuentran noticias en la Base de Datos</p>
    <?php else: ?>
        <?php foreach($publicadas as $noticia): ?>
            <article class="noticia">
                <a href="/News/seeOne/<?= $noticia->slug ?>"><h3 style="color:green"><?= $noticia->titulo ?></h3></a>
                <p>Publicada con fecha de: <?= $noticia->fecha_publicacion ?></p>
                <footer>
                    <a href="/News/edit/<?= $noticia->slug ?>">[ Editar ]</a>
                    <a style="margin-left:30px; color:#C93232" href="/News/delete/<?= $noticia->slug ?>">[ Eliminar ]</a>
                </footer>
            </article>
            <hr>
        <?php endforeach ?>
    <?php endif ?>
</div>

<div class="container">
    <h2 style="color:brown">Noticias No Publicadas</h2>
    <?php if(count($noPublicadas) == 0): ?>
        <p>No se encuentran noticias en la Base de Datos</p>
    <?php else: ?>
        <?php foreach($noPublicadas as $noticia): ?>
            <article class="noticia">
                <a href="/News/seeOne/<?= $noticia->slug ?>"><h3 style="color:green"><?= $noticia->titulo ?></h3></a>
                <p>Publicada con fecha de: <?= $noticia->fecha_publicacion ?></p>
                <footer>
                    <a href="/News/edit/<?= $noticia->slug ?>">[ Editar ]</a>
                    <a style="margin-left:30px; color:#C93232" href="/News/delete/<?= $noticia->slug ?>">[ Eliminar ]</a>
                </footer>
            </article>
            <hr>
        <?php endforeach ?>
    <?php endif ?>
</div>