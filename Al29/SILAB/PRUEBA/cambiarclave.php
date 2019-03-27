<?php
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cambio de clave SILAB</title>
  <meta charset="utf-8">
  <meta autor="Raul">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    
    <div id="form-signin" class="">

      <form class="" method="POST" action="cambiarclave2.php">
        <h2 class="">cambiar clave SILAB</h2>
        <label for="inputficha" class="">Ficha</label>
        <input id="inputficha" class="" name= "inputficha" placeholder="Ficha" required=""  type="text">
        <label for="inputPassword" class="">Contrasena vieja</label>
        <input name="inputPassword" class="" placeholder="Password" required="" type="password">
        <label for="inputPassword2" class="">Contrasena nueva</label>
        <input name="inputPassword2" class="" placeholder="Password nuevo" required="" type="password">
        <button class="" type="submit">cambiar clave</button>
      </form>

    </div>

</body>
</html>