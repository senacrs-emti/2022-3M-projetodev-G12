<?php

include_once "endpoint/db.php";

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Real Time Data Display</title>
  </head>
  <body onload = "table();" id="corpo">
    <script type="text/javascript">
      function table(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
          document.getElementById("corpo").style.backgroundColor = this.responseText;
        }
        xhttp.open("GET", "endpoint/api.php");
        xhttp.send();
      }

      setInterval(function(){
        table();
      }, 1000);
    </script>
    <div id="table">

    </div>
  </body>
</html>
