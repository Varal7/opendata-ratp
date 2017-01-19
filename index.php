<?php
include ('WSIVMissionsNextRequest.php');
$request = new WSIVMissionsNextRequest("RB", "Lozere", "A");
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Horaires RATP">
        <meta name="author" content="">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Horaires RATP</title>
    </head>

    <body>
        <h1 class="text-center"><samp>Prochains passages RATP</samp><br /><small>Powered by RATP's <a href="https://data.ratp.fr/explore/dataset/horaires-temps-reel/">Open Data API</a></small></h1>
        <div class="container" id="prochains_passages">

          <fieldset class="rer">
                <div class="line_details">
                  <strong><?php echo $request->getLine(); ?></strong><br />
                  <strong>Station: </strong><span><?php echo $request->getStation(); ?></span><br />
                  <strong>Direction: </strong><span><?php echo $request->getDirection() ?></span>
                </div>
                <div class="date_time pull-right">
                  <span class="date"><?php echo $request->getDate(); ?></span>
                  <span class="time"><?php echo $request->getTime(); ?></span>
                </div>

            <div class="perturbations">
                <?php
                foreach($request->getPerturbations() as $perturbation) {
                    echo '<p class="perturbation">' . $perturbation->message->text . '</p>';
                }
                ?>
            </div>

            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="name">Nom</th>
                  <th class="terminus">Terminus</th>
                  <th class="passing_time">Heure de passage</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  foreach($request->getMissions() as $mission) {
                      $id = isset($mission->id) ? $mission->id . ' ' : "";
                      ?>
                      <tr>
                        <td class="name"><?php echo $id; ?></td>
                        <td class="terminus"><?php echo $mission->stations[1]->name; ?></td>
                        <td class="passing_time"><?php echo $mission->stationsMessages; ?></td>
                      </tr>
                      <?php
                  }
                  ?>
              </tbody>
            </table>
          </fieldset>
        </div>
    </body>
</html>
