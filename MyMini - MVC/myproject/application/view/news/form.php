<?php $this->layout('layout') ?>
<?php if (isset($accion) && $accion == "eliminar") $this->insert('partials/deleteNew') ?>
<div class="container">
    <?php if(isset($accion) && $accion == "editar"):
            $titulo = "Editar Noticia";
            $noticia = get_object_vars($noticia);
            $noticia["cuerpo"] = Helpers::br2nl($noticia["cuerpo"]);
            $submit = "Editar";
            $action = $_SERVER['REQUEST_URI'];
          elseif (isset($accion) && $accion == "eliminar"):
            $titulo = "Borrar Noticia";
            $noticia = get_object_vars($noticia);
            $noticia["cuerpo"] = Helpers::br2nl($noticia["cuerpo"]);
            $submit = "Borrar Definitivamente";
            $deshabilitar = "disabled";
            $action = $_SERVER['REQUEST_URI'] . "/confirm";
          else :
            $titulo = "Nueva Noticia";
            $noticia = array();
            $submit = "Crear";
            $action = $_SERVER['REQUEST_URI'];
          endif ?>
    <?php $this->insert('partials/feedback') ?>
    <h2><?= $titulo ?></h2>
    <form action="<?= $action ?>" method="post">
        <p>
            <label for="titulo">Título</label>
            <span><input type="text" name="titulo" value="<?= Helpers::chooseData('titulo', $_POST, $noticia) ?>" <?= isset($deshabilitar) ? $deshabilitar : '' ?> ></span>
        </p>

        <p>
            <label for="cuerpo">Cuerpo</label>
            <textarea name="cuerpo" <?= isset($deshabilitar) ? $deshabilitar : '' ?> ><?= Helpers::chooseData('cuerpo', $_POST, $noticia) ?></textarea  >
        </p>

        <p>
            <label for="publicada" class="line">Publicar</label>
            <input type="checkbox" name="publicada" <?= !empty(Helpers::chooseData('publicada', $_POST, $noticia)) ? "checked='checked'" : "" ?>  <?= isset($deshabilitar) ? $deshabilitar : '' ?> >
        </p>
        <p><input type="submit" value="<?= $submit ?>"></p>
    </form>
</div>