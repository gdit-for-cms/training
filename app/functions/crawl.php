<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverDimension;
use App\Config;

function getHTMLPage($url, $maxRetries = 5) {
    $retryCount = 0;
    $maxRetries = Config::RETRY_CRAWL_TIMES;
    $pageSource = ""; // Initialize an empty string to store the entire page source

    while ($retryCount < $maxRetries && $pageSource == "") {
        try {
            $options = new ChromeOptions();
            $options->addArguments(['--headless', '--no-sandbox', '--disable-dev-shm-usage']);

            // Set longer timeout values
            $timeouts = [
                'pageLoad' => 600000, // 10 minutes for page load
                'script' => 120000, // 2 minutes for scripts
            ];

            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
            $capabilities->setCapability('timeouts', $timeouts);

            // Use environment variable for Selenium WebDriver hub URL
            $seleniumHubUrl = $_ENV['SELENIUM_HUB_URL'] ?: 'http://localhost:4444/wd/hub';

            try {
                $driver = RemoteWebDriver::create($seleniumHubUrl, $capabilities);
            } catch (Exception $e) {
                // Handle when server error or did not run
                error_log("Failed to connect to Selenium Server: " . $e->getMessage());
                $_SESSION['failed_connect_selenium'] = 'failed_connect_selenium';
                header('Location: /meal/create');
                exit;
            }

            // Set the browser window size to a large dimension
            $driver->manage()->window()->setSize(new WebDriverDimension(1920, 20000));

            // Load target website
            $driver->get($url);

            // Your existing scrolling logic to capture the page source...
            $lastHeight = $driver->executeScript('return document.body.scrollHeight');
            while (true) {
                $driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');
                sleep(10); // Wait for content to load
                $newHeight = $driver->executeScript('return document.body.scrollHeight');
                if ($newHeight == $lastHeight) {
                    break; // Break the loop if the height hasn't changed
                }
                $lastHeight = $newHeight;
                $currentSource = $driver->getPageSource();
                $pageSource .= $currentSource; // Append the new content
            }
        } catch (Exception $e) {
            // Log or handle the exception as needed
            // Increase the retry counter
            $retryCount++;
            // Optionally, log the retry attempt
            echo "Attempt $retryCount failed: " . $e->getMessage() . "\nRetrying...\n";
        } finally {
            // Ensure the browser is always closed after each attempt
            if (isset($driver)) {
                $driver->quit();
            }
        }
    }

    if ($retryCount == $maxRetries) {
        // Handle the case where all retries have failed
        echo "Failed to load the page after $maxRetries attempts.";
    }

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
    $img_store = "";
    try {
        $img_store = $xpath->query($query)->item(0)->nodeValue;
    } catch (Exception $e) {
        $img_store = "/img/food_store_img_1610.png";
    }
    return $img_store;
}

function getImageFromHTML($dom) {
    $xpath = new DOMXPath($dom);
    $img_list = array();

    $query = '//div[contains(@class, "col-auto item-restaurant-img")]';

    $divs = $xpath->query($query);
    foreach ($divs as $div) {
        // Using XPath to find the image within the context of the current div
        $img = $xpath->query('.//button[contains(@class, "inline")]/img/@src', $div)->item(0);

        // Check if an image was found before attempting to access its properties
        if ($img !== null) {
            array_push($img_list, $img->nodeValue);
        } else {
            array_push($img_list, "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSg42_wt_mrgp4hU9qPPnPKwsZvFObDHozB0nXmeboBmbf6n5lKvDiUxEwJFRlGqa9UwQY&usqp=CAU");
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

function getStatusFoodFromHTML($dom) {
    $xpath = new DOMXPath($dom);
    $status_list = array();
    $divs = $xpath->query('//div[contains(@class, "col-auto adding-food-cart txt-right")]');
    foreach ($divs as $div) {
        $childDiv = $div->getElementsByTagName('div');
        if ($childDiv[0]->getAttribute('class') == "btn-over") {
            array_push($status_list, 1);
        } else {
            array_push($status_list, 0);
        }
    }

    return $status_list;
}
