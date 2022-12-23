<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <title>Welcome!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </head>

</head>
<body>
    <?php
        require_once ('vendor/autoload.php');
        use \Dejurin\GoogleTranslateForFree;
        
        $source = 'auto';
        $target = 'el';
        $attempts = 5;
        $text = 'Hello';

        $tr = new GoogleTranslateForFree();
        $result = $tr->translate($source, $target, $text, $attempts);

        var_dump($result); 
    ?>
</body>
</html>