<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverDimension;

// Set the path to the directory containing the .env file
$dotenvPath = realpath(__DIR__ . '/../../'); // Adjust the path as needed

// Load .env file from the correct path
$dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
$dotenv->load();

function getHTMLPage($url) {



    // Configure Selenium WebDriver with Chrome
    $options = new ChromeOptions();
    $options->addArguments(['--headless', '--no-sandbox', '--disable-dev-shm-usage']);
    $capabilities = DesiredCapabilities::chrome();
    $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

    // Use environment variable for Selenium WebDriver hub URL
    $seleniumHubUrl = getenv('SELENIUM_HUB_URL') ?: 'http://localhost:4444/wd/hub';

    //  Call driver
    $driver = RemoteWebDriver::create($seleniumHubUrl, $capabilities);

    // Set the browser window size to a large dimension
    $width = 1920;  // You can adjust the width as needed
    $height = 20000; // Set a very large height
    $driver->manage()->window()->setSize(new WebDriverDimension($width, $height));

    // Load target website
    $driver->get($url);

    // Get initial height of the webpage
    $lastHeight = $driver->executeScript('return document.body.scrollHeight');

    $pageSource = ""; // Initialize an empty string to store the entire page source

    while (true) {
        // Scroll down to the bottom
        $driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');

        // Wait for content to load
        sleep(10);

        // Get new height
        $newHeight = $driver->executeScript('return document.body.scrollHeight');

        if ($newHeight == $lastHeight) {
            break; // Break the loop if the height hasn't changed
        }

        $lastHeight = $newHeight;

        // Get the current page source and append it to $pageSource
        $currentSource = $driver->getPageSource();
        $pageSource .= $currentSource; // Append the new content
    }
    // Close the browser
    $driver->quit();

    return $pageSource;
}

function getNameStoreFromHTML($dom) {
    $h1Elements = $dom->getElementsByTagName('h1');
    $restaurant_name = '';
    foreach ($h1Elements as $h1Element) {
        $classAttribute = $h1Element->getAttribute('class');
        if ($classAttribute === 'name-restaurant') {
            $restaurant_name = $h1Element->nodeValue;
        }
    }

    return $restaurant_name;
}

function getImageStoreFromHTML($dom) {
    $xpath = new DOMXPath($dom);
    $query = '//div[contains(@class, "detail-restaurant-img")]/img/@src';
    $img_store = $xpath->query($query)->item(0)->nodeValue;
    return $img_store;
}

function getImageFromHTML($dom) {
    $xpath = new DOMXPath($dom);
    $img_list = array();


    $query = '//div[contains(@class, "col-auto item-restaurant-img")]';

    $divs = $xpath->query($query);
    foreach ($divs as $div) {
        $img = $xpath->query('.//button[contains(@class, "inline")]/img/@src', $div)->item(0);

        if ($img) {
            array_push($img_list, $img->nodeValue);
        }
    }

    return $img_list;
}

function getPriceFromHTML($dom) {
    $divElements = $dom->getElementsByTagName('div');
    $price_list = array();

    foreach ($divElements as $divElement) {
        $classAttribute = $divElement->getAttribute('class');
        if (strpos($classAttribute, 'current-price') !== false) {
            $price = $divElement->nodeValue;
            array_push($price_list, (int) str_replace([",", "đồng", "."], "", $price));
        }
    }

    return $price_list;
}

function getNameFromHTML($dom) {
    $h2Elements = $dom->getElementsByTagName('h2');
    $name_list = array();

    foreach ($h2Elements as $h2Element) {
        $classAttribute = $h2Element->getAttribute('class');
        if (strpos($classAttribute, 'item-restaurant-name') !== false) {
            $name = $h2Element->nodeValue;
            array_push($name_list, $name);
        }
    }

    return $name_list;
}
