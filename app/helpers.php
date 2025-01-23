<?php

use App\Http\Controllers\Controller;

if (!function_exists('show_currency_name')) {
    function show_currency_name($currency)
    {
        $names=array (
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'BA Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HRK' => 'Croatian Kuna',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        );
        return $names[$currency];
    }
}
if (!function_exists('show_currency_price')) {
    function show_currency_price($number, $class = null, $currency_init = null)
    {
        if ($currency_init) {
            $currency = Controller::getCurrencies()[$currency_init];
            $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/1;
//            $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/$currency["jedinica"];
            $number = $number * $tecaj;
        }
        $currency = session()->get("currency", Controller::getCurrencies()["EUR"]);
        $prodajni = str_replace(",", ".", $currency["prodajni_tecaj"]) / 1;
//        $prodajni = str_replace(",", ".", $currency["prodajni_tecaj"]) / $currency["jedinica"];
        $output = $number * $prodajni;
        $output = number_format($output, 0, ",", ".");
        return '<span ' . ($class ? 'class="' . $class . '"' : '') . ' data-hrk="' . $number . '">' . $output . ' ' . $currency["valuta"] . '</span>';
    }
}

if (!function_exists('show_range_price')) {
    function show_range_price($min,$max,$currency_init = null)
    {
        $id="price-range";
        if ($currency_init) {
            $currency = Controller::getCurrencies()[$currency_init];
            $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/1;
//            $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/$currency["jedinica"];
            $min = $min * $tecaj;
            $max = $max * $tecaj;
        }
        $currency = session()->get("currency", Controller::getCurrencies()["EUR"]);
        $prodajni = str_replace(",", ".", $currency["prodajni_tecaj"]) / 1;
//        $prodajni = str_replace(",", ".", $currency["prodajni_tecaj"]) / $currency["jedinica"];
        $output_min = number_format($min / $prodajni/1/100,0)*1*100;
//        $output_min = number_format($min / $prodajni/$currency["jedinica"]/100,0)*$currency["jedinica"]*100;
        $output_max = number_format($max / $prodajni/1/100,0)*1*100;
//        $output_max = number_format($max / $prodajni/$currency["jedinica"]/100,0)*$currency["jedinica"]*100;
        $output_step= 1*50;
//        $output_step= $currency["jedinica"]*50;
        return '<div data-hrk-min="'.$min.'" data-step="'.$output_step.'" data-hrk-max="'.$max.'" data-min="'.$output_min.'" data-max="'.$output_max.'" data-from="'.$output_min.'" data-to="'.$output_max.'" data-hrk-from="'.$min.'" data-hrk-to="'.$max.'" data-currency="'.$currency["valuta"].'" data-currency_value="'.$prodajni.'"
                         ' . ($id ? 'id="' . $id . '"' : '') . '></div>';
    }
}

if (!function_exists('hrk_to_eur')) {
    function hrk_to_eur($hrk)
    {

        $currency = Controller::getCurrencies()["EUR"];
        $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/1;
//        $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/$currency["jedinica"];
        return $hrk / $tecaj;
    }
}
if (!function_exists('eur_to_hrk')) {
    function eur_to_hrk($eur)
    {

        $currency = Controller::getCurrencies()["EUR"];
        $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/1;
//        $tecaj = str_replace(",", ".", $currency["prodajni_tecaj"])/$currency["jedinica"];
        return $eur * $tecaj;
    }
}

if (!function_exists('date_to_user')) {
    function date_to_user($date)
    {
        return date("F d, Y",strtotime($date));
    }
}
