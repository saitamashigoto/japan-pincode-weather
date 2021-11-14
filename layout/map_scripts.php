<script type='text/javascript'>
    function GetMap() {
        var loc = new Microsoft.Maps.Location(
                Number('<?= $point->getLatitude() ?>'),
                Number('<?= $point->getLongitude() ?>'),
            );
        var map = new Microsoft.Maps.Map('#mp', {
            credentials: 'AvvgpVVNrJGOAJhQZCOTCLhOFZaXoJ-jRQHMvcDt7yybzOajKP_HDy3lSZ4enKMh',
            center: loc,
            zoom: 25
        });

        var center = map.getCenter();
        var pushPinTitle = '<?= $address->getFormattedAddress() ?>';  
        var pushPinSubTitle = '<?= $address->getLocality() ?>';
        var pushPinConfig = {
            title: pushPinTitle,
            text: '1'
        };
        if (pushPinSubTitle) {
            pushPinConfig.subTitle = pushPinSubTitle;
        }

        var pin = new Microsoft.Maps.Pushpin(center, pushPinConfig);

        map.entities.push(pin);
    }
    </script>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?setLang=ja&callback=GetMap' async defer></script>