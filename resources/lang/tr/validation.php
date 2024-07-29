<?php


return [
    'custom' => [
        'name' => [
            'required' => 'Ad soyad alanı zorunludur.',
            'string' => 'Ad soyad metin olmalıdır.',
            'max' => 'Ad soyad en fazla :max karakter olabilir.',
        ],
        'iban' => [
            'required' => 'IBAN alanı zorunludur.',
            'string' => 'IBAN metin olmalıdır.',
            'max' => 'IBAN en fazla :max karakter olabilir.',
        ],
    ],

];