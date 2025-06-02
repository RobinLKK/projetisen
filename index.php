<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du projet</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('doué.jpg') no-repeat fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: white;
            text-shadow: 0 2px 5px rgba(0,0,0,0.7);
        }

        h1 {
            font-size: 3em;
            margin-bottom: 40px;
        }

        .btn {
            background: rgba(0, 123, 255, 0.85);
            padding: 18px 40px;
            margin: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1.4em;
            font-weight: bold;
            color: white;
            text-decoration: none;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: rgba(0, 90, 190, 0.95);
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body>
    <h1>Choisissez un projet</h1>
    <a class="btn" href="MSD/">Aller vers MSD</a>
    <a class="btn" href="Rob1/">Aller vers Rob1</a>
</body>
</html>
