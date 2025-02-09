<?php 
class classess{
    public $name;
    public $school;
    public $NISN;

    function set_name($name){
        $this->name = $name;
    }

    function set_school($school) {
        $this->school = $school;
    }

    function set_NISN($NISN) {
        $this->NISN = $NISN;
    }

    function get_name(){
        return $this->name;
    }

    function get_school(){
        return $this->school;
    }

    function get_NISN(){
        return $this->NISN;
    }

}

$siswa1 = new classess();
$siswa2 = new classess();

// set values
$siswa1->set_name("Naufal Nabil Ramadhan");
$siswa1->set_school("SMK Telkom Malang");
$siswa1->set_NISN("0076311489");

print_r("Nama : " . $siswa1->get_name() . "\n" . "Sekolah : " . $siswa1->get_school() . "\n" . "NISN : " . $siswa1->get_NISN())

?>