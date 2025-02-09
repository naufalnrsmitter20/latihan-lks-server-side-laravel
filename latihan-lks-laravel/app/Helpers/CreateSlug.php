<?php 
namespace App\Helpers;

class CreateSlug{
    public function postSlugCreation(String $text){
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/','', $text);
        $text = preg_replace('/\s+/','-',$text);
        $text = trim($text, "-");
        return $text;
    }
}

?>