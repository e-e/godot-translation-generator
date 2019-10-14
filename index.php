<?php

require_once "vendor/autoload.php";

use App\App;
use App\Services\ParseCsvService;
use App\Services\GoogleTranslateService;
use Dotenv\Dotenv;
use Google\Cloud\Translate\TranslateClient;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$client = new TranslateClient([
    'keyFilePath' => getenv('GOOGLE_TRANSLATE_KEYFILE_PATH'),
]);
$translator = new GoogleTranslateService($client);

$languageCodeMap = require_once "./lang-codes.php";
$parser = new ParseCsvService($languageCodeMap);

$app = new App($parser, $translator);
$app->run(
    $inputFile = $argv[1],
    $outputFile = $argv[2]
);
