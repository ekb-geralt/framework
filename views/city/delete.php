<?php
/**
 * @var City $city
 */
?>
<form method="post">
    Вы уверены, что хотите удалить город <?= $city->name ?>?<br>
    <button type="submit" name="yes" value="1">Да</button>
    <button type="submit" name="no" value="1">Нет</button>
</form>