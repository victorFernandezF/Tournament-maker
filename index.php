<?php
session_start();

function checkCorrectNumberOfParticipants($number, $participants){
    return $number - count($participants);
}

function alertMessage($message){
    echo "<script>alert('". $message ."');</script>";
}

if (isset($_POST['maketor'])){
    $number = $_POST['number'];
    $area = $_POST['participantes'];
    $participants = explode("\r",$area);
    $check = checkCorrectNumberOfParticipants($number, $participants);
    if ($check == $number)
        alertMessage("Introduce los participantes");
    else if ($check > 0)
        alertMessage("Debes introducir mas participantes");
    else if ($check < 0)
        alertMessage("Debes introducir menos participantes");
    else if ($check == 0){
        
        for ($i=0; $i < $number/2 ; $i++) { 
            $rand = array_rand($participants, 1);
            $participant1 = $participants[$rand];
            unset($participants[$rand]);
            $rand2 = array_rand($participants, 1);
            $participant2 = $participants[$rand2];
            unset($participants[$rand2]);
            $newArray[] = "$participant1 <span class='vs'>VS</span> $participant2";            
        }
    $_SESSION['saveArray'] = $newArray;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles_tournament.css">
    <link rel="stylesheet" href="styles/styles_tournament_phone.css">
    <title>Tournament Maker</title>
</head>
<body>
    <div class="mega-container">
        <div class="super-container">
            <div class="container-edit">
                <div class="item">
                    <div class="mega-tittle">
                        <div class="title-view">
                            <h1 class="neon">TOURNAMENT MAKER</h1>
                        </div>
                    </div>
                    <div class="cont">
                        <form action="" method="POST">
                            <fieldset>
                                <label>Nº DE PARTICIPANTES:<span>*</span></label><br>
                                <select class="select" id="number" name="number">
                                    <option value="4">4 PARTICIPANTES</option>    
                                    <option value="8" selected>8 PARTICIPANTES</option>    
                                    <option value="16">16 PARTICIPANTES</option>    
                                </select>
                            </fieldset>
                            <fieldset>
                                <label>PARTICIPANTES:<span>*</span></label>
                                <label class="count" id="count">Participantes: 0</label><br>
                                <textarea class="textarea" type="textarea" cols ="10" row="10" id="participants" oninput="count()" name="participantes"></textarea>
                            </fieldset>
                            <fieldset>
                                <div class="<?= isset($_SESSION['saveArray'])? "result" : "hide" ?>">
                                    <label class="result-title">PRIMERA FASE:</label><br>
                                    <label class="result-text">
                                        <?php
                                            if(!isset($_SESSION['saveArray'])){
                                                echo "NOP";
                                            }else{
                                                $array = $_SESSION['saveArray'];
                                                foreach ($array as $value) {
                                                    echo "• $value <br>";
                                                }
                                            }
                                            session_destroy();
                                        ?>
                                    </label>
                                </div>
                            </fieldset>         
                            <fieldset>
                                <input class="make-tournament" name="maketor" type="submit" value="REALIZAR">
                            </fieldset>
                        </form>
                    </div>
                </div>
            <script>
                
                function count(){
                    let textarea = document.getElementById('participants');
                    let text = textarea.value;
                    let e = document.getElementById("number");
                    let select = e.options[e.selectedIndex].value;
                    let count = document.getElementById('count');
                    words =  text.split(/\r\n|\r|\n/).length;
                    document.getElementById('count').innerHTML = 'Participantes: ' + words;
                    if (words > select) {
                        count.style.color="red";
                        count.style.fontWeight="bold";
                        document.getElementById('count').innerHTML = 'DEMASIADOS';
                    }
                    else if (words == select){
                        count.style.color="green";
                        count.style.fontWeight="bold";
                        document.getElementById('count').innerHTML = 'CORRECTO';

                    }else{
                        count.style.color="black";
                        count.style.fontWeight="normal"; 
                    };
                   
                }

            </script>