<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Compte</title>
</head>
<body>
<table>
        <tr>
            <td>Cher/Chère {{$name}},</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td>Bienvenue à DôkôBa ! Votre compte a été crée avec succès avec les informations ci-dessous:</td>
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
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td><strong>Mot de passe:</strong> ******** (tel que vous l'avez choisi)</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td>Merci pour la création de votre compte !</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
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