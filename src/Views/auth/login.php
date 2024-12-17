<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INC_PATH_VIEW ?>assets/css/auth/style.css">
</head>

<body>

    <div class="sidebar">

    </div>

    <div class="form-container">
        <div class="logo-call-login">
            <h2>rede.social</h2>
            <p>Conecte-se com o seus amigos e expanda o seus conhecimentos</p>
        </div>

        <div class="form-login">
            <form method="post">
                <input type="email" name="email" placeholder="Usuário:">
                <input type="password" name="password" placeholder="Senha:">
                <input type="hidden" name="login" value="login">
                <button type="submit" name="action">Logar!</button>
            </form>
            <p><a href="auth">Criar Conta</a></p>
        </div>
    </div>
</body>
</html>