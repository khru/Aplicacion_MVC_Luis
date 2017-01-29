<?php $this->layout('layout') ?>
<?php if (isset($accion) && $accion == "eliminar") $this->insert('partials/deleteRevista') ?>
<div class="container">
    <?php if(isset($accion) && $accion == "editar"):
            $titulo = "Editar Revista";
            $revista = get_object_vars($revista);
            $submit = "Editar";
            $action = $_SERVER['REQUEST_URI'];
          elseif (isset($accion) && $accion == "eliminar"):
            $titulo = "Borrar revista";
            $revista = get_object_vars($revista);
            $submit = "Borrar Definitivamente";
            $deshabilitar = "disabled";
            $action = $_SERVER['REQUEST_URI'] . "/confirm";
          else :
            $titulo = "Nueva revista";
            $revista = array();
            $submit = "Crear";
            $action = $_SERVER['REQUEST_URI'];
          endif ?>
    <?php $this->insert('partials/feedback') ?>
    <h2><?= $titulo ?></h2>
    <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título</label>
            <input type="text" name="titulo" value="<?= Helpers::chooseData('titulo', $_POST, $revista) ?>" <?= isset($deshabilitar) ? $deshabilitar : '' ?> >
        </p>

        <p>
            <label for="img">Imagen en formato JPG</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="3145728" /> 
            <input type="file" name="img"  <?= isset($deshabilitar) ? $deshabilitar : '' ?> >
            <?php if(isset($accion) && $accion == "editar"): ?>
            <label style="color:purple" for="publicada" class="line"><b>Utilizar la imagen actual del servidor</b></label>
            <input type="checkbox" name="sameImg">
            <?php endif ?>
        </p>

        <p>
            <label for="file">Revista en formato PDF</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="3145728" /> 
            <input type="file" name="file"  <?= isset($deshabilitar) ? $deshabilitar : '' ?> > 
            <?php if(isset($accion) && $accion == "editar"): ?>
            <label style="color:purple" for="publicada" class="line"><b>Utilizar el fichero actual del servidor</b></label>
            <input type="checkbox" name="sameFile">
            <?php endif ?>

        </p>

        <p>
            <label for="publicada" class="line">Publicar</label>
            <input type="checkbox" name="publicada" <?= !empty(Helpers::chooseData('publicada', $_POST, $revista)) ? "checked='checked'" : "" ?>  <?= isset($deshabilitar) ? $deshabilitar : '' ?> >
        </p>
        <p><input type="submit" value="<?= $submit ?>"></p>
    </form>
</div>