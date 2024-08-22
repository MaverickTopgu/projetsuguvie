<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mot de passe oulbié ?</title>
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
            <td>Ci-dessous un nouveau mot de passe généré par DôkôBa pour vous connectez à votre Compte :-: DôkôBa vous recommande de changer de mot de passe afin d'en choisir un qui vous convient.</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td>Email : {{ $email }}</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td>Mot de Passe : {{ $password }}</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
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