<?php

namespace App\Services;

class Slug
{
    /**
     * @param String $text
     * @return string
     */
    public function generate(String $text): string
    {
        /* Generate a slug from string, example : */
        /* "Un nouveau Trick" => "un-nouveau-trick" */
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }



}
