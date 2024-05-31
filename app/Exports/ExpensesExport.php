<?php

namespace App\Exports;

use App\Models\ExpenseExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExpensesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ExpenseExport::all();
    }


    public function headings(): array
    {
        return [
           'No', 'İsim Soyisim', 'E-posta', 'Telefon', 'İban Sahibi Adı', 'IBAN', 'Hesap Türü', 'Tutar', 'Ödeme Durumu', 'Sipariş No', 'Sipariş Tarihi' ,'Oluşturma tarihi', 'Güncelleme Tarihi'
        ];
    }
}
