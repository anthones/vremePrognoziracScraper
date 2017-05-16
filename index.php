<?php
  $setiranGrad = "";
  function grad(){
    $setiranGrad = "";
    if (isset($_GET['grad'])) {
      $setiranGrad = $_GET['grad'];
    }
    return ucfirst($setiranGrad);
  }

  if(grad()) {
      $stranicaPrognoza = file_get_contents(
          "http://weather4all.com.mk/vremenska-prognoza/".grad());
      if(strpos($stranicaPrognoza, '<div id="city">') !== false) {
          $prvOpsegOpis = explode('<span id="weather_desc">', $stranicaPrognoza);
          $vtorOpsegOpis = explode('</span>', $prvOpsegOpis[1]);

          $prvOpsegTemperatura = explode('<div> Се чувствува: ', $stranicaPrognoza);
          $vtorOpsegTemperatura = explode('</div>', $prvOpsegTemperatura[1]);

          $prvOpsegGradKirilica = explode('<span id="name">', $stranicaPrognoza);
          $vtorOpsegGradKirilica = explode('</span>', $prvOpsegGradKirilica[1]);

          $celosenPrikaz = 'Се чини дека времето во ' . $vtorOpsegGradKirilica[0] . ' e ' . lcfirst($vtorOpsegOpis[0]) . ". " . "Дневните температури се движат околу " . $vtorOpsegTemperatura[0] . ".";
      } else {
        $celosenPrikazGreska = 'Хмм, не можеме да го пронајдеме избраниот град. Ова настанува од неколку причини:<br/>- Ако го впишувате името на градот користејќи стандардна фонетска транслитерација, пробајте користејќи македонска. На пр. наместо "Paris", впишете "Pariz".';
      }   
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Временска прогноза</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h1>Какво време не чека денес?</h1>
      <form>
        <fieldset class="form-group">
          <label for="grad">Внесете име на град по ваш избор (на латинично писмо)</label>
          <input type="text" class="form-control" name="grad" id="grad" placeholder="пр. Скопје, Прилеп" value="<?php echo grad(); ?>">
        </fieldset>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <div id="vreme"><?php 
      if(isset($celosenPrikaz)) { 
        echo '<div class="alert alert-success" role="alert">'.$celosenPrikaz.'</div>';
      } else if (isset($celosenPrikazGreska)) {
        echo '<div class="alert alert-danger" role="danger">'.$celosenPrikazGreska.'</div>';
      } 
        ?></div>
    </div>
  </body>
</html>
