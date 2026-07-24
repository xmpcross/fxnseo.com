<?php 

namespace App\Classes;

class TextToHashtagsClass {

	public function get_data($text)
	{
        try {
            
            // Split the text into words
            $words = preg_split('/\s+/', $text);
            
            // Convert each word to a hashtag, and remove any non-alphanumeric characters
            $hashtags = array_map(function($word) {
                return '#' . preg_replace('/[^\w]/', '', $word);
            }, $words);
            
            // Join the hashtags into a single string, separated by spaces
            $data = implode(' ', $hashtags);
            
            return $data;
            
        } catch (\Exception $e) {

            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }

	}
}