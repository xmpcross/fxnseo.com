<?php 

namespace App\Classes;

class BackwardsTextGeneratorClass {

    public function get_data($text)
    {
        try {

            $data = $this->mb_strrev( $text );
            
            return $data;
            
        } catch (\Exception $e) {

            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }

    }

    /**
     * -------------------------------------------------------------------------------
     *  mb_strrev
     * -------------------------------------------------------------------------------
    **/
    function mb_strrev($string) {
        $reversed = "";
        for ($i = mb_strlen($string); $i >= 0; $i--) {
            $reversed .= mb_substr($string, $i, 1);
        }
        return $reversed;
    }
}