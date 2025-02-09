<?php 

$nilai_input = 100;
$kriteria = array("Sangat Baik", "Baik", "Cukup", "Kuran(g");
$predikat = "";

$return_value = $nilai_input <= 54 ? "Kriteria : ". $kriteria[3]. "\n ". ($predikat = "D") : ($nilai_input <= 59 ? "Kriteria : ". $kriteria[3]. "\n ". ($predikat = "D+") : ($nilai_input <= 64 ? "Kriteria : ". $kriteria[2]. "\n ". ($predikat = "C-") : ($nilai_input <= 69 ? "Kriteria : ". $kriteria[2]. "\n ". ($predikat = "C") : ($nilai_input <= 74 ? "Kriteria : ". $kriteria[2]. "\n ". ($predikat = "C+") : ($nilai_input <= 80 ? "Kriteria : ". $kriteria[1]. "\n ". ($predikat = "B-") : ($nilai_input <= 85 ? "Kriteria : ". $kriteria[1]. "\n ". ($predikat = "B") :( $nilai_input <= 90 ? "Kriteria : ". $kriteria[1]. "\n ". ($predikat = "B+") : ($nilai_input <= 95 ? "Kriteria : ". $kriteria[0]. "\n ". ($predikat = "A-") : ($nilai_input <= 100 ? "Kriteria : ". $kriteria[0]. "\n ". ($predikat = "A+"): "Error Value")))
))))));

echo $return_value;

?>