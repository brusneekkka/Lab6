<?php
    require_once ('vendor/autoload.php');
    use \Dejurin\GoogleTranslateForFree;
    
    $source = 'auto'; $target = $_POST['lang'] ?? 'eo'; $attempts = 5;
    $text = $_POST['text'] ?? null; $text_i = '';
    $flag = null; $result = '';
    
    if ($text) {

        $GTFF = new GoogleTranslateForFree();
        while (strlen($text) > 0) {
            $text_i = substr($text, 0, 3885);
                $text = substr($text, 3885);
            $tr = $GTFF->translate($source, $target, $text_i, $attempts);
            $result = $result.' '.$tr;
        }
        preg_replace('/\s+/', ' ', $result); //во избежание двойных пробелов
        $result = substr($result, 1); //убираем лишний пробел в начале
        echo($result); 
    }
    else echo("Empty request, there's nothing to translate.");
?>