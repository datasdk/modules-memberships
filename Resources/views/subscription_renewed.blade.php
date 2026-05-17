<!DOCTYPE html>
<html>
<head>
    <title>Abonnement Fornyet</title>
</head>
<body>
    <h1>Tillykke!</h1>
    <p>Dit abonnement er nu blevet fornyet.</p>
    <p>Abonnement ID: {{ $subscription->id }}</p>
    <p>Gyldigt til: {{ $subscription->ends_at->format('d/m/Y') }}</p>
</body>
</html>
