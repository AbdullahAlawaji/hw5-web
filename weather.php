<html>
    <head>
        <style>
            .temperature {
                font-weight: bold;
                border-radius: 12px;
                padding: 4px;
                background-color: #ccc;
                display: inline;
            }
        </style>

    </head>
    <body>
        <?php

            if(isset($_POST["City"])) {
                $radio_option = $_POST["radio-option"];
                $city = urlencode($_POST["City"]);
                $API = curl_init("https://api.openweathermap.org/data/2.5/weather?q=$city&appid=ab9f9345fd1cf7d39c87947fa553eb0b");
                curl_setopt($API,CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt_array($API,[CURLOPT_RETURNTRANSFER => true]);
                $info = json_decode(curl_exec($API),true);
                curl_close($API);
                if($info["cod"]=="404"){
                    echo "the city does not exist <a href='index.html'>please try again and Enter a valid city </a>";
                }
                else{
                    $status = $info["weather"][0]["description"];
                    $temp = ConvertTemp($info["main"]["temp"],$radio_option);
                    $hba = $info["main"]["pressure"];
                    $wind = $info["wind"]["speed"];
                    $maxTemp = ConvertTemp($info["main"]["temp_max"],$radio_option);
                    $minTemp = ConvertTemp($info["main"]["temp_min"],$radio_option);
                    $clouds = $info["clouds"]["all"];

                    //$coun = $info["country"];
                    echo "<div style='padding : 10px; margin : 6% 25% 6% 25%; border : 1px solid blue;'><p><span style='color : orange'>$city</span> <i><b>$status</b></i></p>";
                    echo "<p><span class='temperature'>$temp ° $radio_option</span> temperature from $minTemp tp $maxTemp °$radio_option, wind $wind m/s. clouds $clouds %, $hba hba </p></div>";
              }
            }


            function ConvertTemp($temp,$unit) { // it is in keliven originally
                $temp = (int)$temp;
                if($unit == "Fahrenheit"){
                    $temp = $temp - 273;
                    $temp = 1.8 * $temp + 32;
                  }
                else {
                    $temp = $temp - 273;
                }
                return $temp;
            }
        ?>
</body>
</html>
