<?php

class input
{
  function newInput($type, $name, $label)
  {
    return '
    <div class="input-container">
      <input type="' . $type . '" name="' . $name . '" placeholder=" ">
      <label for="' . $name . '">' . $label . '</label>
    </div>
    ';
  }
}

class generalModal
{

  function modal($id, $title, $content, $buttonlabel)
  {
    $input = new input();
    return '
    <section class="section-form-container" id="' . $id . '-form">
      <div class="form-container" id="' . $id . '-container">
        <button class="close-form-button" onclick="Close' . $id . 'Modal()">
          <i class="bi bi-x"></i>
        </button>
        <form action="" class="form">
          <div class="form-header">
            <h2>' . $title . '</h2>
          </div>
          <div class="form-inputs">
            ' . $content . '
          </div>
          <div class="form-submit">
            <button type="submit">' . $buttonlabel . '</button>
          </div>
        </form>
      </div>
    </section>
    ';
  }
}

class modals
{

  function LoginModal()
  {
    $modal = new generalModal();
    $input = new input();

    $content =
      $input->newInput('text', 'username', 'Usuario')
      . $input->newInput('password', 'password', 'Contraseña');

    return $modal->modal('login', 'Iniciar Sesión', $content, 'Iniciar Sesión');
  }

  function RegisterModal()
  {
    $modal = new generalModal();
    $input = new input();

    $content =
      $input->newInput('text', 'username', 'Usuario')
      . $input->newInput('email', 'email', 'Email')
      . $input->newInput('password', 'password', 'Contraseña')
      . $input->newInput('password', 'password2', 'Repetir Contraseña');

    return $modal->modal('register', 'Registrarse', $content, 'Registrarse');
  }
}
