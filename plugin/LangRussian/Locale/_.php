<?php declare(strict_types=1);

return array_merge(
    require_once 'cup.catalog.php',
    require_once 'cup.category.php',
    require_once 'cup.editor.php',
    require_once 'cup.file.php',
    require_once 'cup.form.php',
    require_once 'cup.guestbook.php',
    require_once 'cup.main.php',
    require_once 'cup.navigation.php',
    require_once 'cup.page.php',
    require_once 'cup.parameter.php',
    require_once 'cup.publication.php',
    require_once 'cup.user.php',

    require_once 'exception.php',
    require_once 'other.php',
);
