<?php
return [
    'user' => [
        'avatar_path' => 'upload/',
        'default_avatar' => 'images/default.png',
        'user_limit' => 30,
        'role' => [
            'user' => 0,
            'team' => 1,
            'admin' => 2,
        ],
        'confirmed' => [
            'is_confirm' => 1,
            'not_confirm' => 0,
        ],
        'confirmation_code' => [
            'length' => 10,
        ],
    ],
    'player' => [
        'role' => [
            'footballer' => 0,
            'coach' => 1,
        ],
    ],
    'limit' => [
        'page_limit' => 10,
        'name_max' => 60,
        'description_max' => 60000,
        'image_size' => 5000,
        'number_min' => 0,
        'number_max' => 200,
        'place_max' => 200,
        'title_max' => 250,
        'content_max' => 60000,
    ],
    'blank_icon' => asset('images/img_blank.gif'),
    'place_holders' => [
        'title' => 'Your Event title',
        'content' => 'Your Event content',
        'event_time' => 'Your Event time',
        'choose_one' => '-- Choose one --'
    ],
];
