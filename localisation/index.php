<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Service de localisation GPS en temps réel - Solution de suivi professionnel">
    <title>Service de Localisation GPS - Suivi en Temps Réel</title>
    
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
            padding: 3rem 1rem;
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
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        header p {
            font-size: clamp(0.95rem, 3vw, 1.1rem);
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Navigation */
        nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 2rem 1rem;
            background: var(--bg-white);
            border-bottom: 1px solid var(--border);
        }

        nav a {
            text-decoration: none;
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            font-size: 0.95rem;
        }

        nav a:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }

        nav a:active {
            transform: translateY(0);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Cards */
        .card {
            background: var(--bg-white);
            padding: clamp(1.5rem, 4vw, 2.5rem);
            margin: 1.5rem auto;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            max-width: 100%;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .card h2 {
            color: var(--primary);
            font-size: clamp(1.3rem, 4vw, 1.8rem);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card p {
            color: var(--text-secondary);
            font-size: clamp(0.9rem, 2vw, 1rem);
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .card strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .feature-item {
            padding: 1.5rem;
            background: var(--bg-light);
            border-radius: 8px;
            border-left: 4px solid var(--secondary);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: var(--bg-white);
            box-shadow: var(--shadow);
        }

        .feature-item strong {
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        /* Profile Section */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .profile-item {
            background: var(--bg-light);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            border-top: 3px solid var(--primary);
        }

        .profile-item strong {
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .profile-item p {
            color: var(--text-secondary);
            margin: 0;
        }

        /* CTA Button */
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, var(--secondary) 0%, #00a86b 100%);
            color: white !important;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            font-size: 1rem;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 168, 107, 0.3);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 2rem 1rem;
            background: var(--primary);
            color: white;
            margin-top: 3rem;
            font-size: 0.95rem;
        }

        footer p {
            margin: 0;
            opacity: 0.9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .card {
                margin: 1rem auto;
                padding: 1.5rem;
            }

            nav {
                padding: 1.5rem 0.5rem;
                gap: 0.75rem;
            }

            nav a {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 2rem 1rem;
            }

            header h1 {
                font-size: 1.5rem;
                margin-bottom: 0.25rem;
            }

            header p {
                font-size: 0.9rem;
            }

            .card {
                padding: 1rem;
                margin: 0.75rem auto;
            }

            .card h2 {
                font-size: 1.3rem;
                margin-bottom: 0.75rem;
            }

            nav {
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            nav a {
                width: 100%;
                text-align: center;
                padding: 0.75rem;
            }

            .cta-button {
                width: 100%;
                text-align: center;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.6s ease-out;
        }

        /* Focus States for Accessibility */
        a:focus {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* Print Styles */
        @media print {
            header {
                background: var(--primary);
            }
            nav {
                display: none;
            }
            .card {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>🌍 Service de Localisation GPS</h1>
        <p>Solution précise de suivi et géolocalisation en temps réel</p>
    </header>

    <nav>
        <a href="#localisation">Localisation</a>
        <a href="#profil">Profil</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="container">
        <!-- À propos -->
        <section class="card">
            <h2>À Propos du Service</h2>
            <p>
                Ce service permet de collecter et d'afficher la localisation précise d'un appareil en temps réel grâce aux technologies GPS et à l'intégration d'OpenStreetMap. Il repose sur une application Android installée sur l'appareil à localiser. Cette application récupère automatiquement les coordonnées géographiques (latitude et longitude) et les transmet vers un serveur sécurisé à intervalles réguliers.
            </p>
            <p>
                Les données sont ensuite traitées et affichées sur une interface web interactive sous forme de carte, permettant de visualiser la position actuelle ainsi que les déplacements de l'appareil en temps réel.
            </p>

            <div class="features">
                <div class="feature-item">
                    <strong>Haute Précision</strong>
                    <p>Suivi GPS précis avec mise à jour en temps réel</p>
                </div>
                <div class="feature-item">
                    <strong>Interface Intuitive</strong>
                    <p>Visualisation claire sur carte interactive</p>
                </div>
                <div class="feature-item">
                    <strong>Sécurisé</strong>
                    <p>Respect de la confidentialité et consentement des utilisateurs</p>
                </div>
                <div class="feature-item">
                    <strong>Flexible</strong>
                    <p>Suivi de livraisons, flottes, équipements et plus</p>
                </div>
            </div>

            <p style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <strong>Cas d'usage :</strong> Suivi de livraisons, gestion de flottes de véhicules, localisation d'équipements, amélioration de la sécurité et suivi des personnes.
            </p>
        </section>

        <!-- Localisation -->
        <section class="card" id="localisation">
            <h2>Localisation</h2>
            <p>Accédez à la position actuelle et consultez l'historique des déplacements en temps réel.</p>
            <a href="permession.php" class="cta-button">➡️ Afficher la Localisation</a>
        </section>

        <!-- Profil -->
        <section class="card" id="profil">
            <h2>👤 Profil du Développeur</h2>
            <div class="profile-grid">
                <div class="profile-item">
                    <strong>Nom</strong>
                    <p>Ait Hmad Oussama</p>
                </div>
                <div class="profile-item">
                    <strong>Spécialité</strong>
                    <p>Développement Web & Systèmes Embarqués</p>
                </div>
                <div class="profile-item">
                    <strong>Projet</strong>
                    <p>Système GPS Temps Réel</p>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section class="card" id="contact">
            <h2>📧 Nous Contacter</h2>
            <p>Pour toute question ou demande d'information sur notre service de localisation GPS, n'hésitez pas à nous contacter.</p>
            
            <div class="features" style="margin-top: 2rem;">
                <div class="feature-item">
                    <strong>📱 Téléphone</strong>
                    <p><a href="tel:0704803660" style="color: var(--primary); text-decoration: none; font-weight: 600;">0704803660</a></p>
                </div>
                <div class="feature-item">
                    <strong>✉️ Email</strong>
                    <p><a href="mailto:aithmadoussama458@gmail.com" style="color: var(--primary); text-decoration: none; font-weight: 600;">aithmadoussama458@gmail.com</a></p>
                </div>
            </div>

            <p style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); color: var(--text-secondary);">
                Nous nous engageons à vous répondre dans les meilleurs délais. Votre confidentialité est notre priorité.
            </p>
        </section>
    </div>

    <footer>
        <p>© 2026 - Ait Hmad Oussama | Service de Localisation GPS</p>
    </footer>
</body>

</html>
