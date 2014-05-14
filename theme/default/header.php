<?php require_once($main->path_file.'function/include.php'); $username = $main->cookie->get('username'); ?>
<meta charset="[charset]">
[doctype]
<html lang="[lang]">
  <head>
    <title>[title]</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//code.jquery.com/jquery-1.11.0.min.js?1"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js?1"></script>
    <script src="<?php echo $main->path_url; ?>js/icheck.min.js?1"></script>
    <style>
      @import url("//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css?1");
      @import url("<?php echo $main->path_url; ?>css/bootflat.min.css?1");
    </style>
    <?php require($main->path_file.'css/content.php'); ?>
    [head]
  </head>
  
  <body>
    <header>
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0;">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $main->path_url; ?>"><?php echo SiteName; ?></a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php echo $systemui->menu->get(); ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main>
      <div class="container-fluid">
        <div class="rightback">
          <div class="contentback">
            <div class="leftback">
              <aside class="left">&nbsp;</aside>
              <article class="center">
                [content]