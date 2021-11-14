<form method="POST" action="/japan-pincode-weather/request_processor.php" class="postcode-form">
    <label for="postCode" class="label">郵便番号</label>
    <input id="postCode" value="<?= empty($postalCode) ? "" : $postalCode; ?>"
    type="text" name="postalCode" placeholder="160-0022" class="input">
    <input type="submit" class="button">
</form>