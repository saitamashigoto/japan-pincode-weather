<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>郵便番号検索</title>
        <meta charset="utf-8">
        <link href="/japan-pincode-weather/static/styles.css" rel="stylesheet">
        <?php if ((!empty($postalCode)) && (empty($message))): ?>
            <?php include __DIR__ . '/map_scripts.php'; ?>
        <?php endif; ?>
</head>
    <body>
        <div class="result">
            <?php include __DIR__ . '/form.php'; ?>
            <?php if (isset($message)): ?>
                <?php include __DIR__ . '/error.php'; ?>
            <?php elseif ((!empty($postalCode)) && (empty($message))): ?>
                    <?php include __DIR__ . '/success.php'; ?>
            <?php endif; ?>
        </div>
    </body>
</html>