<?php

return [
    'GENDER' => [
        'Male' => 0,
        'Female' => 1,
    ],
    'STUDENT_STATUS' => [
        'STUDYING' => 0,
        'STOPPED' => 1,
        'EXPELLED' => 2,
    ],
    'PHONE_NUMBER_TYPE' => [
        'VIETTEL' => 'Viettel',
        'MOBILEFONE' => 'Mobilefone',
        'VINAPHONE' => 'Vinaphone',
    ],
    'PHONE_PREFIX' => [
        'VIETTEL' => '^(098|097|096)\d{7}$',
        'MOBILEFONE' => '^(091|094)\d{7}$',
        'VINAPHONE' => '^(090|093)\d{7}$',
    ],
    'PER_PAGE' => [
        10 => 10,
        50 => 50,
        100 => 100,
        500 => 500,
        1000 => 1000,
        3000 => 3000,
        5000 => 5000,
        10000 => 10000,
    ],
    'AVG_SCORE' => 5,
];

