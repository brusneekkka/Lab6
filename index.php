<?php 
    include_once 'auth_check.php';
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Головная часть-->
    <div class="border-bottom border-secondary rounded-bottom border-opacity-50 border-3 mx-1">
        <div class="row justify-content-end mt-2">
            <div class="col-1 mt-1" id="login"></div>
            <script>
                let login = document.querySelector('#login');
                login.innerHTML = "<?php echo($_COOKIE['login']) ?>";
            </script>
            <div class="col-1">
                <button class="btn btn-outline-danger mb-1" id="logout">Log out</button>
            </div>
            <script>
                let logout = document.querySelector('#logout');
                logout.addEventListener('click', () => {
                    fetch('http://localhost/Lab6/logout.php')
                    .then( () => {
                        window.location.href = 'http://localhost/Lab6/welcome.php';
                    })
                    .catch( err => {
                        console.log(err);
                    })
                });
            </script>
        </div>
    </div>
    <!-- Основная часть-->
    <div class="container-fluid mt-1">
            <div class="row justify-content-center">
                <div class="col-8">
                    <!-- Ввод текста -->
                    <textarea  rows="10" id="input" placeholder="Input your text here" 
                    class="form-control border border-secondary rounded-end border-opacity-25 border-3 mt-1 p-2"
                    ></textarea>
                    <!-- Таблица для обработки -->
                    <table class="table table bordered table-hover">
                        <tr>
                            <td>Characters in total:</td>
                            <td id="chars_t"></td>
                        </tr>
                        <tr>
                            <td>Characters without whitespaces:</td>
                            <td id="chars_nw"></td>
                        </tr>
                        <tr>
                            <td>Words:</td>
                            <td id="words"></td>
                        </tr>
                        <tr>
                            <td>Sentences:</td>
                            <td id="sentences"></td>
                        </tr>
                    </table>
                    <!-- Обработка -->
                    <script>
                        let input = document.querySelector('#input');
                        let input_prev = input.value;
                        let input_cur;
                        let chars_t; 
                        let chars_nw; 
                        let words;
                        let sentences;
                        
                        setInterval( () => {
                            input_cur = input.value;
                            if ( input_cur != input_prev) {
                                chars_t = input_cur.length;
                                chars_nw = (input_cur.match(/\S/g) ?? '').length; 
                                words = (input_cur.match(/\S+/g) ?? '').length;
                                sentences = (input_cur.match(/\w([.?!](\s|$)|$)/g) ?? '').length;
                                
                                document.querySelector('#chars_t').innerHTML = chars_t;
                                document.querySelector('#chars_nw').innerHTML = chars_nw;
                                document.querySelector('#words').innerHTML = words;
                                document.querySelector('#sentences').innerHTML = sentences;
                                input_prev = input_cur;
                            }
                        }, 1000);
                        
                    </script>
                        <!-- Интерфейс для переводов-->
                        <div>
                            <table>
                                <tr>
                                    <td>
                                        <button class="btn btn-outline-primary" id="translate_btn">Translate your text into:</button>
                                    </td>
                                    <td>
                                        <select class="form-select" id="lang" aria-label="Default select example">
                                            <option selected value="eo">Esperanto</option>
                                            <option value="ru">Russian</option>
                                            <option value="en">English</option>
                                            <option value="de">German</option>
                                            <option value="fr">French</option>
                                            <option value="es">Spanish</option>
                                            <option value="el">Greek</option>
                                            <option value="ar">Arabic</option>
                                        </select> 
                                    </td>
                                </tr>
                            </table>
                            <textarea class="form-control mt-2" id="translation" rows="10" placeholder="Translated text will be here" readonly></textarea>
                        </div>
                        <!-- Скрипт для перевода -->
                        <script>
                            let translate_btn = document.querySelector('#translate_btn');
                            let translation = document.querySelector('#translation');
                            let text;
                            let lang;
                            
                            translate_btn.addEventListener('click', () => {
                                text = input.value;
                                lang = document.querySelector('#lang').value;
                                
                                fetch("https://libretranslate.com/translate", {
                                    method: "POST",
                                    body: JSON.stringify({
                                        q: text,
                                        source: "auto",
                                        target: lang
                                    }),
                                    headers: { "Content-Type": "application/json" }
                                })
                                .then( resp => {
                                    if (resp.ok) {
                                        return resp.json();
                                    } else {
                                        throw new Error();
                                    }
                                })
                                .then( msg => {
                                    translation.value = msg['translatedText'];
                                })
                                .catch(() => {
                                    data = new FormData();
                                    data.append("lang", lang);
                                    data.append("text", input.value)
                                    
                                    fetch("http://localhost/Lab6/translate.php", { method: "POST", body: data })
                                    .then( resp => {
                                        return resp.text();
                                    })
                                    .then( msg => {
                                        console.log(msg);
                                        translation.value = msg;
                                    })
                                    .catch(() => {console.log('local translation error')})
                                });
                            });
                            
                        </script>
                </div>
            </div>
    </div>
</body>
</html>
