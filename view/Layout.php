<?php

namespace View;

class Layout {

  public function render($isLoggedIn, \View\Login $loginView, \View\Register $registerView, \View\DateTime $dateTimeView) {
    $renderHTML = '
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Login Example</title>
    </head>
    <body>
    <h1>Assignment 2</h1>'
    . $this->renderIsLoggedIn($isLoggedIn) . 
    '<div class="container">';

    if (isset($_GET["register"])) {
      $renderHTML .= '
      <a href="?">Back to login</a>
      <h2></h2>'
      . $registerView->response();
    } else {
      $renderHTML .= '
      <a href="?register">Register a new user</a>
      <h2></h2>'
      . $loginView->response();
    }

    $renderHTML .= 
    $dateTimeView->show() . 
    '</div>
    </body>
    </html>';

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
