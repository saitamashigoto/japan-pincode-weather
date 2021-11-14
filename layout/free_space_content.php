<div class="free-space">
    <div class="header">
        <h3>グルメ店(500メートル以内)</h3>
    </div>
    <div class="content">
        <table class="rest-table">
            <thead>
                <tr>
                    <th>店名</th>
                    <th></th>
                </tr>
            </thead>
            <?php  
                $shops = $shopCollection->getItems();
                foreach ($shops as $shop):
            ?>
                <tbody>
                    <tr>
                        <td><?= $shop->getName() ?></td>
                        <td>
                            <a href="<?= $shop->getUrl() ?>" target="_blank">
                                <img src="https://img.icons8.com/metro/26/000000/external-link.png" alt="詳細情報"
                                    title="詳細情報" />
                            </a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
</div>