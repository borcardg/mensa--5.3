<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => 'UniFR',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'Laravel Pdf',
    'display_mode'          => 'fullpage',
    'tempDir'               => base_path('../temp/'),
    'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'examplefont' => [
            'R'  => 'OpenSans-Regular.ttf',    // regular font
            'B'  => 'OpenSans-Bold.ttf',       // optional: bold font
            'I'  => 'OpenSans-Italic.ttf',     // optional: italic font
            'BI' => 'OpenSans-BoldItalic.ttf', // optional: bold-italic font
        ],
    ],
];
