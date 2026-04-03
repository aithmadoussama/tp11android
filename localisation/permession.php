<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Vérification du code pour accès à la localisation GPS">
    <title>Vérification d'Accès - Service de Localisation GPS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0066cc;
            --primary-dark: #0052a3;
            --secondary: #00a86b;
            --accent: #ff6b35;
            --bg-light: #f8fafb;
            --bg-white: #ffffff;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --border: #e0e0e0;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --success: #00a86b;
            --error: #e74c3c;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            color: var(--text-primary);
            background: var(--bg-light);
            line-height: 1.6;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        header h1 {
            font-size: clamp(1.5rem, 5vw, 2rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        header p {
            font-size: clamp(0.9rem, 3vw, 1rem);
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        /* Container */
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem 1rem;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Card */
        .card {
            background: var(--bg-white);
            padding: clamp(1.5rem, 4vw, 2.5rem);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            width: 100%;
        }

        .card h2 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            text-align: center;
            line-height: 1.8;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: var(--bg-white);
            color: var(--text-primary);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .form-group input::placeholder {
            color: var(--text-secondary);
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--secondary) 0%, #00a86b 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 168, 107, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Messages */
        .message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            animation: slideDown 0.3s ease-out;
        }

        .message.error {
            background: #fce8e8;
            border-left: 4px solid var(--error);
            color: #c0392b;
        }

        .message.success {
            background: #e8f5e9;
            border-left: 4px solid var(--success);
            color: #27ae60;
        }

        .message.info {
            background: #e3f2fd;
            border-left: 4px solid var(--primary);
            color: #0052a3;
        }

        /* Back Link */
        .back-link {
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 1.5rem;
            background: var(--primary);
            color: white;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0;
            opacity: 0.9;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                padding: 1.5rem 1rem;
            }

            header h1 {
                font-size: 1.3rem;
            }

            .container {
                padding: 1rem;
            }

            .card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 1rem;
            }

            header h1 {
                font-size: 1.1rem;
            }

            header p {
                font-size: 0.85rem;
            }

            .card {
                padding: 1rem;
                box-shadow: var(--shadow);
            }

            .card h2 {
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }

            .card p {
                font-size: 0.9rem;
            }

            .btn-submit {
                padding: 0.85rem;
                font-size: 0.95rem;
            }
        }

        /* Focus States */
        button:focus,
        a:focus {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }
    </style>
</head>

<body>
    <header>
        <h1>🔐 Vérification d'Accès</h1>
        <p>Service de Localisation GPS - Accès Sécurisé</p>
    </header>

    <div class="container">
        <div class="card">
            <h2>🔑 Entrer le Code d'Accès</h2>

            <p>Veuillez entrer le code généré par l'application Android pour autoriser l'accès et consulter la localisation en temps réel.</p>

            <form method="POST">
                <div class="form-group">
                    <label for="code">Code de Vérification</label>
                    <input
                        type="text"
                        id="code"
                        name="code"
                        placeholder="Entrez le code reçu"
                        required
                        autocomplete="off"
                        maxlength="20">
                </div>
                <button type="submit" class="btn-submit">✓ Valider et Accéder</button>
            </form>

            <?php
            // Gestion de la soumission du formulaire
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $code = trim($_POST['code'] ?? '');

                // Validation basique
                if (empty($code)) {
                    echo "<div class='message error'>❌ Le code est requis</div>";
                } else {
                    try {
                        // Connexion à la base de données
                        $conn = new PDO(
                            "mysql:host=127.0.0.1;dbname=localisation",
                            "root",
                            "",
                            [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                            ]
                        );

                        $sql = "SELECT code FROM position WHERE code = :code LIMIT 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['code' => $code]);

                        if ($stmt->fetch()) {
                            echo "<div class='message success'>✓ Code valide ! Redirection en cours...</div>";
                            echo "<script>
                                    setTimeout(function(){
                                        window.location.href = 'localisation.php?code=" . urlencode($code) . "';
                                    }, 2000);
                                 </script>";
                            exit();
                        }

                        $conn = null;
                    } catch (PDOException $e) {
                        echo "<div class='message error'>❌ Erreur de connexion à la base de données</div>";
                    }
                }
            }
            ?>

            <div class="back-link">
                <a href="index.php">← Retour à l'accueil</a>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2026 - Ait Hmad Oussama | Service de Localisation GPS - Tous droits réservés</p>
    </footer>
</body>

</html>