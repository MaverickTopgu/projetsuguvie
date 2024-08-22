<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Activation Compte</title>
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
            <td>Bienvenue à DôkôBa ! Veuillez cliquer sur le lien ci-dessous afin d'<strong>activer</strong> votre Compte DôkôBa :-:</td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td><a href="{{ url('/user/confirm/'.$code) }}">activer mon compte</a></td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td>Merci pour l'activation de votre compte !</td>
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