<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            0 => array ('country_code' => 'AF','country_name' => 'Afghanistan',),
            1 => array ('country_code' => 'AL','country_name' => 'Albania', ),
            2 => array ('country_code' => 'DZ','country_name' => 'Algeria', ),
            3 => array ('country_code' => 'AS','country_name' => 'American Samoa', ),
            4 => array ('country_code' => 'AD','country_name' => 'Andorra', ),
            5 => array ('country_code' => 'AO','country_name' => 'Angola', ),
            6 => array ('country_code' => 'AI','country_name' => 'Anguilla', ),
            7 => array ('country_code' => 'AQ','country_name' => 'Antarctica', ),
            8 => array ('country_code' => 'AG','country_name' => 'Antigua And Barbuda', ),
            9 => array ('country_code' => 'AR','country_name' => 'Argentina', ),
            10 => array ('country_code' => 'AM','country_name' => 'Armenia', ),
            11 => array ('country_code' => 'AW','country_name' => 'Aruba', ),
            12 => array ('country_code' => 'AU','country_name' => 'Australia', ),
            13 => array ('country_code' => 'AT','country_name' => 'Austria', ),
            14 => array ('country_code' => 'AZ','country_name' => 'Azerbaijan', ),
            15 => array ('country_code' => 'BS','country_name' => 'Bahamas The', ),
            16 => array ('country_code' => 'BH','country_name' => 'Bahrain', ),
            17 => array ('country_code' => 'BD','country_name' => 'Bangladesh', ),
            18 => array ('country_code' => 'BB','country_name' => 'Barbados', ),
            19 => array ('country_code' => 'BY','country_name' => 'Belarus', ),
            20 => array ('country_code' => 'BE','country_name' => 'Belgium', ),
            21 => array ('country_code' => 'BZ','country_name' => 'Belize', ),
            22 => array ('country_code' => 'BJ','country_name' => 'Benin', ),
            23 => array ('country_code' => 'BM','country_name' => 'Bermuda', ),
            24 => array ('country_code' => 'BT','country_name' => 'Bhutan', ),
            25 => array ('country_code' => 'BO','country_name' => 'Bolivia', ),
            26 => array ('country_code' => 'BA','country_name' => 'Bosnia and Herzegovina', ),
            27 => array ('country_code' => 'BW','country_name' => 'Botswana', ),
            28 => array ('country_code' => 'BV','country_name' => 'Bouvet Island', ),
            29 => array ('country_code' => 'BR','country_name' => 'Brazil', ),
            30 => array ('country_code' => 'IO','country_name' => 'British Indian Ocean Territory', ),
            31 => array ('country_code' => 'BN','country_name' => 'Brunei', ),
            32 => array ('country_code' => 'BG','country_name' => 'Bulgaria', ),
            33 => array ('country_code' => 'BF','country_name' => 'Burkina Faso', ),
            34 => array ('country_code' => 'BI','country_name' => 'Burundi', ),
            35 => array ('country_code' => 'KH','country_name' => 'Cambodia', ),
            36 => array ('country_code' => 'CM','country_name' => 'Cameroon', ),
            37 => array ('country_code' => 'CA','country_name' => 'Canada', ),
            38 => array ('country_code' => 'CV','country_name' => 'Cape Verde', ),
            39 => array ('country_code' => 'KY','country_name' => 'Cayman Islands', ),
            40 => array ('country_code' => 'CF','country_name' => 'Central African Republic', ),
            41 => array ('country_code' => 'TD','country_name' => 'Chad', ),
            42 => array ('country_code' => 'CL','country_name' => 'Chile', ),
            43 => array ('country_code' => 'CN','country_name' => 'China', ),
            44 => array ('country_code' => 'CX','country_name' => 'Christmas Island', ),
            45 => array ('country_code' => 'CC','country_name' => 'Cocos (Keeling) Islands', ),
            46 => array ('country_code' => 'CO','country_name' => 'Colombia', ),
            47 => array ('country_code' => 'KM','country_name' => 'Comoros', ),
            48 => array ('country_code' => 'CG','country_name' => 'Congo', ),
            49 => array ('country_code' => 'CD','country_name' => 'Congo The Democratic Republic Of The', ),
            50 => array ('country_code' => 'CK','country_name' => 'Cook Islands', ),
            51 => array ('country_code' => 'CR','country_name' => 'Costa Rica', ),
            52 => array ('country_code' => 'CI','country_name' => 'Cote D\'Ivoire (Ivory Coast)', ),
            53 => array ('country_code' => 'HR','country_name' => 'Croatia (Hrvatska)', ),
            54 => array ('country_code' => 'CU','country_name' => 'Cuba', ),
            55 => array ('country_code' => 'CY','country_name' => 'Cyprus', ),
            56 => array ('country_code' => 'CZ','country_name' => 'Czech Republic', ),
            57 => array ('country_code' => 'DK','country_name' => 'Denmark', ),
            58 => array ('country_code' => 'DJ','country_name' => 'Djibouti', ),
            59 => array ('country_code' => 'DM','country_name' => 'Dominica', ),
            60 => array ('country_code' => 'DO','country_name' => 'Dominican Republic', ),
            61 => array ('country_code' => 'TP','country_name' => 'East Timor', ),
            62 => array ('country_code' => 'EC','country_name' => 'Ecuador', ),
            63 => array ('country_code' => 'EG','country_name' => 'Egypt', ),
            64 => array ('country_code' => 'SV','country_name' => 'El Salvador', ),
            65 => array ('country_code' => 'GQ','country_name' => 'Equatorial Guinea', ),
            66 => array ('country_code' => 'ER','country_name' => 'Eritrea', ),
            67 => array ('country_code' => 'EE','country_name' => 'Estonia', ),
            68 => array ('country_code' => 'ET','country_name' => 'Ethiopia', ),
            69 => array ('country_code' => 'XA','country_name' => 'External Territories of Australia', ),
            70 => array ('country_code' => 'FK','country_name' => 'Falkland Islands', ),
            71 => array ('country_code' => 'FO','country_name' => 'Faroe Islands', ),
            72 => array ('country_code' => 'FJ','country_name' => 'Fiji Islands', ),
            73 => array ('country_code' => 'FI','country_name' => 'Finland', ),
            74 => array ('country_code' => 'FR','country_name' => 'France', ),
            75 => array ('country_code' => 'GF','country_name' => 'French Guiana', ),
            76 => array ('country_code' => 'PF','country_name' => 'French Polynesia', ),
            77 => array ('country_code' => 'TF','country_name' => 'French Southern Territories', ),
            78 => array ('country_code' => 'GA','country_name' => 'Gabon', ),
            79 => array ('country_code' => 'GM','country_name' => 'Gambia The', ),
            80 => array ('country_code' => 'GE','country_name' => 'Georgia', ),
            81 => array ('country_code' => 'DE','country_name' => 'Germany', ),
            82 => array ('country_code' => 'GH','country_name' => 'Ghana', ),
            83 => array ('country_code' => 'GI','country_name' => 'Gibraltar', ),
            84 => array ('country_code' => 'GR','country_name' => 'Greece', ),
            85 => array ('country_code' => 'GL','country_name' => 'Greenland', ),
            86 => array ('country_code' => 'GD','country_name' => 'Grenada', ),
            87 => array ('country_code' => 'GP','country_name' => 'Guadeloupe', ),
            88 => array ('country_code' => 'GU','country_name' => 'Guam', ),
            89 => array ('country_code' => 'GT','country_name' => 'Guatemala', ),
            90 => array ('country_code' => 'XU','country_name' => 'Guernsey and Alderney', ),
            91 => array ('country_code' => 'GN','country_name' => 'Guinea', ),
            92 => array ('country_code' => 'GW','country_name' => 'Guinea-Bissau', ),
            93 => array ('country_code' => 'GY','country_name' => 'Guyana', ),
            94 => array ('country_code' => 'HT','country_name' => 'Haiti', ),
            95 => array ('country_code' => 'HM','country_name' => 'Heard and McDonald Islands', ),
            96 => array ('country_code' => 'HN','country_name' => 'Honduras', ),
            97 => array ('country_code' => 'HK','country_name' => 'Hong Kong S.A.R.', ),
            98 => array ('country_code' => 'HU','country_name' => 'Hungary', ),
            99 => array ('country_code' => 'IS','country_name' => 'Iceland', ),
            100 => array ('country_code' => 'IN','country_name' => 'India', ),
            101 => array ('country_code' => 'ID','country_name' => 'Indonesia', ),
            102 => array ('country_code' => 'IR','country_name' => 'Iran', ),
            103 => array ('country_code' => 'IQ','country_name' => 'Iraq', ),
            104 => array ('country_code' => 'IE','country_name' => 'Ireland', ),
            105 => array ('country_code' => 'IL','country_name' => 'Israel', ),
            106 => array ('country_code' => 'IT','country_name' => 'Italy', ),
            107 => array ('country_code' => 'JM','country_name' => 'Jamaica', ),
            108 => array ('country_code' => 'JP','country_name' => 'Japan', ),
            109 => array ('country_code' => 'XJ','country_name' => 'Jersey', ),
            110 => array ('country_code' => 'JO','country_name' => 'Jordan', ),
            111 => array ('country_code' => 'KZ','country_name' => 'Kazakhstan', ),
            112 => array ('country_code' => 'KE','country_name' => 'Kenya', ),
            113 => array ('country_code' => 'KI','country_name' => 'Kiribati', ),
            114 => array ('country_code' => 'KP','country_name' => 'Korea North', ),
            115 => array ('country_code' => 'KR','country_name' => 'Korea South', ),
            116 => array ('country_code' => 'KW','country_name' => 'Kuwait', ),
            117 => array ('country_code' => 'KG','country_name' => 'Kyrgyzstan', ),
            118 => array ('country_code' => 'LA','country_name' => 'Laos', ),
            119 => array ('country_code' => 'LV','country_name' => 'Latvia', ),
            120 => array ('country_code' => 'LB','country_name' => 'Lebanon', ),
            121 => array ('country_code' => 'LS','country_name' => 'Lesotho', ),
            122 => array ('country_code' => 'LR','country_name' => 'Liberia', ),
            123 => array ('country_code' => 'LY','country_name' => 'Libya', ),
            124 => array ('country_code' => 'LI','country_name' => 'Liechtenstein', ),
            125 => array ('country_code' => 'LT','country_name' => 'Lithuania', ),
            126 => array ('country_code' => 'LU','country_name' => 'Luxembourg', ),
            127 => array ('country_code' => 'MO','country_name' => 'Macau S.A.R.', ),
            128 => array ('country_code' => 'MK','country_name' => 'Macedonia', ),
            129 => array ('country_code' => 'MG','country_name' => 'Madagascar', ),
            130 => array ('country_code' => 'MW','country_name' => 'Malawi', ),
            131 => array ('country_code' => 'MY','country_name' => 'Malaysia', ),
            132 => array ('country_code' => 'MV','country_name' => 'Maldives', ),
            133 => array ('country_code' => 'ML','country_name' => 'Mali', ),
            134 => array ('country_code' => 'MT','country_name' => 'Malta', ),
            135 => array ('country_code' => 'XM','country_name' => 'Man (Isle of)', ),
            136 => array ('country_code' => 'MH','country_name' => 'Marshall Islands', ),
            137 => array ('country_code' => 'MQ','country_name' => 'Martinique', ),
            138 => array ('country_code' => 'MR','country_name' => 'Mauritania', ),
            139 => array ('country_code' => 'MU','country_name' => 'Mauritius', ),
            140 => array ('country_code' => 'YT','country_name' => 'Mayotte', ),
            141 => array ('country_code' => 'MX','country_name' => 'Mexico', ),
            142 => array ('country_code' => 'FM','country_name' => 'Micronesia', ),
            143 => array ('country_code' => 'MD','country_name' => 'Moldova', ),
            144 => array ('country_code' => 'MC','country_name' => 'Monaco', ),
            145 => array ('country_code' => 'MN','country_name' => 'Mongolia', ),
            146 => array ('country_code' => 'MS','country_name' => 'Montserrat', ),
            147 => array ('country_code' => 'MA','country_name' => 'Morocco', ),
            148 => array ('country_code' => 'MZ','country_name' => 'Mozambique', ),
            149 => array ('country_code' => 'MM','country_name' => 'Myanmar', ),
            150 => array ('country_code' => 'NA','country_name' => 'Namibia', ),
            151 => array ('country_code' => 'NR','country_name' => 'Nauru', ),
            152 => array ('country_code' => 'NP','country_name' => 'Nepal', ),
            153 => array ('country_code' => 'AN','country_name' => 'Netherlands Antilles', ),
            154 => array ('country_code' => 'NL','country_name' => 'Netherlands The', ),
            155 => array ('country_code' => 'NC','country_name' => 'New Caledonia', ),
            156 => array ('country_code' => 'NZ','country_name' => 'New Zealand', ),
            157 => array ('country_code' => 'NI','country_name' => 'Nicaragua', ),
            158 => array ('country_code' => 'NE','country_name' => 'Niger', ),
            159 => array ('country_code' => 'NG','country_name' => 'Nigeria', ),
            160 => array ('country_code' => 'NU','country_name' => 'Niue', ),
            161 => array ('country_code' => 'NF','country_name' => 'Norfolk Island', ),
            162 => array ('country_code' => 'MP','country_name' => 'Northern Mariana Islands', ),
            163 => array ('country_code' => 'NO','country_name' => 'Norway', ),
            164 => array ('country_code' => 'OM','country_name' => 'Oman', ),
            165 => array ('country_code' => 'PK','country_name' => 'Pakistan', ),
            166 => array ('country_code' => 'PW','country_name' => 'Palau', ),
            167 => array ('country_code' => 'PS','country_name' => 'Palestinian Territory Occupied', ),
            168 => array ('country_code' => 'PA','country_name' => 'Panama', ),
            169 => array ('country_code' => 'PG','country_name' => 'Papua new Guinea', ),
            170 => array ('country_code' => 'PY','country_name' => 'Paraguay', ),
            171 => array ('country_code' => 'PE','country_name' => 'Peru', ),
            172 => array ('country_code' => 'PH','country_name' => 'Philippines', ),
            173 => array ('country_code' => 'PN','country_name' => 'Pitcairn Island', ),
            174 => array ('country_code' => 'PL','country_name' => 'Poland', ),
            175 => array ('country_code' => 'PT','country_name' => 'Portugal', ),
            176 => array ('country_code' => 'PR','country_name' => 'Puerto Rico', ),
            177 => array ('country_code' => 'QA','country_name' => 'Qatar', ),
            178 => array ('country_code' => 'RE','country_name' => 'Reunion', ),
            179 => array ('country_code' => 'RO','country_name' => 'Romania', ),
            180 => array ('country_code' => 'RU','country_name' => 'Russia', ),
            181 => array ('country_code' => 'RW','country_name' => 'Rwanda', ),
            182 => array ('country_code' => 'SH','country_name' => 'Saint Helena', ),
            183 => array ('country_code' => 'KN','country_name' => 'Saint Kitts And Nevis', ),
            184 => array ('country_code' => 'LC','country_name' => 'Saint Lucia', ),
            185 => array ('country_code' => 'PM','country_name' => 'Saint Pierre and Miquelon', ),
            186 => array ('country_code' => 'VC','country_name' => 'Saint Vincent And The Grenadines', ),
            187 => array ('country_code' => 'WS','country_name' => 'Samoa', ),
            188 => array ('country_code' => 'SM','country_name' => 'San Marino', ),
            189 => array ('country_code' => 'ST','country_name' => 'Sao Tome and Principe', ),
            190 => array ('country_code' => 'SA','country_name' => 'Saudi Arabia', ),
            191 => array ('country_code' => 'SN','country_name' => 'Senegal', ),
            192 => array ('country_code' => 'RS','country_name' => 'Serbia', ),
            193 => array ('country_code' => 'SC','country_name' => 'Seychelles', ),
            194 => array ('country_code' => 'SL','country_name' => 'Sierra Leone', ),
            195 => array ('country_code' => 'SG','country_name' => 'Singapore', ),
            196 => array ('country_code' => 'SK','country_name' => 'Slovakia', ),
            197 => array ('country_code' => 'SI','country_name' => 'Slovenia', ),
            198 => array ('country_code' => 'XG','country_name' => 'Smaller Territories of the UK', ),
            199 => array ('country_code' => 'SB','country_name' => 'Solomon Islands', ),
            200 => array ('country_code' => 'SO','country_name' => 'Somalia', ),
            201 => array ('country_code' => 'ZA','country_name' => 'South Africa', ),
            202 => array ('country_code' => 'GS','country_name' => 'South Georgia', ),
            203 => array ('country_code' => 'SS','country_name' => 'South Sudan', ),
            204 => array ('country_code' => 'ES','country_name' => 'Spain', ),
            205 => array ('country_code' => 'LK','country_name' => 'Sri Lanka', ),
            206 => array ('country_code' => 'SD','country_name' => 'Sudan', ),
            207 => array ('country_code' => 'SR','country_name' => 'Suriname', ),
            208 => array ('country_code' => 'SJ','country_name' => 'Svalbard And Jan Mayen Islands', ),
            209 => array ('country_code' => 'SZ','country_name' => 'Swaziland', ),
            210 => array ('country_code' => 'SE','country_name' => 'Sweden', ),
            211 => array ('country_code' => 'CH','country_name' => 'Switzerland', ),
            212 => array ('country_code' => 'SY','country_name' => 'Syria', ),
            213 => array ('country_code' => 'TW','country_name' => 'Taiwan', ),
            214 => array ('country_code' => 'TJ','country_name' => 'Tajikistan', ),
            215 => array ('country_code' => 'TZ','country_name' => 'Tanzania', ),
            216 => array ('country_code' => 'TH','country_name' => 'Thailand', ),
            217 => array ('country_code' => 'TG','country_name' => 'Togo', ),
            218 => array ('country_code' => 'TK','country_name' => 'Tokelau', ),
            219 => array ('country_code' => 'TO','country_name' => 'Tonga', ),
            220 => array ('country_code' => 'TT','country_name' => 'Trinidad And Tobago', ),
            221 => array ('country_code' => 'TN','country_name' => 'Tunisia', ),
            222 => array ('country_code' => 'TR','country_name' => 'Turkey', ),
            223 => array ('country_code' => 'TM','country_name' => 'Turkmenistan', ),
            224 => array ('country_code' => 'TC','country_name' => 'Turks And Caicos Islands', ),
            225 => array ('country_code' => 'TV','country_name' => 'Tuvalu', ),
            226 => array ('country_code' => 'UG','country_name' => 'Uganda', ),
            227 => array ('country_code' => 'UA','country_name' => 'Ukraine', ),
            228 => array ('country_code' => 'AE','country_name' => 'United Arab Emirates', ),
            229 => array ('country_code' => 'GB','country_name' => 'United Kingdom', ),
            230 => array ('country_code' => 'US','country_name' => 'United States', ),
            231 => array ('country_code' => 'UM','country_name' => 'United States Minor Outlying Islands', ),
            232 => array ('country_code' => 'UY','country_name' => 'Uruguay', ),
            233 => array ('country_code' => 'UZ','country_name' => 'Uzbekistan', ),
            234 => array ('country_code' => 'VU','country_name' => 'Vanuatu', ),
            235 => array ('country_code' => 'VA','country_name' => 'Vatican City State (Holy See)', ),
            236 => array ('country_code' => 'VE','country_name' => 'Venezuela', ),
            237 => array ('country_code' => 'VN','country_name' => 'Vietnam', ),
            238 => array ('country_code' => 'VG','country_name' => 'Virgin Islands (British)', ),
            239 => array ('country_code' => 'VI','country_name' => 'Virgin Islands (US)', ),
            240 => array ('country_code' => 'WF','country_name' => 'Wallis And Futuna Islands', ),
            241 => array ('country_code' => 'EH','country_name' => 'Western Sahara', ),
            242 => array ('country_code' => 'YE','country_name' => 'Yemen', ),
            243 => array ('country_code' => 'YU','country_name' => 'Yugoslavia', ),
            244 => array ('country_code' => 'ZM','country_name' => 'Zambia', ),
            245 => array ('country_code' => 'ZW','country_name' => 'Zimbabwe', ),
        ]);
    }
}