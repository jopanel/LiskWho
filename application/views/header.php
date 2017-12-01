<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lisk Who promotes Lisk growth by allowing community to review, discuss, and add information for delgates.">
    <meta name="author" content="Lenapo Solutions LLC">
    <meta name="keywords" content="Lisk, LiskWho, Lisk.io, Delegates, 101 Delegates, Cryptocurrency, Bitcoin, Altcoin, Lenapo Solutions">
    <link rel="icon" href="../../favicon.ico">

    <title>Lisk Who - Delegate Discussion, Reviews, and Descriptions</title> 

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>resources/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>resources/css/main.css" rel="stylesheet"> 
    <!-- Plugin CSS -->
    <link href="<?=base_url()?>resources/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"> 

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110085901-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-110085901-1');
    </script>

  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#liskwhoNavBar" aria-controls="liskwhoNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url()?>">Lisk Who</a>

      <div class="collapse navbar-collapse" id="liskwhoNavBar">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?=base_url()?>">Home</a>
          </li> 
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lisk FAQ</a>
            <div class="dropdown-menu" aria-labelledby="dropdown02">
              <a class="dropdown-item" href="<?=base_url()?>#whats-a-delegate">Whats A Delegate?</a>
              <a class="dropdown-item" href="<?=base_url()?>#how-to-vote">How Do I Vote?</a>
              <a class="dropdown-item" href="<?=base_url()?>#what-is-forging">What Is Forging?</a> 
              <a class="dropdown-item" href="<?=base_url()?>#definitions">Definitions</a>
            </div>
          </li>  
          <li style="display:none;" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Delegates Panel</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">Verify Account</a>
              <a class="dropdown-item" href="#">Login</a>
            </div>
          </li> 
          <li class="nav-item" style="display:none;">
            <a class="nav-link" href="https://encryptmywallet.com">Encrypt My Wallet</a>
          </li> 
        </ul> 
      </div>
    </nav>
