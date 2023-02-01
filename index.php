<?php
require 'data.php';
if (isset($_COOKIE["matches"])) {
    $matches = json_decode($_COOKIE['matches'], true);
} else {
    $matches = array(
        "MorocoVSCroitia" => array("Morocco" => 0, "Croitia" => 0, "Played" => false),
        "CroitiaVSCanada" => array("Croitia" => 0, "Canada" => 0, "Played" => false),
        "morrocoVSCanada" => array("Morocco" => 0, "Canada" => 0, "Played" => false),
        "CroitiaVSBelgium" => array("Croitia" => 0, "Belgium" => 0, "Played" => false),
        "CanadaVSBelgium" => array("Canada" => 0, "Belgium" => 0, "Played" => false),
        "MorocoVSBelgium" => array("Morocco" => 0, "Belgium" => 0, "Played" => false),
    );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World cup simulator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body class="bg-light">
    <header>
        <h1 class="text-center m-2">WorldCup Simulator</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET['gameId']) ){
            foreach($matches as $cName => $matchInfo) {
                $matches[$cName][$_GET[$cName][0]] = $_GET[$cName][1];
                $matches[$cName][$_GET[$cName][2]] = $_GET[$cName][3];
                $matches[$cName]['Played'] = true;
                // echo "<pre>";
                // print_r($_GET[$game]);
                // echo "</pre>";
            }
            setcookie('matches', json_encode($matches));
        } elseif ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET['reset'])){
            $matches = array(
              "MorocoVSCroitia" => array("Morocco" => 0, "Croitia" => 0, "Played" => false),
              "CroitiaVSCanada" => array("Croitia" => 0, "Canada" => 0, "Played" => false),
              "morrocoVSCanada" => array("Morocco" => 0, "Canada" => 0, "Played" => false),
              "CroitiaVSBelgium" => array("Croitia" => 0, "Belgium" => 0, "Played" => false),
              "CanadaVSBelgium" => array("Canada" => 0, "Belgium" => 0, "Played" => false),
              "MorocoVSBelgium" => array("Morocco" => 0, "Belgium" => 0, "Played" => false),
            );+
            setcookie('matches', json_encode($matches));
        }
        ?>
    </header>
    <!-- all matches section -->
    <main class="d-flex justify-content-center flex-wrap">
        <section class="col-md-4 mx-1" id="matches">
            <?php
        foreach ($matches as $cName => $matchInfo): ?>
            <?php
            $matchesParticipants = [];
            $matchesScore = []; foreach ($matchInfo as $key => $value):
                array_push($matchesParticipants, $key);
                array_push($matchesScore, $value);
                ?>
            <?php endforeach ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" class="navy_blue_bg  mb-3">
            </div>
            <div class="d-flex mb-1 color m-2">
               <p>10 NOV 23:00</p>
               <p class="UBC">Final</p>
               <p>Match 10</p>
            </div>
            <div class="d-flex mb-3 BC p-2 justify-content-center ">
                <span class="p-2"> <?php echo $matchesParticipants[0] ?></span>
                   <div class="score">   
                        <!-- game name -->
                        <input type="hidden" name="gameId" value="<?php echo $cName ?>">
                        <!-- first team name -->
                        <input type="hidden" name="<?php echo $cName ?>[]" value="<?php echo $matchesParticipants[0] ?>">
                        <!-- first team score -->
                        <input type="number" min="0" name="<?php echo $cName ?>[]"
                            <?php if ($matchInfo["Played"] == true) {echo "readonly";} ?>
                            value="<?php echo $matchesScore[0]?>" class="text-center">
                        <!-- second team name -->
                        <input type="hidden" name="<?php echo $cName ?>[]" value="<?php echo $matchesParticipants[1] ?>">
                        <!-- second team score -->
                        <input type="number" min="0" name="<?php echo $cName ?>[]"
                        value="<?php echo $matchesScore[1] ?>"
                        <?php if ($matchInfo["Played"] == true) {echo "readonly";} ?> class="text-center">
                    </div>
                <span class="p-2"> <?php echo $matchesParticipants[1] ?></span>
            </div>
                <?php endforeach ?>
                <input type="submit" name="" value="Submit" class="btn btn-success container">
            </form>
            <div class="text-center">
                <form method='GET' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="reset" value="reset">
                    <input type="submit" class="btn text-center container btn-warning" value="Reset all matches">
                </form>
            </div>
          </section>
          <section class="col-md-6 px-3 py-4 mx-1">
          <h2 class="py-2 text-center text-primary">Leaderboard</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="align-middle">
                            <th class="text-bg-secondary">Rank</th>
                            <th class="text-bg-secondary">Team</th>
                            <th class="text-bg-secondary">PTS</th>
                            <th class="text-bg-secondary">G.P</th>
                            <th class="text-bg-secondary">G.W</th>
                            <th class="text-bg-secondary">G.E</th>
                            <th class="text-bg-secondary">G.L</th>
                            <th class="text-bg-secondary">G.S</th>
                            <th class="text-bg-secondary">G.R</th>
                            <th class="text-bg-secondary">DIF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_REQUEST['simulate']) &&  $_REQUEST['simulate'] == "simulate") 
                        {
                            foreach(sortTable(createTeams($matches)) as  $cName => $matchInfo){
                        ?>
                        <tr>
                            <td scope="row"><?php echo $cName + 1; ?> </td>
                            <td><?php echo $matchInfo["Team"];  ?></td>
                            <td class="first-td"><?php echo $matchInfo["POINTS"];  ?></td>
                            <td><?php echo $matchInfo["GAMES_PLAYED"];  ?></td>
                            <td><?php echo $matchInfo["GAMES_WON"];  ?></td>
                            <td><?php echo $matchInfo["GAMES_EQUAL"];  ?></td>
                            <td><?php echo $matchInfo["GAME_LOSTS"];  ?></td>
                            <td><?php echo $matchInfo["GOALS_SCORED"];  ?></td>
                            <td><?php echo $matchInfo["GOALS_RECEIVED"];  ?></td>
                            <td class="last-td"><?php echo $matchInfo["DIFF"]; ?></td>
                        </tr>
                        <?php
                    }    
                }else {
                    echo "
<tr class='align-middle'>
<td scope='row'>1</td>
<td>Morocco</td>
<td class='first-td'>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td class='last-td'>0</td>
</tr>
<tr>
<td>2</td>
<td>Canada</td>
<td class='first-td'>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td class='last-td'>0</td>
</tr>
<tr>
<td>3</td>
<td>Belgium</td>
<td class='first-td'>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td class='last-td'>0</td>
</tr>
<tr>
<td>4</td>
<td>Croitia</td>
<td class='first-td'>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td class='last-td'>0</td>
</tr> 
";
                }
                ?>
                        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="simulate" value="simulate" class="m-auto">
                            <input type="submit" class="btn btn-warning text-center my-3 " value="simulate">
                        </form>
        </section>
    </main>
</body>

</html>