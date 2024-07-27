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
    'reset' => 'Şifreniz sıfırlandı!',
    'sent' => 'Şifre sıfırlama bağlantınız e-posta ile gönderildi!',
    'throttled' => 'Lütfen tekrar denemeden önce bekleyin.',
    'token' => 'Bu şifre sıfırlama kodu geçersiz.',
    'user' => 'Bu e-posta adresine sahip bir kullanıcı bulunamadı.',
];