<?php

function imprimirCard($nombre, $url, $icon)
{
    $cardHTML = '
    <div class="col mb-3 mb-lg-5">
        <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center">
            <div class="card-header card-header-content-between border-0">
            </div>

            <div class="card-body">
                <img class="avatar avatar-xxl" src="' . $icon . '" alt="Image Description">
            </div>

            <div class="card-body">
                <h4 class="card-title">' . $nombre . '</h4>
                <p class="small">Ingresar al reporte</p>
            </div>

            <a class="stretched-link" href="' . $url . '"></a>
        </div> </div>
    ';

    echo $cardHTML;
}
