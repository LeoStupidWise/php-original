<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign in</title>
</head>
<body>
    <form method="post" action="../signin.php">
        <table>
            <tr>
                <td> Nickname </td>
                <td> <input type="text" name="nickname"> </td>
            </tr>

            <tr>
                <td> Username </td>
                <td> <input type="text" name="username"> </td>
            </tr>

            <tr>
                <td> Password </td>
                <td> <input type="password" name="password"> </td>
            </tr>

            <tr>
                <td> Password Confirm </td>
                <td> <input type="password" name="password_confirm"> </td>
            </tr>

            <tr>
                <td> <input type="submit"> </td>
            </tr>
        </table>
    </form>
</body>
</html>