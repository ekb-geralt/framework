<?php
foreach ($countries as $country) {
    ?>
    <a href="/country/show?id=<?= urlencode($country['id']) ?>"> <!-- этим экранировать адреса-->
        <?= htmlspecialchars($country['name']) ?> <br>
    <?php
}
?>
