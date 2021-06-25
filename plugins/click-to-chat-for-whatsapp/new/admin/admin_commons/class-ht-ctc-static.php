<?php
/**
 * Static values
 * 
 *  country codes
 * 
 * @included - as of now directly at admin-main-page.php
 */


if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Static' ) ) :

class HT_CTC_Static {

    // Country code list - uses as datalayer at admin whatsapp number country code field
    // todo - make as an associative array in duplicate country codes..
    static $cc = array(
        '93' => 'Afghanistan (AF)',
        '355' => 'Albania (AL)',
        '213' => 'Algeria (DZ)',
        '1684' => 'American Samoa (AS)',
        '376' => 'Andorra (AD)',
        '244' => 'Angola (AO)',
        '1264' => 'Anguilla (AI)',
        '1268' => 'Antigua and Barbuda (AG)',
        '54' => 'Argentina (AR)',
        '374' => 'Armenia (AM)',
        '297' => 'Aruba (AW)',
        '247' => 'Ascension Island (AC)',
        
        '64' => array('Antarctica (AQ)', 'New Zealand (NZ)'),
        '672' => array('Antarctica (AQ)', 'Norfolk Island (NF)' ),
        '61' => array('Australia (AU)', 'Christmas Island (CX)', 'Cocos(Keeling) Islands (CC)' ),
        
        '43' => 'Austria (AT)',
        '994' => 'Azerbaijan (AZ)',
        '1242' => 'Bahamas (BS)',
        '973' => 'Bahrain (BH)',
        '880' => 'Bangladesh (BD)',
        '1246' => 'Barbados (BB)',
        '375' => 'Belarus (BY)',
        '32' => 'Belgium (BE)',
        '501' => 'Belize (BZ)',
        '229' => 'Benin (BJ)',
        '1441' => 'Bermuda (BM)',
        '975' => 'Bhutan (BT)',
        '591' => 'Bolivia (BO)',
        '387' => 'Bosnia and Herzegovina (BA)',
        '267' => 'Botswana (BW)',
        '55' => 'Brazil (BR)',
        '1284' => 'British Virgin Islands (VG)',
        '673' => 'Brunei (BN)',
        '359' => 'Bulgaria (BG)',
        '226' => 'Burkina Faso (BF)',
        '95' => 'Burma (Myanmar) (MM)',
        '257' => 'Burundi (BI)',
        '855' => 'Cambodia (KH)',
        '237' => 'Cameroon (CM)',
        '1' => 'Canada (CA)',
        '238' => 'Cape Verde (CV)',
        '1345' => 'Cayman Islands (KY)',
        '236' => 'Central African Republic (CF)',
        '235' => 'Chad (TD)',
        '56' => 'Chile (CL)',
        '86' => 'China (CN)',
        
        '57' => 'Colombia (CO)',
        '269' => 'Comoros (KM)',
        '242' => 'Congo (CG)',
        '682' => 'Cook Islands (CK)',
        '506' => 'Costa Rica (CR)',
        '385' => 'Croatia (HR)',
        '53' => 'Cuba (CU)',
        '357' => ' Cyprus (CY)',
        '420' => 'Czech Republic (CZ)',
        '243' => 'Republic of the Congo (CD)',
        '45' => 'Denmark (DK)',
        '246' => 'Diego Garcia (DG/DGA)',
        '253' => 'Djibouti (DJ)',
        '1767' => 'Dominica (DM)',
        '1809' => ' Dominican Republic (DO)',
        '1829' => ' Dominican Republic (DO)',
        '1849' => ' Dominican Republic (DO)',
        '593' => 'Ecuador (EC)',
        '20' => 'Egypt (EG)',
        '503' => 'El Salvador (SV)',
        '240' => 'Equatorial Guinea (GQ)',
        '291' => ' Eritrea (ER)',
        '372' => 'Estonia (EE)',
        '251' => 'Ethiopia (ET)',
        '500' => 'Falkland Islands (FK)',
        '298' => 'Faroe Islands (FO)',
        '679' => 'Fiji (FJ)',
        '358' => 'Finland (FI)',
        '33' => 'France (FR)',
        '594' => 'French Guiana (GF)',
        '689' => 'French Polynesia (PF)',
        '241' => 'Gabon (GA)',
        '220' => 'Gambia (GM)',
        '995' => 'Georgia (GE)',
        '49' => 'Germany (DE)',
        '233' => 'Ghana (GH)',
        '350' => 'Gibraltar (GI)',
        '30' => 'Greece (GR)',
        '299' => 'Greenland (GL)',
        '1473' => 'Grenada (GD)',
        '590' => 'Guadeloupe (GP)',
        '1671'  =>  'Guam (GU)',
        '502'   =>  'Guatemala (GT)',
        '224'   =>  'Guinea (GN)',
        '245'   =>  'Guinea-Bissau (GW)',
        '592'   =>  'Guyana (GY)',
        '509'   =>  'Haiti (HT)',
        '39'    =>  'Holy See (Vatican City)(VA)',
        '504'   =>  'Honduras (HN)',
        '852'   =>  'Hong Kong (HK)',
        '36'    =>  'Hungary (HU)',
        '354'   =>  'Iceland (IS)',
        '91'    =>  'India (Bharat)',
        '62'    =>  'Indonesia (ID)',
        '98'    =>  'Iran (IR)',
        '964'   =>  'Iraq (IQ)',
        '353'   =>  'Ireland (IE)',
        '44'    =>  'Isle of Man (IM)',
        '972'   =>  'Israel (IL)',
        '39'    =>  'Italy (IT)',
        '225'   =>  'Ivory Coast(CÃ´te d\'Ivoire)(CI)',
        '1876'  =>  'Jamaica (JM)',
        '81'    =>  'Japan (JP)',
        '44'    =>  'Jersey (JE)',
        '962'   =>  'Jordan (JO)',
        '7' =>  'Kazakhstan (KZ)',
        '254'   =>  'Kenya (KE)',
        '686'   =>  'Kiribati (KI)',
        '965'   =>  'Kuwait (KW)',
        '996'   =>  'Kyrgyzstan (KG)',
        '856'   =>  'Laos (LA)',
        '371'   =>  'Latvia (LV)',
        '961'   =>  'Lebanon (LB)',
        '266'   =>  'Lesotho (LS)',
        '231'   =>  'Liberia (LR)',
        '218'   =>  'Libya (LY)',
        '423'   =>  'Liechtenstein (LI)',
        '370'   =>  'Lithuania (LT)',
        '352'   =>  'Luxembourg (LU)',
        '853'   =>  'Macau (MO)',
        '389'   =>  'Macedonia (MK)',
        '261'   =>  'Madagascar (MG)',
        '265'   =>  'Malawi (MW)',
        '60'    =>  'Malaysia (MY)',
        '960'   =>  'Maldives (MV)',
        '223'   =>  'Mali (ML)',
        '356'   =>  'Malta (MT)',
        '692'   =>  'Marshall Islands (MH)',
        '596'   =>  'Martinique (MQ)',
        '222'   =>  'Mauritania (MR)',
        '230'   =>  'Mauritius (MU)',
        '262'   =>  'Mayotte (YT)',
        '52'    =>  'Mexico (MX)',
        '691'   =>  'Micronesia (FM)',
        '373'   =>  'Moldova (MD)',
        '377'   =>  'Monaco (MC)',
        '976'   =>  'Mongolia (MN)',
        '382'   =>  'Montenegro (ME)',
        '1664'  =>  'Montserrat (MS)',
        '212'   =>  'Morocco (MA)',
        '258'   =>  'Mozambique (MZ)',
        '264'   =>  'Namibia (NA)',
        '674'   =>  'Nauru (NR)',
        '977'   =>  'Nepal (NP)',
        '31'    =>  'Netherlands (NL)',
        '599'   =>  'Netherlands Antilles (AN)',
        '687'   =>  'New Caledonia (NC)',
        '505'   =>  'Nicaragua (NI)',
        '227'   =>  'Niger (NE)',
        '234'   =>  'Nigeria (NG)',
        '683'   =>  'Niue (NU)',
        '850'   =>  'North Korea (KP)',
        '1670'  =>  'Northern Mariana Islands (MP)',
        '47'    =>  'Norway (NO)',
        '968'   =>  'Oman (OM)',
        '92'    =>  'Pakistan (PK)',
        '680'   =>  'Palau (PW)',
        '970'   =>  'Palestine (PS)',
        '507'   =>  'Panama (PA)',
        '675'   =>  'Papua New Guinea (PG)',
        '595'   =>  'Paraguay (PY)',
        '51'    =>  'Peru (PE)',
        '63'    =>  'Philippines (PH)',
        '870'   =>  'Pitcairn Islands (PN)',
        '48'    =>  'Poland (PL)',
        '351'   =>  'Portugal (PT)',
        '1787'  =>  'Puerto Rico (PR)',
        '1939'  =>  'Puerto Rico (PR)',
        '974'   =>  'Qatar (QA)',
        '242'   =>  'Republic of the Congo (CG)',
        '262'   =>  'Reunion Island (RE)',
        '40'    =>  'Romania (RO)',
        '7' =>  'Russia (RU)',
        '250'   =>  'Rwanda (RW)',
        '590'   =>  'Saint Barthelemy (BL)',
        '290'   =>  'Saint Helena (SH)',
        '1869'  =>  'Saint Kitts and Nevis (KN)',
        '1758'  =>  'Saint Lucia (LC)',
        '590'   =>  'Saint Martin (MF)',
        '508'   =>  'Saint Pierre and Miquelon (PM)',
        '1784'  =>  'Saint Vincent Grenadines(VC)',
        '685'   =>  'Samoa (WS)',
        '378'   =>  'San Marino (SM)',
        '239'   =>  'Sao Tome and Principe (ST)',
        '966'   =>  'Saudi Arabia (SA)',
        '221'   =>  'Senegal (SN)',
        '381'   =>  'Serbia (RS)',
        '248'   =>  'Seychelles (SC)',
        '232'   =>  'Sierra Leone (SL)',
        '65'    =>  'Singapore (SG)',
        '1721'  =>  'Sint Maarten (SX)',
        '421'   =>  'Slovakia (SK)',
        '386'   =>  'Slovenia (SI)',
        '677'   =>  'Solomon Islands (SB)',
        '252'   =>  'Somalia (SO)',
        '27'    =>  'South Africa (ZA)',
        '82'    =>  'South Korea (KR)',
        '211'   =>  'South Sudan (SS)',
        '34'    =>  'Spain (EspaÃ±a) (ES)',
        '94'    =>  'Sri Lanka (LK)',
        '249'   =>  'Sudan (SD)',
        '597'   =>  'Suriname (SR)',
        '47'    =>  'Svalbard (SJ)',
        '268'   =>  'Swaziland (SZ)',
        '46'    =>  'Sweden (SE)',
        '41'    =>  'Switzerland (CH)',
        '963'   =>  'Syria (SY)',
        '886'   =>  'Taiwan (TW)',
        '992'   =>  'Tajikistan (TJ)',
        '255'   =>  'Tanzania (TZ)',
        '66'    =>  'Thailand (TH)',
        '670'   =>  'Timor-Leste (East Timor) (TL)',
        '228'   =>  'Togo (TG)',
        '690'   =>  'Tokelau (TK)',
        '676'   =>  'Tonga Islands (TO)',
        '1868'  =>  'Trinidad and Tobago (TT)',
        '216'   =>  'Tunisia (TN)',
        '90'    =>  'Turkey (TR)',
        '993'   =>  'Turkmenistan (TM)',
        '1649'  =>  'Turks and Caicos Islands (TC)',
        '688'   =>  'Tuvalu (TV)',
        '256'   =>  'Uganda (UG)',
        '380'   =>  'Ukraine (UA)',
        '971'   =>  'United Arab Emirates (AE)',
        '44'    =>  'United Kingdom (GB)',
        '1' =>  'United States (US)',
        '598'   =>  'Uruguay (UY)',
        '1340'  =>  'US Virgin Islands (VI)',
        '998'   =>  'Uzbekistan (UZ)',
        '678'   =>  'Vanuatu (VU)',
        '58'    =>  'Venezuela (VE)',
        '84'    =>  'Vietnam (VN)',
        '681'   =>  'Wallis and Futuna (WF)',
        '212'   =>  'Western Sahara (EH)',
        '967'   =>  'Yemen (YE)',
        '260'   =>  'Zambia (ZM)',
        '263'   =>  'Zimbabwe (ZW)',
    );



}

new HT_CTC_Static();

endif; // END class_exists check