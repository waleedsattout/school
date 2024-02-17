<?php
function flipWords($word1, $word2)
{
    $locale = session()->get('language');
    $sentence = '';

    if ($locale === 'en') {
        $sentence = $word1 . ' ' . $word2;
    } elseif ($locale === 'ar') {
        $sentence = $word2 . ' ' . $word1;
    }
    return $sentence;
}
