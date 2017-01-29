<?php $this->layout('layout') ?>
<div class="container">
    <h2>Login Correcto</h2>
    <p>Bienvenido al sistema, <b><?= Session::get('user_nick') ?></b></p>
</div>