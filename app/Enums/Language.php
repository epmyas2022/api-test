<?php

namespace App\Enums;

use ReflectionClass;

enum Language: string
{
    case AFRIKAANS = "Afrikaans";
    case ALBANIAN = "Albanian";
    case AMHARIC = "Amharic";
    case ARABIC = "Arabic";
    case ARMENIAN = "Armenian";
    case ASSAMESE = "Assamese";
    case AYMARA = "Aymara";
    case AZERI = "Azeri";
    case BELARUSIAN = "Belarusian";
    case BENGALI = "Bengali";
    case BISLAMA = "Bislama";
    case BOSNIAN = "Bosnian";
    case BULGARIAN = "Bulgarian";
    case BURMESE = "Burmese";
    case CATALAN = "Catalan";
    case CHINESE = "Chinese";
    case CROATIAN = "Croatian";
    case CZECH = "Czech";
    case DANISH = "Danish";
    case DARI = "Dari";
    case DHIVEHI = "Dhivehi";
    case DUTCH = "Dutch";
    case DZONGKHA = "Dzongkha";
    case ENGLISH = "English";
    case ESTONIAN = "Estonian";
    case FIJIAN = "Fijian";
    case FILIPINO = "Filipino";
    case FINNISH = "Finnish";
    case FRENCH = "French";
    case GAGAUZ = "Gagauz";
    case GEORGIAN = "Georgian";
    case GERMAN = "German";
    case GREEK = "Greek";
    case GUARANI = "Guaraní";
    case GUJARATI = "Gujarati";
    case HAITIAN_CREOLE = "Haitian Creole";
    case HEBREW = "Hebrew";
    case HINDI = "Hindi";
    case HIRI_MOTU = "Hiri Motu";
    case HUNGARIAN = "Hungarian";
    case ICELANDIC = "Icelandic";
    case INDONESIAN = "Indonesian";
    case IRISH_GAELIC = "Irish Gaelic";
    case ITALIAN = "Italian";
    case JAPANESE = "Japanese";
    case KANNADA = "Kannada";
    case KASHMIRI = "Kashmiri";
    case KAZAKH = "Kazakh";
    case KHMER = "Khmer";
    case KOREAN = "Korean";
    case KURDISH = "Kurdish";
    case KYRGYZ = "Kyrgyz";
    case LAO = "Lao";
    case LATVIAN = "Latvian";
    case LITHUANIAN = "Lithuanian";
    case LUXEMBOURGISH = "Luxembourgish";
    case MACEDONIAN = "Macedonian";
    case MALAGASY = "Malagasy";
    case MALAY = "Malay";
    case MALAYALAM = "Malayalam";
    case MALTESE = "Maltese";
    case MAORI = "Māori";
    case MARATHI = "Marathi";
    case MOLDOVAN = "Moldovan";
    case MONGOLIAN = "Mongolian";
    case MONTENEGRIN = "Montenegrin";
    case NDEBELE = "Ndebele";
    case NEPALI = "Nepali";
    case NEW_ZEALAND_SIGN_LANGUAGE = "New Zealand Sign Language";
    case NORTHERN_SOTHO = "Northern Sotho";
    case NORWEGIAN = "Norwegian";
    case ORIYA = "Oriya";
    case PAPIAMENTO = "Papiamento";
    case PASHTO = "Pashto";
    case PERSIAN = "Persian";
    case POLISH = "Polish";
    case PORTUGUESE = "Portuguese";
    case PUNJABI = "Punjabi";
    case QUECHUA = "Quechua";
    case ROMANIAN = "Romanian";
    case SOMALI = "Somali";
    case SOTHO = "Sotho";
    case SPANISH = "Spanish";
    case SWAHILI = "Swahili";
    case SWATI = "Swati";
    case SWEDISH = "Swedish";
    case TAJIK = "Tajik";
    case TAMIL = "Tamil";
    case TELUGU = "Telugu";
    case TETUM = "Tetum";
    case THAI = "Thai";
    case TOK_PISIN = "Tok Pisin";
    case TSONGA = "Tsonga";
    case TSWANA = "Tswana";
    case WEST_FRISIAN = "West Frisian";
    case YIDDISH = "Yiddish";
    case ZULU = "Zulu";

    /**
     * Get all the values of the enum
     * @return array
     */
    public static function getAll(): array
    {
        $reflectionClass = new ReflectionClass(self::class);

        return $reflectionClass->getConstants();
    }

}
