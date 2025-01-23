<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => 'My Croatia Cruise',
    'subject'               => 'Cruise',
    'keywords'              => '',
    'setAutoTopMargin'      => 'stretch',
    'setAutoBottomMargin'      => 'stretch',
    'creator'               => 'My Croatia Cruise',
    'display_mode'          => 'fullpage',
    'tempDir'               => base_path('storage/temp/'),
    'font_path' => base_path('resources/fonts/'),
    'margin_left'           => 0,
    'margin_right'          => 0,
    'margin_top'            => 0,
    'margin_bottom'         => 0,
    'margin_header'         => 0,
    'margin_footer'         => 0,
    'font_data' => [
        'montserratsb' => [
            'R'  => 'Montserrat-SemiBold.ttf',    // regular font
            'B'  => 'Montserrat-SemiBold.ttf',       // optional: bold font
//            'I'  => 'ExampleFont-Italic.ttf',     // optional: italic font
//            'BI' => 'ExampleFont-Bold-Italic.ttf' // optional: bold-italic font
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ],
        'montserrat' => [
            'R'  => 'Montserrat-Regular.ttf',    // regular font
            'B'  => 'Montserrat-Bold.ttf',       // optional: bold font
            'I'  => 'Montserrat-Italic.ttf',     // optional: italic font
            'BI' => 'Montserrat-BoldItalic.ttf' // optional: bold-italic font
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ],
        // ...add as many as you want.
    ]
];
