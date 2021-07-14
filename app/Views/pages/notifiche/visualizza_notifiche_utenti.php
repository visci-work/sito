<style>

span {
  transition: background-size .5s, background-position .3s ease-in .5s;
}
span:hover {
  transition: background-position .5s, background-size .3s ease-in .5s;
}
span {
  background-image: linear-gradient(orange, orange);
  background-repeat: no-repeat;
  background-position: 0% 100%;
  background-size: 100% 0px;
  border-radius: 10px 10px 10px 10px;
}
span:hover {
  background-size: 100% 100%;
  background-position: 0% 0%;
}

h1 { color: white; font-family: 'Helvetica Neue', sans-serif; 
font-size: 10px; 
font-weight: bold; 
letter-spacing: -1px;
line-height: 0;
text-align: center;
border: 0px; 
}

.notifications-form {
    background-color: #222;
    padding: 40px 20px;
    margin: 100px;
    margin-left: 190px; 
    width: 1160px;
    border-radius: 10px;
    position: relative;
}

</style>


<div class="notifications-form">
    <h1><span class="w3-margin w3-jumbo Title">NOTIFICHE</span></h1>
    <hr>

    <?php 
        session();
        $db = \Config\Database::connect();
        $sql = $db->query("SELECT id, tipologia_test, numero_prenotati, nome_lab, data, orario FROM notifiche, laboratori WHERE email_lab = email AND email_utente ='" . $_SESSION['email'] . "' AND tipo = 'UTENTE' ORDER BY tempo DESC;")->getResultArray();
        $tuples = count($sql);

        for ($i = 0; $i < $tuples; $i++) {
            echo "<p style='width: 80%; float: left; margin-left: 100px;'>";

            if ($sql[$i]['id'] == 1) {

                echo "Hai effettuato una prenotazione per " . $sql[$i]['tipologia_test'] . " ";

                if($sql[$i]['numero_prenotati'] > 1) {
                    echo "per " . $sql[$i]['numero_prenotati'] . " persone ";
                }

                echo "presso il laboratorio " . $sql[$i]['nome_lab'] . " il giorno " . $sql[$i]['data'] . " alle ore " . substr($sql[$i]['orario'], 0, 5);
                
            } else if ($sql[$i]['id'] == 2) {

                echo "Hai annullato la prenotazione per " . $sql[$i]['tipologia_test'] . " ";

                if($sql[$i]['numero_prenotati'] > 1) {
                    echo "per " . $sql[$i]['numero_prenotati'] . " persone ";
                }

                echo "presso il laboratorio " . $sql[$i]['nome_lab'] . " il giorno " . $sql[$i]['data'] . " alle ore " . substr($sql[$i]['orario'], 0, 5);

            } else if ($sql[$i]['id'] == 3) {

                echo "La prenotazione per " . $sql[$i]['tipologia_test'] . " ";

                if($sql[$i]['numero_prenotati'] > 1) {
                    echo "per " . $sql[$i]['numero_prenotati'] . " persone ";
                }

                echo "presso il laboratorio " . $sql[$i]['nome_lab'] . " il giorno " . $sql[$i]['data'] . " alle ore " . substr($sql[$i]['orario'], 0, 5) . " è stata annullata";

            } else if ($sql[$i]['id'] == 4) {

                echo "Il " . $sql[$i]['tipologia_test'] . " effettuato il giorno " . $sql[$i]['data'] . " alle ore " . substr($sql[$i]['orario'], 0, 5) . " presso il laboratorio " . $sql[$i]['nome_lab'] . " ha dato come esito: POSITIVO " ;

                if($sql[$i]['numero_prenotati'] > 1) {
                    echo "per " . $sql[$i]['numero_prenotati'] . " persone ";
                }

            } else if ($sql[$i]['id'] == 5) {

                echo "Il " . $sql[$i]['tipologia_test'] . " effettuato il giorno " . $sql[$i]['data'] . " alle ore " . substr($sql[$i]['orario'], 0, 5) . " presso il laboratorio " . $sql[$i]['nome_lab'] . " ha dato come esito: NEGATIVO " ;
            
            } else if ($sql[$i]['id'] == 6) {

                echo "Il " . $sql[$i]['tipologia_test'] . " effettuato il giorno " . $sql[$i]['data'] . " alle ore " . substr($sql[$i]['orario'], 0, 5) . " presso il laboratorio " . $sql[$i]['nome_lab'] . " ha dato come esito: POSITIVO per " . $sql[$i]['numero_prenotati'] . " persone "; ;
            
            }

            echo "</p>";
            echo "<button type='submit' name='elimina_notifica' class='material-icons' id='" . $i . "' onclick='elimina_notifica(this.id)'> 
            <a class='icons' style='font-size: 29px; color:rgb(255, 40, 20); line-height: 102px;'> 
            cancel 
            </a> 
            </button>";
            echo "<div style='clear:both'> </div>";
        }

    ?>
    
    
</div>

<script>
    function elimina_notifica(id) {

        $.ajax({
            url: "/elimina_notifica",
            type: "POST",
            data: {id},
            dataType: "json",
            success: function(){
                window.location.href = "/visualizza_notifiche";
            }
        })
    }
</script>