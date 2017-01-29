<?php $this->layout('layout') ?>

<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h1 style="color:green;font-size:60px">Revistas</h1>
    <p>¡Todas nuestras revistas en versión PDF para que las veas cuando y donde quieras!</p>
    <?php if(count($publicadas) == 0): ?>
        <p>No hay revistas actualmente</p>
    <?php else: ?>
        <?php foreach($publicadas as $revista): ?>
            <article>
                <h2><?= $revista->titulo ?></h2>
                <a style="display:block;margin-bottom: 10px" href="/Revistas/download/<?= $revista->file ?>">Descargar</a><br>
                <img src="<?= IMG . $revista->img ?>" alt="<?= $revista->titulo ?>">

            </article>
            <hr>
        <?php endforeach ?>
    <?php endif ?>
</div>