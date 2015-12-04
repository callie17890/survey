<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Login to Account</h1>
    <form action="login-user.php" method="POST">
      <table>
        <tr>
          <td>Email:</td>
          <td><input name="email" type="text" /></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input name="password" type="text" /></td>
        </tr>
        <tr>
          <td>
            <br>
            <button type="submit">Submit</button>
          </td>
        </tr>
      </table>
    </form>

    <h1>Create Account</h1>
    <form method="POST" action="create-user.php">
      <table>
        <tr>
          <td>Name:</td>
          <td><input name="name" type="text"/></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input name="email" type="text" /></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input name="password" type="text" /></td>
        </tr>
        <tr>
          <td>
            <br>
            <button type="submit">Submit</button>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>