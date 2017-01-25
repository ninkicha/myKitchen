<!DOCTYPE html>
<html>

  <head>

    <title>myKitchen</title>
    <meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="stylesheets/myKitchen.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.18.4/themes/smoothness/jquery-ui.css"/>

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script type="text/javascript" src="js/myKitchen.js"></script>

  </head>

  <body>
    <script type="text/javascript">
      var data = <?php echo json_encode($_POST) ?>;

      var beruf;
      if (data.other.length > 0) {
        beruf = data.other;
      } else {
        beruf = data.beruf;
      }

      var row = [data.nickname, data.anrede, data.age, data.nationality, data.hours1, data.hours2, beruf];


      // lupe
      $(document).ready(function() {
        $('.objekte')
        .mouseover(function() {
          $('#lupe').css({'background-image': 'url('+ $(this).attr('src') +')', 'left' : ($(this).offset().left - 100)+'px', 'top' : ($(this).offset().top - 170)+'px', 'display':(($(this).parent().attr('id') === 'obj')? 'none' : 'block')});
        })
        .mouseout(function() {
          $( '#lupe' ).css({'display': 'none', 'background-image': 'url()'});
        });
      });
    </script>

    <noscript>Your browser does not support JavaScript!</noscript>
    <h1>Küchensimulation</h1>
    <h3 class="hidden">Vielen Dank für Ihre Teilnahme! ;) </h3>

  <div class="all">
    <div id="lupe"></div>
    <div class="kitchen" id="gkitchen">
			<div class="door" id="d1">S1</div> <!-- ondblclick="openDoor()" -->
			<div class="door" id="d2">S2</div>
			<div class="door" id="d3">S3</div>
			<div class="door" id="d4">S4</div>
			<div class="door" id="d5">S5</div>
			<div class="door" id="d6">S6</div>
			<div class="door" id="d7">S7</div>
			<div class="door" id="d8">S8</div>
			<div class="door" id="d9">S9</div>
			<div class="door" id="d10">S10</div>
			<div class="door" id="d11">S11</div>
      <div class="door" id="d12">S12</div>


			<div class="schrank" id="s1">
				<div class="regal" id="s1-1"></div>
				<div class="regal" id="s1-2"></div>
				<div class="regal" id="s1-3"></div>
			</div>
			<div class="schrank" id="s2">
        <div class="regal" id="s2-1"></div>
				<div class="regal" id="s2-2"></div>
				<div class="regal" id="s2-3"></div>
      </div>
			<div class="schrank" id="s3">
        <div class="regal" id="s3-1"></div>
        <div class="regal" id="s3-2"></div>
      </div>
			<div class="schrank" id="s4">
        <div class="regal" id="s4-1"></div>
        <div class="regal" id="s4-2"></div>
      </div>
			<div class="schrank" id="s5"><div class="regal" id="s5-1"></div></div>
			<div class="schrank" id="s6">
        <div class="regal" id="s6-1"></div>
        <div class="regal" id="s6-2"></div>
        <div class="regal" id="s6-3"></div>
        <!--<div class="regal" id="s6-4"></div>-->
      </div>
			<div class="schrank" id="s7"><div class="regal" id="s7-1"></div></div>
			<div class="schrank" id="s8"><div class="regal" id="s8-1"></div></div>
			<div class="schrank" id="s9">
        <div class="regal" id="s9-1"></div>
        <div class="regal" id="s9-2"></div>
      </div>
			<div class="schrank" id= "s10"><div class="regal" id="s10-1"></div></div>
			<div class="schrank" id="s11">
        <div class="regal" id="s11-1"></div>
        <div class="regal" id="s11-2"></div>
      </div>
      <div class="schrank" id="s12">
        <div class="regal" id="s12-1"></div>
        <div class="regal" id="s12-2"></div>
      </div>

      <div class="regal" id="obfl1"></div>
      <!--
      <div class="regal" id="obf2"></div>
    -->
      <div class="regal" id="obfl3"></div>
		</div>

    <div id="obj" class="regal">
    <?php
      //mb_internal_encoding('UTF-8');
      function setOffset($height, $width){
        $height = round(number_format($height));
        $width = round(number_format($width));

        $result = "";
        if ($height <= 50) {
          $result = $result."min-height:".$height."px;";
        } else {
          $result = $result."max-height:".$height."px;";
        }

        if ($width <= 50) {
          $result = $result."min-width:".$width."px;";
        } else {
          $result = $result."max-width:".$width."px;";
        }

        return $result;
      }

      function nicknameToFile($str){
        $replace_array = array(
          '-' => '_',
          ' ' => '_',
          ':' => '_',
          '.' => '_',
          ';' => '_',
          'Ä' => 'Ae',
          'Ö' => 'Oe',
          'Ü' => 'Ue',
          'ä' => 'ae',
          'ö' => 'oe',
          'ü' => 'ue',
          'ß' => 'ss');
        $result = strtr($str,$replace_array);
        return $result;
      }

			// define DB parameter
			//require_once('connect.php');
			$host = "localhost";
			$user = "root";
			$pass = "";
			$db = "myKitchen_db";

      // connection
			$db_connection = mysql_connect($host, $user, $pass) or die('Verbindung fehlgeschlagen: '.mysql_error());
			mysql_select_db($db, $db_connection) or die(mysql_error());

      // SQL-Statements
			$select_elem_mk = "SELECT name, picture, width, height FROM myKitchen";
			$select_all_mk = "SELECT * FROM myKitchen";
      //$select_all_k = "SELECT * FROM kitchen";


      $result_mk = mysql_query($select_all_mk, $db_connection);
      //$result_k = mysql_query($select_all_k, $db_connection);

      $js_array_mk = array();

			if (mysql_num_rows($result_mk) > 0) {
				while($row = mysql_fetch_array($result_mk)) {
          $image = $row['picture'];
          if (strlen($image) == 0) {
            $image = "default.jpeg";
          }
          $offset = setOffset($row['height'], $row['width']);
					echo "<img class=\"objekte\" id=\"".$row[0]."\" src=\"images/".$image."\" alt=\"".utf8_encode($row['name'])."\" style=\"".$offset."\"/>";
          $js_array_mk[] = array($row['id'], utf8_encode($row['name']), $row['picture'], $row['height'], $row['width'], $row['depth']);
        }
			} else {
        echo "Datenbanktabelle ist leer";
      }

      # add new row(array) in csv-file
      if (isset($_POST["arr1"])) {
        $arr = $_POST["arr1"];
        $arr2 = $_POST["arr2"];
        $arr3 = $_POST["arr3"];

        // create writable directory if not exists
        $dir = "userdaten/";
        if (!file_exists($dir)){
          $oldmask = umask(0); // for linux Server
          mkdir($dir, 0755);
        }

        if (count($arr) > 7) {
          $a1 = array_shift($arr);
          $results = $dir.'results.csv';
          chmod($results, 0755);
          $userscore = fopen($results, 'a');
          if (trim(file_get_contents($results)) == false) {
            $first = array('username','anrede','Alter','nationality','stunden_tag','stunden_woche','beruf','startzeit','endzeit','mouseclicks','clicks_auf_bilder');
            fputcsv($userscore, $first);
          }
          fputcsv($userscore, $arr);
          fclose($userscore);
          // $fp = fopen('userdaten/results.csv', 'a');
          // fputcsv($fp, $arr);
          // fclose($fp);
        }

        if (isset($_POST["arr2"])){
          $dir = $dir.nicknameToFile($arr[0]).'/';
          if (!file_exists($dir)){
            $oldmask = umask(0); // for linux Server
            mkdir($dir, 0755);
          }

          $fp = fopen($dir.nicknameToFile($arr[0]).'_'.nicknameToFile($arr[7]).'.csv', 'w');
          chmod($fp, 0755);
          fputcsv($fp, $arr3);

          $l = count($arr2);
          for ($i = 0; $i < $l; $i++) {
            fputcsv($fp, $arr2[$i]);
          }


          // fwrite($fp, count($arr2));
          fclose($fp);
          fclose($fp2);

          if ($l > 0){
            $fpf = fopen($dir.nicknameToFile($arr[0]).'_'.nicknameToFile($arr[7]).'_finish.csv', 'w');
            chmod($fpf, 0755);

            $a1 = array_shift($arr3);
            $al = array_pop($arr3);
            fputcsv($fpf, $arr3);

            while ( $arr2[$l - 1][0] == "RESTART" && $l > 1){
              $l--;
            }
            $a1 = array_shift($arr2[$l - 1]);
            $al = array_pop($arr2[$l - 1]);
            fputcsv($fpf, $arr2[$l - 1]);

            fclose($fpf);
          }
        }
      }

      // delete array and close DB connection
      mysql_free_result($result_mk);
      //mysql_free_result($result_k);
      mysql_close($db_connection);
		?>
    </div>

    <script type="text/javascript">
      <?php
        echo "var daten = ", json_encode($js_array_mk), ";";
      ?>
    </script>

    <div class="but">
      <button id="back" style="font-size: 18px; width: 35px;"><</button>
      <button id="next" style="font-size: 18px; width: 35px;">></button>
      <button id="open">Open</button>
      <button id="close">Close</button>
      <button id="refresh">Restart</button>
      <button id="finish">Finish</button>
    </div>

    <div class="resultate-kueche">
      <ul class="resultate-list"></ul>
    </div>
    <div id="test"></div>
  </div>

	</body>

</html>
