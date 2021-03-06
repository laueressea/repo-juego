<?php

require_once("clases/DbMySql.php");
require_once("clases/validator.php");
require_once("clases/auth.php");

$auth = new Auth;
$dbMysql = new DbMySql;

if ($auth->usuarioLogueado()) {
  $user = $auth->usuarioLogueado();
  $usuario = $dbMysql->buscarPorEmail($_SESSION["email"]);
}

// REGISTRO //

if ($_POST && isset($_POST["register"])) {

  $errores = Validator::validarRegistro($_POST);
  $nameOk = $_POST["name"];
  $lastnameOk = $_POST["lastname"];
  $emailOk = $_POST["email"];


  if (empty($errores)) {
    if (!$dbMysql->existeUsuario($_POST["email"])) {

      $usuario = new Usuario($_POST);      //armarUsuario($_POST);   //crear usuario//
      $dbMysql->guardarUsuario($usuario);  //guardar usuario//
      header("Location:bienvenida.php");
      exit;
    }
  }
}

// LOGIN //


if ($_POST && isset($_POST["login"])) {
  $erroresLogin = Validator::validarLogin($_POST);


  //Si no hay errores
  if (empty($erroresLogin)) {

    $auth->loguearUsuario($_POST["email"]);
    //redirigimos a home
    header("Location:index.php#descripcion");
    exit;
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <?php
  include 'partials/navbar.php';
  ?>
  <main class="content" id="home">
    <section class="presentacion">
      <h1 class="presentacion__title"> <img class="contrareloj" src="img/logo-blanco.png" alt="contrareloj"></h1>

      <a href="#descripcion" class="presentacion__arrow-down grow point"><i class="fas fa-chevron-circle-down fa-4x"></i></a>
    </section>

    <section class="descripcion" id="descripcion">
      <div class="descripcion__text">
        <p class="descripcion__text__p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras viverra velit
          a
          libero semper lacinia. Curabitur congue massa nisi, et tincidunt libero vulputate a. Vestibulum in cursus
          neque,
          pulvinar cursus nibh. Quisque vitae ex porta nisi posuere aliquet. Duis blandit auctor tortor eu congue.
          Aenean
          facilisis varius tincidunt. Curabitur semper mollis volutpat. Integer erat elit, suscipit et ultrices cursus,
          pulvinar sit amet nibh. Fusce facilisis non est eu aliquam. Nunc ligula libero, sodales eu est in,
          pellentesque
          sodales arcu. Curabitur cursus ullamcorper odio et lacinia.</p>
        <p class="descripcion__text__p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras viverra velit
          a
          libero semper lacinia. Curabitur congue massa nisi, et tincidunt libero vulputate a. Vestibulum in cursus
          neque,
          pulvinar cursus nibh. Quisque vitae ex porta nisi posuere aliquet. Duis blandit auctor tortor eu congue.
          Aenean
          facilisis varius tincidunt. Curabitur semper mollis volutpat. Integer erat elit, suscipit et ultrices cursus,
          pulvinar sit amet nibh. Fusce facilisis non est eu aliquam. Nunc ligula libero, sodales eu est in,
          pellentesque
          sodales arcu. Curabitur cursus ullamcorper odio et lacinia.</p>
      </div>
      <?php if ($auth->usuarioLogueado()) : ?>
        <a class="btn descripcion__start-btn" href="preguntas.php"><span>¡Estoy listo!</span></a>
      <?php else : ?>
        <a class="btn descripcion__start-btn" href="#login"><span>¡Estoy listo!</span></a>
      <?php endif; ?>
      <?php if (!$auth->usuarioLogueado()) : ?><a class="btn descripcion__start-btn" href="#register"><span>¡Soy nuevo!</span></a><?php endif; ?>
    </section>
    <?php if (!$auth->usuarioLogueado()) : ?>
      <section class="login-section" id="login">
        <form class="form" action="index.php#login" method="POST">
          <h1 class="form__title">Login</h1>
          <div class="form__group">
            <label class="form__group__text-label" for="email">Email:</label>
            <input class="form__group__text-field" type="email" name="email" id="email" placeholder="Ingrese su correo electronico" required>
          </div>
          <?php if (!empty($erroresLogin["email"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $erroresLogin["email"]; ?>
            </div>
          <?php } ?>

          <div class="form__group">
            <label class="form__group__text-label" for="pwd">Contraseña:</label>
            <input class="form__group__text-field" type="password" name="pwd" id="pwd" placeholder="Password">
          </div>
          <?php if (!empty($erroresLogin["pwd"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $erroresLogin["pwd"]; ?>
            </div>
          <?php } ?>
          <!--           <div class="form__group form-check">
                <input type="checkbox" class="form-check__input" name="recordar" id="recordar" value="yes">
                <label class="form-check__label" for="recordar">Recordame</label>
                <span class="form-check__fp"><a class="form-check__fp__link" href="forgetpassword.html">¿Olvido su
                contraseña?</a></span>
                </div> -->
          <!-- <p class="form__error-msg">La combinación ingresada de email y contraseña no es válida</p> -->

          <button type="submit" class="form__btn submit" name="login" value="ingresar">Login</button>

          <p class="form__not-registered">¿No tenés cuenta?<a class="form__not-registered__link" href="#register">Registrate</a></p>
          <input type="hidden" name="login" value="">
        </form>
      </section>
    <?php endif; ?>

    <?php if (!$auth->usuarioLogueado()) : ?>
      <section class="register-section" id="register">
        <form class="form" action="index.php#register" method="post">
          <h1 class="form__title">Registrate</h1>
          <div class="form__group">
            <label class="form__group__text-label" for="name">Nombre</label>
            <input id="name" class="form__group__text-field" name="name" type="text" value="" <?php if (isset($nameOk) && empty($errores["name"])) {
                                                                                                echo $nameOk;
                                                                                              } ?> placeholder="Ingresá tu nombre">
          </div>
          <?php if (!empty($errores["name"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $errores["name"]; ?>
            </div>
          <?php } ?>
          <div class="form__group">
            <label class="form__group__text-label" for="lastname">Apellido</label>
            <input id="lastname" class="form__group__text-field" name="lastname" type="text" value="" <?php if (isset($lastnameOk) && empty($errores["lastname"])) {
                                                                                                        echo $lastnameOk;
                                                                                                      } ?> placeholder="Ingresá tu apellido">
          </div>
          <?php if (!empty($errores["lastname"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $errores["lastname"]; ?>
            </div>
          <?php } ?>
          <div class="form__group">
            <label class="form__group__text-label" for="email">Email</label>
            <input id="email" class="form__group__text-field" name="email" type="email" value="
                    <?php if (isset($emailOk) && empty($errores["email"])) {
                      echo $emailOk;
                    } ?>" placeholder="Ingresá tu email">
          </div>
          <?php if (!empty($errores["email"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $errores["email"]; ?>
            </div>
          <?php } ?>
          <div class="form__group">
            <label class="form__group__text-label" for="pwd">Contraseña</label>
            <input id="pwd" class="form__group__text-field" name="pwd" type="password" placeholder="Password">
          </div>
          <div class="form__group">
            <label class="form__group__text-label" for="retypepwd">Repite Contraseña</label>
            <input id="retypepwd" class="form__group__text-field" name="retypepwd" type="password" placeholder="Password">
          </div>
          <?php if (!empty($errores["pwd"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $errores["pwd"]; ?>
            </div>
          <?php } ?>
          <div class="form__group form-check">
            <input id="accepted" name="accepted" class="form-check__input" type="checkbox" value="yes">
            <label class="form-check__label" for="accept">Acepto los términos y condiciones</label>
          </div>
          <?php if (!empty($errores["accepted"])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $errores["accepted"]; ?>
            </div>
          <?php } ?>
          <button class="form__btn" type="submit" name="register">Registrarme</button>
          <!-- <button class="form__btn form__btn--reset" type="reset" name="">Cancelar</button> -->
          <input type="hidden" name="register" value="">
        </form>
      </section>
    <?php endif; ?>
  </main>
  <script src="js/app.js"></script>
</body>

</html>