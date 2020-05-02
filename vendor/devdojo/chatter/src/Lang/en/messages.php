<?php

return [
    'words' => [
        'cancel'  => 'Vissza',
        'delete'  => 'Törlés',
        'edit'    => 'Szerkesztés',
        'yes'     => 'Igen',
        'no'      => 'Nem',
        'minutes' => '1 perccel ezelőtt| :count minutes',
    ],

    'discussion' => [
        'new'          => 'Új '.trans('chatter::intro.titles.discussion'),
        'all'          => 'Összes '.trans('chatter::intro.titles.discussion'),
        'create'       => 'Készíts '.trans('chatter::intro.titles.discussion'),
        'posted_by'    => 'Megjelenítve általa:',
        'head_details' => 'Megjelenítve ebben a kategóriában:',

    ],
    'response' => [
        'confirm'     => 'Biztosan törölni akarod ezt a választ?',
        'yes_confirm' => 'Igen',
        'no_confirm'  => 'Nem',
        'submit'      => 'Válasz küldés',
        'update'      => 'Válasz módosítása',
    ],

    'editor' => [
        'title'               => 'Cím '.trans('chatter::intro.titles.discussion'),
        'select'              => 'Válassz egy kategóriát',
        'tinymce_placeholder' => 'Írd be '.trans('chatter::intro.titles.discussion').' ide...',
        'select_color_text'   => 'Válassz egy színt '.trans('chatter::intro.titles.discussion').' (opcionális)',
    ],

    'email' => [
        'notify' => 'Értesíts, ha van válasz',
    ],

    'auth' => 'Please <a href="/:home/login">login</a>
                or <a href="/:home/register">register</a>
                to leave a response.',

];
