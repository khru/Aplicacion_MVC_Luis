<?php $this->layout('layout') ?>
<div class="container">
    <h2>Login de Subscriptores</h2>
    <p><b>Admin: </b>admin/root@gmail.com</p>
    <p><b>Subscriptor: </b>luilli/luilli@gmail.com</p>
    <p><b>Pass: </b>Admin123</p>
    <p>He incluido algo de Ajax aunque no sea evaluable.</p>
    <hr>
    <?php $this->insert('partials/feedback') ?>
    <form action="/Login/dologin" method="post" class="login">
        <section>
            <label>Usuario(Nick/Email):</label>
            <div style="display:inline; " id="msgCheckUsuario"></div><br />
            <script>var datos = new Array();</script>
            <input type="text" name="usuario"  value="<?=isset($_POST['usuario']) ? $_POST['usuario'] : ''?>" onblur="sendRequest('POST', checkLogin, 'checkLogin', this)">
            <div style="display:inline; " id="checkUsuario"></div><br />
            <label>Clave:</label>
            <input type="password" name="clave">
            <br />
            <label>&nbsp;</label>
            <input type="submit" value="Acceder">
        </section>
    </form>
</div>