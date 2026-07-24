<?php 

namespace App\Classes;
use FineDiff\Diff;

class TextCompareClass {

    public function get_data($text_one, $text_two)
    {
        try {


            $diff         = new Diff();

            $from_text    = mb_convert_encoding($text_one, 'HTML-ENTITIES', 'UTF-8');
            $to_text      = mb_convert_encoding($text_two, 'HTML-ENTITIES', 'UTF-8');

            $html         = $diff->render($from_text, $to_text);

            $result = html_entity_decode($html, ENT_QUOTES, 'UTF-8');

            return $result;
            
        } catch (\Exception $e) {

            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }

    }
}