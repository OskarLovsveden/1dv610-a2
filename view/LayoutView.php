<?php

class LayoutView {

  public function render($isLoggedIn, LoginView $loginView, RegisterView $registerView, DateTimeView $dtv) {
    $renderHTML = '
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Login Example</title>
    </head>
    <body>
    <h1>Assignment 2</h1>';

    if (isset($_GET["register"])) {
      $renderHTML .= '<a href="?">Back to login</a>
      ' . $this->renderIsLoggedIn($isLoggedIn) . '

      <div class="container">
      <h2>Register new user</h2>
      ' . $registerView->response() . '
      ' . $dtv->show() . '
      </div>';
    } else {
      $renderHTML .= '<a href="?register">Register a new user</a>
      ' . $this->renderIsLoggedIn($isLoggedIn) . '

      <div class="container">
      ' . $loginView->response() . '
      ' . $dtv->show() . '
      </div>';
    }

    $renderHTML .= '</body></html>';

    echo $renderHTML;
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
