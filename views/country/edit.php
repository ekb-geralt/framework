<?php
/**
 * @var City[] $cities
 * @var bool $isSaved
 * @var Country $country
 */

$form = new Form($country);
?>
<!-- все выходные данные надо экранировать htmlspecialchars - для html, urlencode - для экранирования url-->

<?= $form->open('post') ?> <!-- форма работает над конкретной страной-->
    <?= $form->label('name') ?><br>
    <?= $form->input('name') ?><br>

    <?= $form->label('capitalId') ?><br>
    <?= $form->input('capitalId') ?><br>

    <?= $form->label('population') ?><br>
    <?= $form->input('population') ?><br>

    <?= $form->label('area') ?><br>
    <?= $form->input('area') ?><br>

<!--    <label for="capitalId">Столица</label><br>-->
<!--    <select id="capitalId" name="capitalId">-->
<!--        --><?php //foreach ($cities as $city) { ?>
<!--            --><?//= $country->id == $city->countryId ?>
<!--            <option --><?//= $country->id == $city->countryId  ? 'selected' : '' ?><!-- value="--><?//= htmlspecialchars($city->id) ?><!--">--><?//= htmlspecialchars($city->name) ?><!--</option>-->
<!--        --><?php //} ?>
<!--    </select>-->
    <button type="submit" name="submit" value="1">Сохранить</button>
    <br>
    <?php if ($isSaved) { ?>
        Сохранено.
    <?php } ?>
<?= $form->close() ?>
<a href="/country/list">К списку</a>