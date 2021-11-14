<div class="weather-forecast">
    <div class="header">
        <h3>３日間天気予報</h3>
    </div>
    <div class="container">
        <?php
            $weatherForcasts = $weatherForecastCollection->getItems();
            foreach ($weatherForcasts as $weatherForecast):?>

            <div class="content-card">
                <div class="icon">
                    <img src="<?= $weatherForecast->getIconUrl() ?>" alt="天気の画像"
                        title="<?= $weatherForecast->getDescription() ?>">
                </div>
                <div class="date-time">
                    <div class="date"><?= $weatherForecast->getDate() ?></div>
                    <div class="weekday"><?= $weatherForecast->getWeekday() ?></div>
                </div>
                <div class="label"><?= $weatherForecast->getDescription() ?></div>
                <div class="temp">
                    <div class="max"><?= "最高気温：" . $weatherForecast->getTempMax() . "&deg;" ?>
                    </div>
                    <div class="min"><?= "最低気温：" . $weatherForecast->getTempMin() . "&deg;" ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>