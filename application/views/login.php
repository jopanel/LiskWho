<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

 <div class="container">
    
      <form class="form-signin" action="<?=base_url()?>login" method="POST">
        <h2 class="form-signin-heading">Login</h2>
        <p><?php
            if ($error == 1) { echo "Too Many Login Attempts"; }
            if ($error == 2) { echo "Invalid Login Credentials."; }
        ?></p> 
        <input type="username" name="username" class="form-control" placeholder="Username" required autofocus> 
        <input type="password" name="password" class="form-control" placeholder="Password" required> 
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in">
      </form> 
    </div> <!-- /container -->
