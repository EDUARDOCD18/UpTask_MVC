<?php

foreach ($alertas as $key => $alerta) :
    foreach ($alerta as $mensaje) : ?>

        <div class="alerta" <?php $key; ?>><?php $mensaje; ?></div>
<?php
    endforeach;
endforeach;
?>