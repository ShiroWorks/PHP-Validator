<?php
require_once 'classes/Database.php';
require_once 'classes/ErrorHandler.php';
require_once 'classes/Validator.php';

$db= new Database;
$errorHandler = new ErrorHandler;

//var_dump($db->table('users')->exists(['username' => 'Shiro']));

if(!empty($_POST)){
    $validator = new Validator($db,$errorHandler);

    $validation = $validator->check($_POST, [

        'username' => [
            'required' => true,
            'maxlength' => 20,
            'minlength' => 3,
            'alnum' => true,
            'unique' => 'users'

        ],
        'email' => [
            'required' => true,
            'maxlength' => 255,
            'email' => true,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'minlength' => 6
        ],
        'password_again' => [
            'match' => 'password'
        ]

    ]);
    if($validation->fails()){
       echo '<pre>', print_r($validation->errors()->all()), '</pre>';
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Document</title>
</head>
<body>


<div class="container center-align">
<div class="row center-align">
    <form class="col s12 offset-m3" action="index.php" method="POST">
      <div class="row"> 
        <div class="input-field col s6">
          <input id="username" name="username" type="text" class="validate">
          <label for="username">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="password" name="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="password_again" name="password_again" type="password" class="validate">
          <label for="password_again">Repeat Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="email" type="email" name="email" class="validate">
          <label for="email">Email</label>
        </div> 
      </div>
      <div class="row">
        <div class="input-field col s6">
      <button class="btn waves-effect waves-light" type="submit" name="action">Submit
  </button>
  </div>
  </div>
      </div>
    </form>
  </div>
  </div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>