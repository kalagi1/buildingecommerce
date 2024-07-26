<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('iban_tr', function ($attribute, $value, $parameters, $validator) {
            // İban başında "TR" kontrolü yapılacak
            return substr($value, 0, 2) === 'TR';
        });

        Validator::replacer('iban_tr', function ($message, $attribute, $rule, $parameters) {
            // Hata mesajı özelleştirilebilir, isteğe bağlı olarak
            return str_replace(':attribute', $attribute, 'IBAN numarası başında "TR" olmalıdır.');
        });
        // 'name' alanı için özelleştirilmiş hata mesajları
        Validator::replacer('required', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });

        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':attribute', ':max'], [$attribute, $parameters[0]], $message);
        });

        Validator::replacer('string', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });

        // 'iban' alanı için özelleştirilmiş hata mesajları
        Validator::replacer('iban.required', function ($message, $attribute, $rule, $parameters) {
            return 'IBAN alanı zorunludur.';
        });

        Validator::replacer('iban.string', function ($message, $attribute, $rule, $parameters) {
            return 'IBAN metin olmalıdır.';
        });

        Validator::replacer('iban.max', function ($message, $attribute, $rule, $parameters) {
            return 'IBAN en fazla :max karakter olabilir.';
        });

        Validator::replacer('url', function ($message, $attribute, $rule, $parameters) {
            return 'Web sitesi geçerli bir URL olmalıdır.';
        });

    //      // 'phone_number' alanı için Türkiye sabit telefon alan kodları kontrolü
    // Validator::extend('turkey_phone', function ($attribute, $value, $parameters, $validator) {
    //     $turkey_area_codes = [
    //         '212', '216', '222', '224', '232', '242', '252', '262', '272', '282', '312', '322', '324', '326', '342', 
    //         '352', '362', '372', '382', '388', '412', '422', '432', '442', '454', '462', '464', '472', '474', '482', 
    //         '484', '506', '507', '531', '533', '534', '535', '536', '537', '538', '539', '542', '543', '544', '545', 
    //         '546', '551', '552', '553', '554', '555', '561'
    //     ];

    //     $phone_number = str_replace([' ', '(', ')', '-'], '', $value); // Remove any formatting
    //     if (strlen($phone_number) >= 10) {
    //         $area_code = substr($phone_number, 0, 3);
    //         return in_array($area_code, $turkey_area_codes);
    //     }
    //     return false;
    // });

    // Validator::replacer('turkey_phone', function ($message, $attribute, $rule, $parameters) {
    //     return 'Sabit Telefon numarası geçerli bir Türkiye sabit telefon alan kodu ile başlamalıdır.';
    // });

    Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
        if ($rule === 'max') {
            return 'Sabit telefon numarası en fazla 8 karakter olabilir.';
        }
    
        return str_replace(':attribute', $attribute, $message);
    });

    }
  /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}