<?php
/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 23.03.2016
 * Time: 23:15
 */
/** @var string[] $numbers */ //��������� ��� numbers - ������ �����
?>
<form method="post">
    <textarea name="numbers"></textarea> <!-- ��� ��������� - ��� ������ � post -->
    <br>
    <button type="submit">Send</button>
</form>
<hr>
<?= join(' ', $numbers) ?>