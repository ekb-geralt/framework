<?php
/**
 * @var City $city
 * @var bool $isSaved
 * @var Country[] $countries
 * @var Country $country
 */

$form = new Form($city);
?>
<!-- все выходные данные надо экранировать htmlspecialchars - для html, urlencode - для экранирования url-->

<?= $form->open('post') ?> <!-- форма работает над конкретным городом-->
    <?= $form->label('name') ?><br>
    <?= $form->input('name') ?><br>

    <?= $form->label('population') ?><br>
    <?= $form->input('population') ?><br>

    <label for="isCapital">Является столицей</label><br>
    <?= $form->input('isCapital') ?><br>

    <label for="creationDateObject">Дата основания</label><br>
    <?= $form->dateInput('creationDateObject') ?><br>

    <label for="unemploymentRate">Уровень безработицы</label><br>
    <?= $form->input('unemploymentRate') ?><br>

    <label for="countryId">Название страны</label><br>
    <select id="countryId" name="countryId">
        <?php foreach ($countries as $country) { ?>
            <option <?= $city->countryId == $country->id ? 'selected' : '' ?> value="<?= htmlspecialchars($country->id) ?>"><?= htmlspecialchars($country->name) ?></option>
        <?php } ?>
    </select>
    <button type="submit" name="submit" value="1">Сохранить</button> <!-- в атрибуте name лежит ключ, в атрибуте value значение, каждый html элемент с атрибутом name создает в посте элемент с ключем который лежит в атрибуте name, и значением которое лежит в атрибуте valueт, атрибут фор у лейбла сопрягается с ид у селекта или инпута-->
    <br>
    <?php if ($isSaved) { ?>
        Сохранено.
    <?php } ?>
<?= $form->close() ?>
<a href="/city/list">К списку</a>