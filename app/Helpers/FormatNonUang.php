<?php
function format_non_uang($angka){
     $hasil=number_format($angka,"/[^0-9]/", "");
return $hasil;
}