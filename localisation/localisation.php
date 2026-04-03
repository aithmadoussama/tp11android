<?php
$code = $_GET['code'] ?? '';

// Validation du code
if (empty($code)) {
    header("Location: permission.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Suivi en temps réel de la localisation GPS">
    <title>Localisation en Temps Réel - Service de Localisation GPS</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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

        /* Main Content */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Map Container */
        .map-container {
            background: var(--bg-white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        #map {
            height: 600px;
            width: 100%;
            z-index: 1;
        }

        /* Info Panel */
        .info-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: var(--bg-white);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
        }

        .info-card h3 {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .info-card p {
            color: var(--text-primary);
            font-size: 1.25rem;
            font-weight: 600;
        }

        .info-card .status {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--success);
            animation: pulse 2s infinite;
            margin-right: 0.5rem;
            vertical-align: middle;
        }

        .info-card .status.offline {
            background: var(--error);
            animation: none;
        }

        /* Status Bar */
        .status-bar {
            background: var(--bg-white);
            padding: 1rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .status-bar p {
            margin: 0;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .status-bar .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Controls */
        .controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 102, 204, 0.3);
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 2rem;
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

        /* Message */
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

        .message.info {
            background: #e3f2fd;
            border-left: 4px solid var(--primary);
            color: #0052a3;
        }

        /* Loading */
        .loading {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--border);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
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
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

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
            main {
                padding: 1rem;
            }

            #map {
                height: 400px;
            }

            .info-panel {
                grid-template-columns: 1fr;
            }

            .controls {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .status-bar {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 1rem;
            }

            header h1 {
                font-size: 1.3rem;
            }

            header p {
                font-size: 0.85rem;
            }

            #map {
                height: 300px;
            }

            .info-card {
                padding: 1rem;
            }

            .info-card h3 {
                font-size: 0.75rem;
            }

            .info-card p {
                font-size: 1rem;
            }
        }

        /* Focus States */
        button:focus,
        a:focus {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* Leaflet Customization */
        .leaflet-control-attribution {
            background: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
        }

        .leaflet-marker-icon {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }
    </style>
</head>

<body>
    <header>
        <h1>📍 Suivi en Temps Réel</h1>
        <p>Service de Localisation GPS - Localisation Actualisée</p>
    </header>

    <main>
        <div class="message info">
            ℹ️ Les coordonnées sont mises à jour toutes les 5 secondes
        </div>

        <div class="status-bar">
            <p>État de la connexion :</p>
            <div class="status-indicator">
                <span class="status" id="statusLight"></span>
                <span id="statusText">Connexion en cours...</span>
            </div>
        </div>

        <div class="info-panel">
            <div class="info-card">
                <h3>Latitude</h3>
                <p id="latitude">--</p>
            </div>
            <div class="info-card">
                <h3>Longitude</h3>
                <p id="longitude">--</p>
            </div>
            <div class="info-card">
                <h3>Dernière Mise à Jour</h3>
                <p id="lastUpdate">--</p>
            </div>
            <div class="info-card">
                <h3>Nombre de Points</h3>
                <p id="pointCount">0</p>
            </div>
        </div>

        <div class="map-container">
            <div id="map"></div>
        </div>

        <div class="controls">
            <button class="btn btn-primary" onclick="centerMap()">🎯 Centrer sur la Position</button>
            <button class="btn btn-primary" onclick="clearTrail()">🗑️ Effacer l'Historique</button>
            <button class="btn btn-secondary" onclick="exportData()">💾 Exporter les Données</button>
        </div>

        <div class="back-link">
            <a href="permession.php">← Revenir à la Vérification</a>
        </div>
    </main>

    <footer>
        <p>© 2026 - Ait Hmad Oussama | Service de Localisation GPS - Tous droits réservés</p>
    </footer>

    <script>
        const code = "<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>";
        let map = null;
        let marker = null;
        let polyline = null;
        let pointCount = 0;
        let updateInterval = null;

        // Initialisation de la carte
        function initMap() {
            map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            polyline = L.polyline([], {
                color: '#0066cc',
                weight: 3,
                opacity: 0.7,
                smoothFactor: 1
            }).addTo(map);
        }

        // Mise à jour de la position
        function updatePosition() {
            if (!code) {
                updateStatus('Erreur: Code manquant', false);
                return;
            }

            fetch("getPosition.php?code=" + encodeURIComponent(code))
                .then(res => res.json())
                .then(data => {
                    if (!data || !data.latitude || !data.longitude) {
                        updateStatus('En attente de données...', false);
                        return;
                    }

                    const lat = parseFloat(data.latitude);
                    const lon = parseFloat(data.longitude);

                    // Validation des coordonnées
                    if (isNaN(lat) || isNaN(lon)) {
                        updateStatus('Données invalides', false);
                        return;
                    }

                    // Mise à jour du polyline
                    polyline.addLatLng([lat, lon]);
                    pointCount++;

                    // Mise à jour du marqueur
                    if (!marker) {
                        marker = L.circleMarker([lat, lon], {
                                radius: 8,
                                fillColor: '#00a86b',
                                color: '#00a86b',
                                weight: 2,
                                opacity: 1,
                                fillOpacity: 0.8
                            }).addTo(map)
                            .bindPopup(`Position actuelle<br/>Latitude: ${lat.toFixed(6)}<br/>Longitude: ${lon.toFixed(6)}`);
                    } else {
                        marker.setLatLng([lat, lon]);
                    }

                    // Centrage de la carte
                    map.setView([lat, lon], 16);

                    // Mise à jour des informations
                    document.getElementById('latitude').textContent = lat.toFixed(6);
                    document.getElementById('longitude').textContent = lon.toFixed(6);
                    document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString('fr-FR');
                    document.getElementById('pointCount').textContent = pointCount;

                    updateStatus('Connecté', true);
                })
                .catch(err => {
                    console.error('Erreur:', err);
                    updateStatus('Erreur de connexion', false);
                });
        }

        // Mise à jour du statut
        function updateStatus(text, isOnline) {
            document.getElementById('statusText').textContent = text;
            const light = document.getElementById('statusLight');
            if (isOnline) {
                light.classList.remove('offline');
            } else {
                light.classList.add('offline');
            }
        }

        // Centrer la carte sur le marqueur
        function centerMap() {
            if (marker) {
                map.setView(marker.getLatLng(), 16);
            }
        }

        // Effacer l'historique
        function clearTrail() {
            if (confirm('Êtes-vous sûr de vouloir effacer l\'historique des positions ?')) {
                polyline.setLatLngs([]);
                pointCount = 0;
                document.getElementById('pointCount').textContent = '0';
            }
        }

        // Exporter les données
        function exportData() {
            const latlngs = polyline.getLatLngs();
            const csv = 'latitude,longitude,time\n' +
                latlngs.map((latLng, idx) => `${latLng.lat},${latLng.lng},Position ${idx + 1}`).join('\n');

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `positions_${new Date().getTime()}.csv`;
            a.click();
            window.URL.revokeObjectURL(url);
        }

        // Initialisation au chargement
        document.addEventListener('DOMContentLoaded', () => {
            initMap();
            updatePosition();
            updateInterval = setInterval(updatePosition, 5000);
        });

        // Nettoyage au déchargement
        window.addEventListener('beforeunload', () => {
            if (updateInterval) {
                clearInterval(updateInterval);
            }
        });
    </script>
</body>

</html>