<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rob1</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            background: #0f0f0f;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h1 {
            font-size: 4em;
            margin-bottom: 20px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px #00f2ff, 0 0 20px #00f2ff, 0 0 30px #00f2ff;
            }
            to {
                text-shadow: 0 0 20px #00f2ff, 0 0 30px #00f2ff, 0 0 40px #00f2ff;
            }
        }

        p {
            font-size: 1.2em;
            color: #aaa;
            margin-bottom: 40px;
        }

        a {
            padding: 12px 25px;
            background: rgba(0, 242, 255, 0.1);
            border: 1px solid #00f2ff;
            border-radius: 8px;
            color: #00f2ff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            background: #00f2ff;
            color: #000;
            box-shadow: 0 0 20px #00f2ff;
        }
    </style>
</head>
<body>
    <h1>Rob1</h1>
    <p>Site en cours de développement</p>
<a href="#" onclick="alert('Discord : rob1.lkk'); return false;">Discord</a>
</body>
</html>
