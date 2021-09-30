<?php
    if(!isset($_GET['step'])){$step=0;}
    else {
        $step=$_GET['step'];
        if($step==2) {
            /* Do this */
        }
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Saturn Installer</title>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/lewmilburn/Particle-CSS@1.0.0/particle.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="icon" type="image/png" href="https://service.lmwn.co.uk/brandkit/saturn/icon.png">
        <link rel='apple-touch-icon' type='image/png' sizes='300x300' href='https://service.lmwn.co.uk/brandkit/saturn/icon.png'>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    </head>

    <body class="bg-black">
        <div class="page-bg"></div>

        <div class="animation-wrapper">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
        </div>

        <div class="page-wrapper z-40 sm:hidden block">Please use a larger screen to setup Saturn.</div>
        <div class="page-wrapper z-40 sm:block hidden">
            <div class="absolute bottom-0 right-0">
                <a href="https://saturncms.net/feedback" target="_blank" class="relative group flex" title="Feedback">
                    <i class="fad fa-comments-alt m-2 text-lg"></i>
                </a>
                <a href="https://docs.saturncms.net/BETA-1.0.0/installation" target="_blank" class="relative group flex" title="Installation Guide">
                    <i class="fad fa-question-circle m-2 text-lg"></i>
                </a>
            </div>
        <?php if (isset($_GET['error'])) {
            echo '<div class="flex h-screen">
                <div class="m-auto text-white text-center">
                    <h1 class="text-3xl md:text-5xl">
                        Sorry, an error occurred.
                    </h1>
                        <p class="text-base my-4">
                            '.htmlspecialchars(addslashes($_GET['error'])).'
                        </p>
                    <a href="installer.php" class="py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        Retry
                    </a>
                </div>
            </div>'; exit;
        }
        if (!isset($_GET['step'])) { echo '<div class="flex h-screen">
                <div class="m-auto text-white text-center">
                    <center><img src="https://service.lmwn.co.uk/brandkit/saturn/logo.png" class="w-1/4 mb-6" alt="Saturn"></center>
                    <h1 class="text-3xl md:text-5xl">
                        Welcome to Saturn CMS
                    </h1>
                    <a href="installer.php?step=setup" class="py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        Install BETA 1.0.0
                    </a>
                </div>
            </div>'; } else if ($_GET['step'] == 'setup' ){ echo '<div class="h-screen max-w-7xl">
                <div class="overflow-scroll my-28 h-5/6 m-auto text-white text-center bg-white bg-opacity-10 px-10 py-10 rounded-md overflow-y-scroll">
                    <form action="installer.php?step=check" method="POST" x-data="{ tab: \'activate\' }">
                        <center><img src="https://service.lmwn.co.uk/brandkit/saturn/logo.png" class="w-1/4 mb-6" alt="Saturn"></center>
                        <div x-show="tab === \'activate\'">
                            <h1 class="text-3xl md:text-5xl my-10">
                                Activate Saturn
                            </h1>
                            <p class="text-base mb-10">
                                You can get a code from saturncms.net/get
                            </p>
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div class="flex">
                                    <label for="activation" class="text-base w-1/4">Activation Key</label>
                                    <input id="activation" name="activation" type="activation" class="appearance-none rounded-md relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                                </div>
                            </div>
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div class="flex w-1/2 space-x-2 m-6">
                                    <a class="py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Check</a>
                                    <span id="activation-check" class="w-3/4 text-red-500 text-base">Not Activated</span>
                                </div>
                            </div>
                            <div class="flex w-1/2 space-x-2 m-6">
                                <a :class="{ \'active\': tab === \'welcome\' }" @click.prevent="tab = \'welcome\'" class="flex-grow py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Next</a>
                            </div>
                        </div>
                        <div x-show="tab === \'welcome\'">
                            <h1 class="text-3xl md:text-5xl my-10">
                                Website Information.
                            </h1>
                            <p class="text-base mb-10">
                                This is basic information that we\'ll use to setup your website.
                            </p>
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div class="flex">
                                    <label for="site_name" class="text-base w-1/4">Site Name</label>
                                    <input id="site_name" name="site_name" type="text" autocomplete="site_name" class="appearance-none rounded-t-mb relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                                <div class="flex">
                                    <label for="site_description" class="text-base w-1/4">Site Description</label>
                                    <input id="site_description" name="site_description" type="text" autocomplete="site_description" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                                <div class="flex">
                                    <label for="site_timezone" class="text-base w-1/4">Site Timezone</label>
                                    <select id="site_timezone" name="site_timezone" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option disabled>---------- Africa ----------</option> <option>Africa/Abidjan</option><option>Africa/Accra</option><option>Africa/Addis_Ababa</option><option>Africa/Algiers</option><option>Africa/Asmara</option><option>Africa/Bamako</option><option>Africa/Bangui</option><option>Africa/Banjul</option> <option>Africa/Bissau</option><option>Africa/Blantyre</option><option>Africa/Brazzaville</option><option>Africa/Bujumbura</option> <option>Africa/Cairo</option><option>Africa/Casablanca</option><option>Africa/Ceuta</option><option>Africa/Conakry</option> <option>Africa/Dakar</option><option>Africa/Dar_es_Salaam</option><option>Africa/Djibouti</option><option>Africa/Douala</option> <option>Africa/El_Aaiun</option><option>Africa/Freetown</option><option>Africa/Gaborone</option><option>Africa/Harare</option> <option>Africa/Johannesburg</option><option>Africa/Juba</option><option>Africa/Kampala</option><option>Africa/Khartoum</option> <option>Africa/Kigali</option><option>Africa/Kinshasa</option><option>Africa/Lagos</option><option>Africa/Libreville</option> <option>Africa/Lome</option><option>Africa/Luanda</option><option>Africa/Lubumbashi</option><option>Africa/Lusaka</option> <option>Africa/Malabo</option><option>Africa/Maputo</option><option>Africa/Maseru</option><option>Africa/Mbabane</option> <option>Africa/Mogadishu</option><option>Africa/Monrovia</option><option>Africa/Nairobi</option><option>Africa/Ndjamena</option> <option>Africa/Niamey</option><option>Africa/Nouakchott</option><option>Africa/Ouagadougou</option><option>Africa/Porto-Novo</option> <option>Africa/Sao_Tome</option><option>Africa/Tripoli</option><option>Africa/Tunis</option><option>Africa/Windhoek</option> <option disabled>---------- America ----------</option> <option>America/Adak</option><option>America/Anchorage</option><option>America/Anguilla</option><option>America/Antigua</option> <option>America/Araguaina</option><option>America/Argentina/Buenos_Aires</option><option>America/Argentina/Catamarca</option><option>America/Argentina/Cordoba</option> <option>America/Argentina/Jujuy</option><option>America/Argentina/La_Rioja</option><option>America/Argentina/Mendoza</option><option>America/Argentina/Rio_Gallegos</option> <option>America/Argentina/Salta</option><option>America/Argentina/San_Juan</option><option>America/Argentina/San_Luis</option><option>America/Argentina/Tucuman</option> <option>America/Argentina/Ushuaia</option><option>America/Aruba</option><option>America/Asuncion</option><option>America/Atikokan</option> <option>America/Bahia</option><option>America/Bahia_Banderas</option><option>America/Barbados</option><option>America/Belem</option> <option>America/Belize</option><option>America/Blanc-Sablon</option><option>America/Boa_Vista</option><option>America/Bogota</option> <option>America/Boise</option><option>America/Cambridge_Bay</option><option>America/Campo_Grande</option><option>America/Cancun</option> <option>America/Caracas</option><option>America/Cayenne</option><option>America/Cayman</option><option>America/Chicago</option> <option>America/Chihuahua</option><option>America/Costa_Rica</option><option>America/Creston</option><option>America/Cuiaba</option> <option>America/Curacao</option><option>America/Danmarkshavn</option><option>America/Dawson</option><option>America/Dawson_Creek</option> <option>America/Denver</option><option>America/Detroit</option><option>America/Dominica</option><option>America/Edmonton</option> <option>America/Eirunepe</option><option>America/El_Salvador</option><option>America/Fort_Nelson</option><option>America/Fortaleza</option> <option>America/Glace_Bay</option><option>America/Goose_Bay</option><option>America/Grand_Turk</option><option>America/Grenada</option> <option>America/Guadeloupe</option><option>America/Guatemala</option><option>America/Guayaquil</option><option>America/Guyana</option> <option>America/Halifax</option><option>America/Havana</option><option>America/Hermosillo</option><option>America/Indiana/Indianapolis</option> <option>America/Indiana/Knox</option><option>America/Indiana/Marengo</option><option>America/Indiana/Petersburg</option><option>America/Indiana/Tell_City</option> <option>America/Indiana/Vevay</option><option>America/Indiana/Vincennes</option><option>America/Indiana/Winamac</option><option>America/Inuvik</option> <option>America/Iqaluit</option><option>America/Jamaica</option><option>America/Juneau</option><option>America/Kentucky/Louisville</option> <option>America/Kentucky/Monticello</option><option>America/Kralendijk</option><option>America/La_Paz</option><option>America/Lima</option> <option>America/Los_Angeles</option><option>America/Lower_Princes</option><option>America/Maceio</option><option>America/Managua</option> <option>America/Manaus</option><option>America/Marigot</option><option>America/Martinique</option><option>America/Matamoros</option> <option>America/Mazatlan</option><option>America/Menominee</option><option>America/Merida</option><option>America/Metlakatla</option> <option>America/Mexico_City</option><option>America/Miquelon</option><option>America/Moncton</option><option>America/Monterrey</option> <option>America/Montevideo</option><option>America/Montserrat</option><option>America/Nassau</option><option>America/New_York</option> <option>America/Nipigon</option><option>America/Nome</option><option>America/Noronha</option><option>America/North_Dakota/Beulah</option> <option>America/North_Dakota/Center</option><option>America/North_Dakota/New_Salem</option><option>America/Nuuk</option><option>America/Ojinaga</option> <option>America/Panama</option><option>America/Pangnirtung</option><option>America/Paramaribo</option><option>America/Phoenix</option> <option>America/Port-au-Prince</option><option>America/Port_of_Spain</option><option>America/Porto_Velho</option><option>America/Puerto_Rico</option> <option>America/Punta_Arenas</option><option>America/Rainy_River</option><option>America/Rankin_Inlet</option><option>America/Recife</option> <option>America/Regina</option><option>America/Resolute</option><option>America/Rio_Branco</option><option>America/Santarem</option> <option>America/Santiago</option><option>America/Santo_Domingo</option><option>America/Sao_Paulo</option><option>America/Scoresbysund</option> <option>America/Sitka</option><option>America/St_Barthelemy</option><option>America/St_Johns</option><option>America/St_Kitts</option> <option>America/St_Lucia</option><option>America/St_Thomas</option><option>America/St_Vincent</option><option>America/Swift_Current</option> <option>America/Tegucigalpa</option><option>America/Thule</option><option>America/Thunder_Bay</option><option>America/Tijuana</option> <option>America/Toronto</option><option>America/Tortola</option><option>America/Vancouver</option><option>America/Whitehorse</option> <option>America/Winnipeg</option><option>America/Yakutat</option><option>America/Yellowknife</option> <option disabled>---------- Antarctica ----------</option> <option>Antarctica/Casey</option><option>Antarctica/Davis</option><option>Antarctica/DumontDUrville</option><option>Antarctica/Macquarie</option> <option>Antarctica/Mawson</option><option>Antarctica/McMurdo</option><option>Antarctica/Palmer</option><option>Antarctica/Rothera</option> <option>Antarctica/Syowa</option><option>Antarctica/Troll</option><option>Antarctica/Vostok</option> <option disabled>---------- Arctic ----------</option> <option>Arctic/Longyearbyen</option> <option disabled>---------- Asia ----------</option> <option>Asia/Aden</option><option>Asia/Almaty</option><option>Asia/Amman</option><option>Asia/Anadyr</option> <option>Asia/Aqtau</option><option>Asia/Aqtobe</option><option>Asia/Ashgabat</option><option>Asia/Atyrau</option> <option>Asia/Baghdad</option><option>Asia/Bahrain</option><option>Asia/Baku</option><option>Asia/Bangkok</option> <option>Asia/Barnaul</option><option>Asia/Beirut</option><option>Asia/Bishkek</option><option>Asia/Brunei</option> <option>Asia/Chita</option><option>Asia/Choibalsan</option><option>Asia/Colombo</option><option>Asia/Damascus</option> <option>Asia/Dhaka</option><option>Asia/Dili</option><option>Asia/Dubai</option><option>Asia/Dushanbe</option> <option>Asia/Famagusta</option><option>Asia/Gaza</option><option>Asia/Hebron</option><option>Asia/Ho_Chi_Minh</option> <option>Asia/Hong_Kong</option><option>Asia/Hovd</option><option>Asia/Irkutsk</option><option>Asia/Jakarta</option> <option>Asia/Jayapura</option><option>Asia/Jerusalem</option><option>Asia/Kabul</option><option>Asia/Kamchatka</option> <option>Asia/Karachi</option><option>Asia/Kathmandu</option><option>Asia/Khandyga</option><option>Asia/Kolkata</option> <option>Asia/Krasnoyarsk</option><option>Asia/Kuala_Lumpur</option><option>Asia/Kuching</option><option>Asia/Kuwait</option> <option>Asia/Macau</option><option>Asia/Magadan</option><option>Asia/Makassar</option><option>Asia/Manila</option> <option>Asia/Muscat</option><option>Asia/Nicosia</option><option>Asia/Novokuznetsk</option><option>Asia/Novosibirsk</option> <option>Asia/Omsk</option><option>Asia/Oral</option><option>Asia/Phnom_Penh</option><option>Asia/Pontianak</option> <option>Asia/Pyongyang</option><option>Asia/Qatar</option><option>Asia/Qostanay</option><option>Asia/Qyzylorda</option> <option>Asia/Riyadh</option><option>Asia/Sakhalin</option><option>Asia/Samarkand</option><option>Asia/Seoul</option> <option>Asia/Shanghai</option><option>Asia/Singapore</option><option>Asia/Srednekolymsk</option><option>Asia/Taipei</option> <option>Asia/Tashkent</option><option>Asia/Tbilisi</option><option>Asia/Tehran</option><option>Asia/Thimphu</option> <option>Asia/Tokyo</option><option>Asia/Tomsk</option><option>Asia/Ulaanbaatar</option><option>Asia/Urumqi</option> <option>Asia/Ust-Nera</option><option>Asia/Vientiane</option><option>Asia/Vladivostok</option><option>Asia/Yakutsk</option> <option>Asia/Yangon</option><option>Asia/Yekaterinburg</option><option>Asia/Yerevan</option> <option disabled>---------- Atlantic ----------</option> <option>Atlantic/Azores</option><option>Atlantic/Bermuda</option><option>Atlantic/Canary</option><option>Atlantic/Cape_Verde</option> <option>Atlantic/Faroe</option><option>Atlantic/Madeira</option><option>Atlantic/Reykjavik</option><option>Atlantic/South_Georgia</option> <option>Atlantic/St_Helena</option><option>Atlantic/Stanley</option> <option disabled>---------- Australia ----------</option> <option>Australia/Adelaide</option><option>Australia/Brisbane</option><option>Australia/Broken_Hill</option><option>Australia/Darwin</option> <option>Australia/Eucla</option><option>Australia/Hobart</option><option>Australia/Lindeman</option><option>Australia/Lord_Howe</option> <option>Australia/Melbourne</option><option>Australia/Perth</option><option>Australia/Sydney</option> <option disabled>---------- Europe ----------</option> <option>Europe/Amsterdam</option><option>Europe/Andorra</option><option>Europe/Astrakhan</option><option>Europe/Athens</option> <option>Europe/Belgrade</option><option>Europe/Berlin</option><option>Europe/Bratislava</option><option>Europe/Brussels</option> <option>Europe/Bucharest</option><option>Europe/Budapest</option><option>Europe/Busingen</option><option>Europe/Chisinau</option> <option>Europe/Copenhagen</option><option>Europe/Dublin</option><option>Europe/Gibraltar</option><option>Europe/Guernsey</option> <option>Europe/Helsinki</option><option>Europe/Isle_of_Man</option><option>Europe/Istanbul</option><option>Europe/Jersey</option> <option>Europe/Kaliningrad</option><option>Europe/Kiev</option><option>Europe/Kirov</option><option>Europe/Lisbon</option> <option>Europe/Ljubljana</option><option selected>Europe/London</option><option>Europe/Luxembourg</option><option>Europe/Madrid</option> <option>Europe/Malta</option><option>Europe/Mariehamn</option><option>Europe/Minsk</option><option>Europe/Monaco</option> <option>Europe/Moscow</option><option>Europe/Oslo</option><option>Europe/Paris</option><option>Europe/Podgorica</option> <option>Europe/Prague</option><option>Europe/Riga</option><option>Europe/Rome</option><option>Europe/Samara</option> <option>Europe/San_Marino</option><option>Europe/Sarajevo</option><option>Europe/Saratov</option><option>Europe/Simferopol</option> <option>Europe/Skopje</option><option>Europe/Sofia</option><option>Europe/Stockholm</option><option>Europe/Tallinn</option> <option>Europe/Tirane</option><option>Europe/Ulyanovsk</option><option>Europe/Uzhgorod</option><option>Europe/Vaduz</option> <option>Europe/Vatican</option><option>Europe/Vienna</option><option>Europe/Vilnius</option><option>Europe/Volgograd</option> <option>Europe/Warsaw</option><option>Europe/Zagreb</option><option>Europe/Zaporozhye</option><option>Europe/Zurich</option> <option disabled>---------- Indian ----------</option> <option>Indian/Antananarivo</option><option>Indian/Chagos</option><option>Indian/Christmas</option><option>Indian/Cocos</option> <option>Indian/Comoro</option><option>Indian/Kerguelen</option><option>Indian/Mahe</option><option>Indian/Maldives</option> <option>Indian/Mauritius</option><option>Indian/Mayotte</option><option>Indian/Reunion</option> <option disabled>---------- Pacific ----------</option> <option>Pacific/Apia</option><option>Pacific/Auckland</option><option>Pacific/Bougainville</option><option>Pacific/Chatham</option> <option>Pacific/Chuuk</option><option>Pacific/Easter</option><option>Pacific/Efate</option><option>Pacific/Enderbury</option> <option>Pacific/Fakaofo</option><option>Pacific/Fiji</option><option>Pacific/Funafuti</option><option>Pacific/Galapagos</option> <option>Pacific/Gambier</option><option>Pacific/Guadalcanal</option><option>Pacific/Guam</option><option>Pacific/Honolulu</option> <option>Pacific/Kiritimati</option><option>Pacific/Kosrae</option><option>Pacific/Kwajalein</option><option>Pacific/Majuro</option> <option>Pacific/Marquesas</option><option>Pacific/Midway</option><option>Pacific/Nauru</option><option>Pacific/Niue</option> <option>Pacific/Norfolk</option><option>Pacific/Noumea</option><option>Pacific/Pago_Pago</option><option>Pacific/Palau</option> <option>Pacific/Pitcairn</option><option>Pacific/Pohnpei</option><option>Pacific/Port_Moresby</option><option>Pacific/Rarotonga</option> <option>Pacific/Saipan</option><option>Pacific/Tahiti</option><option>Pacific/Tarawa</option><option>Pacific/Tongatapu</option> <option>Pacific/Wake</option><option>Pacific/Wallis</option>
                                    </select>
                                </div>
                                <div class="flex">
                                    <label for="site_timezone" class="text-base w-1/4">Site Charset <a title="The character set used by the website. UTF-8 is usually best if you\'re using plain English. Saturn has automatically generated a recommended value for this item." class="text-xs border-b-2 border-dotted">?</a></label>
                                    <select id="site_timezone" name="site_timezone" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option>ASCII</option><option selected>UTF-8</option><option>UTF-16</option><option>UTF-32</option>
                                    </select>
                                </div>
                                <div class="flex">
                                    <label for="email_sendfrom" class="text-base w-1/4">Sendfrom Email <a title="Saturn sometimes needs to send emails to your users, let us know what email you\'d like us to send that email from. Saturn has automatically generated a recommended value for this item." class="text-xs border-b-2 border-dotted">?</a></label>
                                    <input id="email_sendfrom" name="email_sendfrom" type="email" autocomplete="email" class="appearance-none rounded-b-md relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" value="noreply@'.$_SERVER['HTTP_HOST'].'" required>
                                </div>
                            </div>
                            <div class="flex w-1/2 space-x-2 m-6">
                                <a :class="{ \'active\': tab === \'activate\' }" @click.prevent="tab = \'activate\'" class="flex-grow py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Previous</a>
                                <a :class="{ \'active\': tab === \'account\' }" @click.prevent="tab = \'account\'" class="flex-grow py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Next</a>
                            </div>
                        </div>
                        <div x-show="tab === \'account\'">
                            <h1 class="text-3xl md:text-5xl my-10">
                                Your account.
                            </h1>
                            <p class="text-base mb-10">
                                Let\'s create your account.
                            </p>
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div class="flex">
                                    <label for="user_email" class="text-base w-1/4">Email</label>
                                    <input id="user_email" name="user_email" type="email" autocomplete="email" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                                <div class="flex">
                                    <label for="user_username" class="text-base w-1/4">Username</label>
                                    <input id="user_username" name="user_username" type="text" autocomplete="username" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                                <div class="flex">
                                    <label for="user_password" class="text-base w-1/4">Password</label>
                                    <input id="user_password" name="user_password" type="password" autocomplete="password" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                                <div class="flex">
                                    <label for="user_firstname" class="text-base w-1/4">First Name</label>
                                    <input id="user_firstname" name="user_firstname" type="text" autocomplete="firstname" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                                <div class="flex">
                                    <label for="user_lastname" class="text-base w-1/4">Last Name</label>
                                    <input id="user_lastname" name="user_lastname" type="text" autocomplete="lastname" class="appearance-none rounded-none rounded-b-md relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required>
                                </div>
                            </div>
                            <div class="flex w-1/2 space-x-2 m-6">
                                <a :class="{ \'active\': tab === \'welcome\' }" @click.prevent="tab = \'welcome\'" class="flex-grow py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Previous</a>
                                <a :class="{ \'active\': tab === \'database\' }" @click.prevent="tab = \'database\'" class="flex-grow py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Next</a>
                            </div>
                        </div>
                        <div x-show="tab === \'database\'">
                            <h1 class="text-3xl md:text-5xl my-10">
                                Database Settings.
                            </h1>
                            <p class="text-base mb-10">
                                Saturn requires an SQL Database to store data.<br>Don\'t worry, you don\'t need to make the tables, we\'ll do that for you.
                            </p>
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div class="flex">
                                    <label for="db_host" class="text-base w-1/4">Hostname</label>
                                    <input id="db_host" name="db_host" type="text" autocomplete="db_host" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="sql.example.com">
                                </div>
                                <div class="flex">
                                    <label for="db_name" class="text-base w-1/4">Name</label>
                                    <input id="db_name" name="db_name" type="text" autocomplete="db_name" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <div class="flex">
                                    <label for="db_port" class="text-base w-1/4">Port <a title="Optional, if unknown leave this as 3306. Saturn has automatically generated the default value for this item." class="text-xs border-b-2 border-dotted">?</a></label>
                                    <input id="db_port" name="db_port" type="text" autocomplete="db_port" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="" value="3306">
                                </div>
                                <div class="flex">
                                    <label for="db_user" class="text-base w-1/4">Username</label>
                                    <input id="db_user" name="db_user" type="text" autocomplete="db_user" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <div class="flex">
                                    <label for="db_pass" class="text-base w-1/4">Password</label>
                                    <input id="db_pass" name="db_pass" type="password" autocomplete="db_pass" class="appearance-none rounded-none relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <div class="flex">
                                    <label for="db_prefix" class="text-base w-1/4">Prefix <a title="A value added to the start of the database\'s tables to group them to Saturn. Saturn has automatically generated a recommended value for this item." class="text-xs border-b-2 border-dotted">?</a></label>
                                    <input id="db_prefix" name="db_prefix" type="text" autocomplete="db_prefix" class="appearance-none rounded-none rounded-b-md relative block w-3/4 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="" value="'.substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 3)), 0, 3).'_">
                                </div>
                            </div>
                            <style>form:invalid [type=submit] { background-color: rgba(239, 68, 68); } form:valid [type=submit] { background-color: rgba(16, 185, 129); }</style>
                            <div class="flex w-1/2 space-x-2 m-6">
                                <a :class="{ \'active\': tab === \'account\' }" @click.prevent="tab = \'account\'" class="flex-grow py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Previous</a>
                                <input type="submit" value="Submit" class="py-2 px-4 bg-gray-600 hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">
                            </div>
                        </div>
                    </form>
                </div>
            </div>'; } else if ($_GET['step'] == 'check') { echo '<div class="h-screen">
                <div class="overflow-scroll my-28 h-5/6 m-auto text-white text-center bg-white bg-opacity-10 px-10 py-10 rounded-md overflow-y-scroll">
                    <center><img src="https://service.lmwn.co.uk/brandkit/saturn/logo.png" class="w-1/4 mb-6" alt="Saturn"></center>
                    <h1 class="text-3xl md:text-5xl my-10">
                        Checking Database
                    </h1>
                    <p class="text-base mb-10">
                        This should only take a few moments.
                    </p>
                    <i class="far fa-sync-alt fa-spin"></i>
                    <span class="text-base"><br><!--';
                    $con = mysqli_connect($_POST['db_host'],$_POST['db_user'],$_POST['db_pass'],$_POST['db_name']);
                    echo'-->';
                    // Check connection
                    if (mysqli_connect_errno()) {
                        header('Location: installer.php?error=Unable to connect to the Database: '.mysqli_connect_error());
                    } else {
                        header('Location: installer.php?step=3');
                    }
                echo '</span></div>
            </div>';
        }
        ?>
        </div>
    </body>
</html>
