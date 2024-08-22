<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de Compte Vendeur</title>
</head>
<body>
    <table>
        <tr>
            <td>Cher/Chère {{$name}},</td>
        </tr>
        <tr>
            <td>&nbsp;<br><br></td>
        </tr>
        <tr>
            <td>Nous avons le plaisir de vous informer que votre compte vendeur a été approuvé. Vous pouvez désormais vous connecter pour ajouter vos produits.</td>
        </tr>
        <tr>
            <td>&nbsp;<br><br></td>
        </tr>
        <tr>
            <td>Voici les détails de votre compte vendeur :</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td><strong>Nom :</strong> {{ $name }}</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td><strong>Téléphone :</strong> {{ $mobile }}</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td><strong>Adresse Email :</strong> {{ $email }}</td>
        </tr>
        <tr>
            <td>&nbsp;<br><br></td>
        </tr>
        <tr>
            <td>Merci pour votre inscription !</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td>Cordialement,</td>
        </tr>
        <tr>
            <td>Dokoba - le marché à portée de click !</td>
        </tr>
    </table>
</body>
</html>
