<?php

namespace View;

class Layout {

  public function render(bool $isLoggedIn, \View\Login $loginView, \View\DateTime $dateTimeView) {
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

    if (!$isLoggedIn) {
      $renderHTML .= '<p><a href="?register">Register a new user</a></p>';
    }

    $renderHTML .= $loginView->response($isLoggedIn);

    $renderHTML .= 
    $dateTimeView->show() . 
    '</div>
    </body>
    </html>';

    echo $renderHTML;
  }
  
  private function renderIsLoggedIn(bool $isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
