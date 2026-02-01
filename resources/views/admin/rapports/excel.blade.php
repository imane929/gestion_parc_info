<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport {{ ucfirst($type) }} - {{ date('d/m/Y') }}</title>
</head>
<body>
    <h1>Rapport {{ ucfirst($type) }}</h1>
    <p>Gestion Parc Informatique • {{ $date }}</p>
    <p>Période: {{ $periode === 'today' ? 'Aujourd\'hui' : ($periode === 'week' ? 'Cette semaine' : ($periode === 'month' ? 'Ce mois' : ($periode === 'year' ? 'Cette année' : 'Toutes périodes'))) }}</p>
</body>
</html>