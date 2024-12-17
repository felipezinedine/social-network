<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 100px;
            margin: 0;
            color: #ff4757;
        }

        p {
            font-size: 18px;
            margin: 10px 0 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #ff4757;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .button:hover {
            background: #e84142;
        }
    </style>

</head>

<body>

    <div class="container">
        <h1>404</h1>
        <p>Oops! Página solicitada não encontrada.</p>
        <a onclick="javascript:history.go(-1)" class="button">Voltar para o início</a>
    </div>
</body>

</html>