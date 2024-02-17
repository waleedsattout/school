<?php

namespace App\Libraries;
class ToArabic {

    public function to_ar_num($num){
        $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        return str_replace($western_arabic, $eastern_arabic, $num);
    }
}
?>