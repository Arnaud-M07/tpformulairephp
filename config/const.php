<?php
// REGEX 
define('POSTAL_CODE', '^[0-9]{5}$');
define('LASTNAME', '^[A-Za-zéèëêçà]{2,50}(-| )?([A-Za-zéèçà]{2,50})?$');
define('REGEX_LINKEDIN','^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)');
define('REGEX_DATE','^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$');
define('REGEX_PASSWORD', '^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$');
define('REGEX_TEXTAREA', '^[A-Za-z0-9.]{5,1000}$');
define('ARRAY_COUNTRY', ['France', 'Belgique', 'Suisse', 'Luxembourg', 'Allemagne', 'Italie', 'Espagne', 'Portugal']);
define('ARRAY_LANGAGES', ['HTML/CSS', 'PHP', 'Javascript', 'Python', 'Autres']);
define('ARRAY_TYPES', ['image/jpeg', 'image/png']);
define('UPLOAD_MAX_SIZE', 2*1024*1024);