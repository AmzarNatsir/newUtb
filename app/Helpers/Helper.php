<?
namespace App\Helpers;

Class Helper 
{
    static function getListMonth()
    {
        $arr_month = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        return $arr_month;
    }

    static function getHariIndonesia($hari)
    {
        switch ($hari) {
            case 'Sunday' || 'Sun':
                return 'Minggu';
              case 'Monday' || 'Mon':
                return 'Senin';
              case 'Tuesday' || 'Tue':
                return 'Selasa';
              case 'Wednesday' || 'Wen':
                return 'Rabu';
              case 'Thursday' || 'Thu':
                return 'Kamis';
              case 'Friday' || 'Fri':
                return 'Jumat';
              case 'Saturday' || 'Sat':
                return 'Sabtu';
              default:
                return 'hari tidak valid';
        }
    }

    static function getBulanIndonesia($bulan)
    {
        switch ((int)$bulan) {
            case '1':
                return 'Januari';
            case '2':
                return 'Februari';
            case '3':
                return 'Maret';
            case '4':
                return 'April';
            case '5':
                return 'Mei';
            case '6':
                return 'Juni';
            case '7':
                return 'Juli';
            case '8':
                return 'Agustus';
            case '9':
                return 'September';
            case '10':
                return 'Oktober';
            case '11':
                return 'November';
            case '12':
                return 'Desember';
            default:
                return 'Bulan tidak valid';
        }
    }
} 