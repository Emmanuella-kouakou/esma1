<?php

function calculerMoyenne($notes) {
    
    if (empty($notes)) {
        return 0;
    }

    $somme = array_sum($notes);
    $nombre = count($notes);

    return $somme / $nombre;
}