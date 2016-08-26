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
        'risk_level' => 30,
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
    'blank_icon' => 'images/img_blank.gif',
    'place_holders' => [
        'title' => 'Your Event title',
        'content' => 'Your Event content',
        'event_time' => 'Your Event time',
        'choose_one' => '-- Choose one --',
    ],
    'extra_day' => 3,
    'score' => [
        'win' => 3,
        'draw' => 1,
        'lose' => 0,
    ],
    'post' => [
        'is_published' => 1,
        'un_published' => 0,
        'limit' => 1,
    ],
    'top_user_bet_quantity' => 4,
    'message' => [
        'type' => [
            'match_start' => 0,
            'match_end' => 1,
            'user_bet' => 2,
            'comment_reply' => 3,
            'user_event' => 4,
        ],
        'check_time' => 10,
        'user_message_limit' => 5,
    ],
    'notification' => [
        'no' => 0,
        'yes' => 1,
    ],
    'comment' => [
        'commentable_type' => [
            'post_id' => 0,
        ],
    ],
    'football' => [
        'default_image' => 'images/football.png',
    ],
    'bet' => [
        'score_ratio' => 2,
        'win' => 1,
        'lose' => 0,
    ],
    'user_bet' => [
        'result' => [
            'win' => 1,
            'lose' => 0,
        ],
        'point' => [
            'win' => 2,
            'lose' => 0,
        ],
        'label_result' => [
            'win' => 'win',
            'lose' => 'lose',
        ],
    ],
    'match' => [
        'recent_match_time' => 4320,
    ],
];
