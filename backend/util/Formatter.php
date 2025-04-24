<?php 
function formatCurrency($number) {
    return number_format($number, 0, '', '.');
}

function formatDateTime($datetimeString) {
    $date = new DateTime($datetimeString);
    return $date->format('d/m/Y H:i:s');
}

?>