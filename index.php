<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php
    $japaneseWeekDay = [
      1 => '月曜日',
      2 => '火曜日',
      3 => '水曜日',
      4 => '木曜日',
      5 => '金曜日',
      6 => '土曜日',
      7 => '日曜日',
    ];

    function getJapaneseWeekdayFromNumber($dayNumber)
    {
      global $japaneseWeekDay;
      return $japaneseWeekDay[$dayNumber];
    }

    function getLatLong($postCode)
    {
      $latLongXml = file_get_contents("https://www.geocoding.jp/api/?q=" . $postCode);
      $xmlObj = simplexml_load_string($latLongXml);
      $coordinates = json_decode(json_encode($xmlObj), true);
      if (isset($coordinates['error'])) {
        return null;
      }
      return [
        'lat' => $coordinates['coordinate']['lat'],
        'long' => $coordinates['coordinate']['lng'],
      ];
    }

    function getLocationFromCoord($latLong)
    {
      $locationInfo =
        file_get_contents(
          "http://geoapi.heartrails.com/api/json?method=searchByGeoLocation&" .
            "x=$latLong[long]&y=$latLong[lat]"
        );
      $locationInfo = json_decode($locationInfo, true);
      return $locationInfo;
    }


    function getWeatherInfo($latLong)
    {
      $weatherInfo =
        file_get_contents(
          "https://api.openweathermap.org/data/2.5/onecall?" .
            "exclude=current,minutely,hourly&appid=f86ff2548680116dd9dbb5e81d941a85&lang=ja&units=metric&" .
            "lon=$latLong[long]&lat=$latLong[lat]"
        );
      $weatherInfo = json_decode($weatherInfo, true);
      return $weatherInfo;
    }

    function getFreeSpaceContent($latLong, $range = 2)
    {
      $url = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=1f1c05b5ec757f8c&lat=$latLong[lat]&lng=$latLong[long]&format=json&" .
            "range=$range";
      $freeSpaceContent =
        @file_get_contents($url);
      $freeSpaceContent = empty($freeSpaceContent) ? ['result' => []] : $freeSpaceContent;
      $freeSpaceContent = json_decode($freeSpaceContent, true)['results'] ?? [];
      if (empty($freeSpaceContent) || isset($freeSpaceContent['error']['message'])) {
        $freeSpaceContent['error']['message'] = '指定された条件の店舗が存在しません';
      }

      return $freeSpaceContent;
    }

    function treatPostCode($postCode)
    {
      $postCode = trim($postCode);
      $postCode = implode("", explode("-", $postCode));
      return $postCode;
    }

    ?>
    <title>ソフトウェア開発者試験</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <style>
      body {
        display: flex;
        flex-flow: column wrap;
        align-items: center;
        justify-content: center;
        padding: 5%;
      }

      .postcode-form {
        display: flex;
        flex-flow: row nowrap;
        justify-content: center;
        width: 100%;
      }

      .postcode-form .label {
        margin-right: 1%;
        display: block;
      }

      .postcode-form .input {
        margin-right: 1%;
        display: block;
      }

      .postcode-form .button {
        margin-right: 1%;
        display: block;
      }

      .result {
        width: 100%;
      }

      .location-label {
        text-align: center;
      }

      .weather-forecast .container {
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        width: 100%;
      }

      .weather-forecast .container .content-card {
        display: flex;
        flex-flow: column wrap;
        justify-content: center;
        align-items: center;
        border: 1px solid black;
        padding: 1%;
        min-width: 300px;
      }

      .weather-forecast .container .content-card:not(:last-child) {
        margin-right: 1%;
      }

      .weather-forecast .container .content-card .icon img {
        width: 100%;
      }

      .weather-forecast .container .content-card .date-time,
      .weather-forecast .container .content-card .temp {
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        width: 100%;
      }


      .weather-forecast .container .content-card .label {
        text-align: center;
        font-size: 25px;
      }

      .third-section {
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        width: 100%;
      }

      .third-section>* {
        width: 48%;
      }

      .third-section .map .content {
        width: 100%;
        height: 350px;
        border: 1px solid black;
      }

      .third-section .free-space .content {
        width: 100%;
        height: 350px;
        display: block;
        overflow: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .rest-table {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        border-collapse: collapse;
      }

      .border-1px-black {
        border: 1px solid black;
      }

      th,
      td {
        border: 1px solid black;
        padding: 5px;
      }

      th {
        text-align: left;
        font-size: 20px;
      }

      .rest-error {
        padding: 10px;
      }
    </style>
  </head>

  <body>
    <form method="POST" action="./" class="postcode-form">
      <label for="postCode" class="label">郵便番号</label>
      <input id="postCode" type="text" name="postCode" class="input">
      <input type="submit" class="button">
    </form>
    <?php
    if (
      ($postCode = $_POST['postCode'] ?? null) &&
      ($latLong = getLatLong($postCode))
    ) : ?>
      <div class="result">
        <div class="location-label">
          <?php $locationInfo = getLocationFromCoord($latLong);
          $treatedPostCode = treatPostCode($postCode);
          if (isset($locationInfo['response']['location'])) {
            $locationInfo = $locationInfo['response']['location'];
          } else {
            $locationInfo = '住所の情報の取得に失敗しました。';
          }
            
          if (is_array($locationInfo)) {
            $locationInfoByPostCode = array_filter($locationInfo, function ($location) use ($treatedPostCode) {
              return $location['postal'] === $treatedPostCode;
            });
            $locationInfo = count($locationInfoByPostCode)
              ? array_shift($locationInfoByPostCode) : array_shift($locationInfo);
            $label = (empty($locationInfo['prefecture'])
              ? '' : $locationInfo['prefecture'] . (empty($locationInfo['city']) && empty($locationInfo['town']) ? '' : ', ')) .
              (empty($locationInfo['city'])
                ? '' : $locationInfo['city'] . (empty($locationInfo['town']) ? '' : ', ')) .
              (empty($locationInfo['town'])
                ? '' : $locationInfo['town']);
          }
          ?>
          <h2 class="header"><?= $label ?? $locationInfo; ?></h2>
        </div>
        <div class="weather-forecast">
          <div class="header">
            <h3>３日間天気予報</h3>
          </div>
          <div class="container">
            <?php
            $weatherInfo = getWeatherInfo($latLong);
            if (!empty($weatherInfo)) :
              date_default_timezone_set($weatherInfo['timezone']);
              $dateFormat = 'Y-m-d';
              $weekdayFormat = 'N';
              $threeDaysForecast = array_chunk($weatherInfo['daily'], 3)[0];
              foreach ($threeDaysForecast as $forecast) :
                $date = date($dateFormat, $forecast['dt']);
                $weekday = date($weekdayFormat, $forecast['dt']);
                $weekday = getJapaneseWeekdayFromNumber($weekday);
                $weatherIcon = $forecast['weather'][0]['icon'];
                $weatherDesc = $forecast['weather'][0]['description'];
                $tempMin = $forecast['temp']['min'];
                $tempMax = $forecast['temp']['max'];
            ?>
                <div class="content-card">
                  <div class="icon">
                    <img src="http://openweathermap.org/img/wn/<?= $weatherIcon ?>@4x.png" title="<?= $weatherDesc ?>">
                  </div>
                  <div class="date-time">
                    <div class="date"><?= $date; ?></div>
                    <div class="weekday"><?= $weekday; ?></div>
                  </div>
                  <div class="label"><?= $weatherDesc ?></div>
                  <div class="temp">
                    <div class="max"><?= "最高気温：" . $tempMax . "&deg;" ?>
                    </div>
                    <div class="min"><?= "最低気温：" . $tempMin . "&deg;" ?></div>
                  </div>
                </div>

              <?php
              endforeach;
            else : ?>
              <div>"情報が見つかりませんでしした。"</div>
            <?php endif; ?>
          </div>
        </div>
        <div class="third-section">
          <div class="map">
            <div class="header">
              <h3>地図</h3>
            </div>
            <div class="content" id="map">

            </div>
            <script>
              const mymap = L.map('map');

              L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">地図</a>',
              }).addTo(mymap);
              
              const coord = [
                +"<?= $latLong['lat'] ?>",
                +"<?= $latLong['long'] ?>"
              ];
              mymap.setView(coord, 13);

              const marker = L.marker(coord)
                .addTo(mymap);
              const popupLabel = "<?= $label ?? '' ?>";
              if (popupLabel) {
                marker.bindPopup(popupLabel)
                  .openPopup();
              }
            </script>
          </div>
          <div class="free-space">
            <div class="header">
              <h3>グルメ店(500メートル以内)</h3>
            </div>
            <div class="content">
              <?php
              $freeSpaceContent = getFreeSpaceContent($latLong);
              if (empty($freeSpaceContent['error']) && isset($freeSpaceContent['shop'])) : ?>
                <table class="rest-table">
                  <thead>
                    <tr>
                      <th>店名</th>
                      <th></th>
                    </tr>
                  </thead>
                  <?php
                  $totalHitCount = $freeSpaceContent['results_returned'];
                  if (empty($totalHitCount)) : ?>
                    <tr>
                      <td colspan="2">店が見つかりませんでした。</td>
                    </tr>
                    <?php
                  else :
                    foreach ($freeSpaceContent['shop'] as $shop) :
                      $name = $shop['name'];
                      $url = $shop['urls']['pc'];
                    ?>
                      <tr>
                        <td><?= $name; ?></td>
                        <td>
                          <a href="<?= $url; ?>" target="_blank">
                            <img src="https://img.icons8.com/metro/26/000000/external-link.png" alt="詳細情報" title="詳細情報" />
                          </a>
                        </td>
                      </tr>
                  <?php
                    endforeach;
                  endif; ?>
                  <tbody>
                  </tbody>
                </table>
              <?php else : ?>
                <p class="rest-error"><?= $freeSpaceContent['error']['message'] ?></p>
                <script>
                  const freeSpace = document.querySelector('.third-section .free-space .content');
                  freeSpace.classList.add('border-1px-black');
                </script>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div>
        <p>住所が見つかりませんでした。</p>
      </div>
    <?php endif; ?>
  </body>
</html>