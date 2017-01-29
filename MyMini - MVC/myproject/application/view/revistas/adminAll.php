<?php $this->layout('layout') ?>
<div class="container">
    <a href="/Revistas/insert">Nueva revista</a>
</div>
<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h2 style="color:brown">Revistas Publicadas</h2>
    <?php if(count($publicadas) == 0): ?>
        <p>No se han encontrado revistas en la base de datos</p>
    <?php else: ?>
        <?php foreach($publicadas as $revista): ?>
            <article>
                <h2><?= $revista->titulo ?></h2>
                <a style="display:block;margin-bottom: 10px" href="/Revistas/download/<?= $revista->file ?>">Descargar</a><br>
                <img src="<?= IMG . $revista->img ?>" alt="<?= $revista->titulo ?>">
                <br><br>
                <a href="/Revistas/edit/<?= $revista->titulo ?>">[ Editar ]</a>
                <a style="margin-left:30px; color:#C93232" href="/Revistas/delete/<?= $revista->titulo ?>">[ Eliminar ]</a>

            </article>
            <hr>
        <?php endforeach ?>
    <?php endif ?>
</div>

<div class="container" style="background: orange">
    <h2 style="color:brown">Revistas No Publicadas</h2>
    <?php if(count($noPublicadas) == 0): ?>
        <p>No se han encontrado revistas en la base de datos</p>
    <?php else: ?>
        <?php foreach($noPublicadas as $revista): ?>
            <article>
                <h2><?= $revista->titulo ?></h2>
                <a style="display:block;margin-bottom: 10px" href="/Revistas/download/<?= $revista->file ?>">Descargar</a><br>
                <img src="<?= IMG . $revista->img ?>" alt="<?= $revista->titulo ?>">
                <br><br>
                <a href="/Revistas/edit/<?= $revista->titulo ?>">[ Editar ]</a>
                <a style="margin-left:30px; color:#C93232" href="/Revistas/delete/<?= $revista->titulo ?>">[ Eliminar ]</a>

            </article>
            <hr>
        <?php endforeach ?>
    <?php endif ?>
</div>