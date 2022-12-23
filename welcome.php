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
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="text-center fs-1 fw-bold"> Welcome! </div>
                <div id="flag_text" class="">Lorem ipsum</div>
                <form>
                    <div class="mb-3">
                        <label for="input_login" class="form-label">Login</label>
                        <input type="text" name="login" class="form-control" id="input_login">
                    </div>
                    <div class="mb-3">
                        <label for="input_password" class="form-label">Password</label>
                        <input type="password" name="pass" class="form-control" id="input_password">
                    </div>
                    <button type="button" id="btn_signup" class="btn btn-secondary">Sign up</button>
                    <button type="button" id="btn_login" class="btn btn-primary">Log in</button>
                </form>
                <script>
                    
                    let flag = 0;
                    let flag_text = document.querySelector('#flag_text')
                    if (flag == 0) {
                        flag_text.innerHTML = '';
                    }
                    
                    let form = document.querySelector('form');
                    
                    let signup = document.querySelector('#btn_signup');
                    signup.addEventListener('click', () => {
                        fetch('http://localhost/Lab6/signup.php',  {method: 'POST', body: new FormData(form) })
                        .then( resp => {
                            return resp.text();
                        })
                        .then( msg => {
                            flag = msg;
                            if (flag>0) {
                                    flag_text.setAttribute('class', 'text-center fs-4 fw-bold text-danger');
                                    switch(flag) {
                                        case "1":
                                            flag_text.innerHTML = "Incorrect login or password";
                                        break;
                                        case "2":
                                            flag_text.innerHTML = "This login is already taken";
                                        break;
                                        case "3":
                                            flag_text.innerHTML = "Password must be longer than 5 letters.</br>It also must include at least one latin letter and at least one number";
                                        break;
                                        default:
                                        break;
                                    }
                            } else if (flag == -1) {
                                flag_text.setAttribute('class', 'text-center fs-4 fw-bold text-success');
                                switch(flag) {
                                    case "-1":
                                    flag_text.innerHTML =  "Successfull signup";
                                    break;
                                    default:
                                    break;
                                }
                            }
                            console.log(flag);
                        });
                    });
                    
                    let login = document.querySelector('#btn_login');
                    login.addEventListener('click', () => {
                       fetch('http://localhost/Lab6/login.php', {method: 'POST', body: new FormData(form) })
                       .then( resp => {
                            return resp.text();
                        })
                        .then( msg => {
                            flag = msg;
                            console.log(flag);
                            if(flag == 1) {
                                flag_text.setAttribute('class', 'text-center fs-4 fw-bold text-danger');
                                flag_text.innerHTML = "Incorrect login or password";
                            }
                            else if (flag == -1) {
                                window.location.href = 'http://localhost/Lab6/index.php';
                            }
                        }) 
                    });
                    
                </script>
            </div>
        </div>
    </div>        
</body>
</html>
