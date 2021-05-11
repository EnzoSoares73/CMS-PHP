<html lang="pt-br">
    <head>
        
        <title>Login</title>
        <?php require 'headtag.html';?>

        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <form onsubmit="" class="box" method='post'>
                            <h1>Login</h1>
                            <p class="text-muted"> Inisra seu usuário e senha</p>
                            <input type="text" name="user" placeholder="Usuário">
                            <input type="password" name="password" placeholder="Senha">
                            <input type="submit" name="submit" value="Login" href="#">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>

