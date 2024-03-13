@php
     if (!function_exists('convertMonthToTurkishCharacter')) {
            function convertMonthToTurkishCharacter($date)
            {
                $aylar = [
                    'January' => 'Ocak',
                    'February' => 'Şubat',
                    'March' => 'Mart',
                    'April' => 'Nisan',
                    'May' => 'Mayıs',
                    'June' => 'Haziran',
                    'July' => 'Temmuz',
                    'August' => 'Ağustos',
                    'September' => 'Eylül',
                    'October' => 'Ekim',
                    'November' => 'Kasım',
                    'December' => 'Aralık',
                    'Monday' => 'Pazartesi',
                    'Tuesday' => 'Salı',
                    'Wednesday' => 'Çarşamba',
                    'Thursday' => 'Perşembe',
                    'Friday' => 'Cuma',
                    'Saturday' => 'Cumartesi',
                    'Sunday' => 'Pazar',
                    'Jan' => 'Oca',
                    'Feb' => 'Şub',
                    'Mar' => 'Mar',
                    'Apr' => 'Nis',
                    'May' => 'May',
                    'Jun' => 'Haz',
                    'Jul' => 'Tem',
                    'Aug' => 'Ağu',
                    'Sep' => 'Eyl',
                    'Oct' => 'Eki',
                    'Nov' => 'Kas',
                    'Dec' => 'Ara',
                ];
                return strtr($date, $aylar);
            }
        }
@endphp
@foreach ($housings as $housing)
    @php($sold = $housing->sold)

    <div class="col-md-3">
        <x-housing-card :housing="$housing" :sold="$sold" />
    </div>
@endforeach
