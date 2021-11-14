<script type='text/javascript'>
    function GetMap() {
        var loc = new Microsoft.Maps.Location(
                Number('<?= $point->getLatitude() ?>'),
                Number('<?= $point->getLongitude() ?>'),
            );
        var map = new Microsoft.Maps.Map('#map', {
            credentials: 'AvvgpVVNrJGOAJhQZCOTCLhOFZaXoJ-jRQHMvcDt7yybzOajKP_HDy3lSZ4enKMh',
            center: loc,
        });

        var center = map.getCenter();
        var pushpinTitle = '<?= $address->getFormattedAddress() ?>';  
        var pushpinSubTitle = '<?= $address->getPostalCode() ?>';
        var pushpinConfig = {
            title: pushpinTitle,
            text: '1'
        };
        if (pushpinSubTitle) {
            pushpinConfig.subTitle = pushpinSubTitle;
        }

        var pin = new Microsoft.Maps.Pushpin(center, pushpinConfig);

        map.entities.push(pin);
    }
    </script>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?setLang=ja&callback=GetMap' async defer></script>