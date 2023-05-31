<?php

namespace App\Controllers\Admin;

use App\models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\WebDriverOptions;
use Facebook\WebDriver\WebDriverVersion;


class WebdriverController extends AppController
{
    use ResponseTrait;

    public $title = 'Screenshot';

    public object $obj_model;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_model = new User;
    }

    public function indexAction()
    {
        $this->data_ary['content'] = 'webdriver/index';
    }

    public function webdriver(Request $request)
    {
        $url = $request->getPost()->get('url');

        // Thiết lập ChromeDriver
        $chromeDriverPath = '/usr/local/bin/chromedriver';
        putenv('webdriver.chrome.driver=' . $chromeDriverPath);

        // Khởi tạo DesiredCapabilities cho Chrome
        $capabilities = DesiredCapabilities::chrome();

        // Khởi tạo RemoteWebDriver với địa chỉ IP và cổng
        $driver = RemoteWebDriver::create("http://192.168.1.219:4444/wd/hub", $capabilities);

        // Mở trang web cần chụp ảnh
        $driver->get($url);

        // Đảm bảo cửa sổ trình duyệt có kích thước đủ lớn để hiển thị toàn bộ trang web
        $window = new WebDriverDimension(1920, 1080);
        $driver->manage()->window()->setSize($window);

        // Chụp ảnh màn hình toàn trang
        $screenshot = $driver->takeScreenshot();

        // Lưu ảnh vào file
        $file = rand(1, 10000) . '.png';
        file_put_contents($file, $screenshot);

        // Đóng trình duyệt
        $driver->quit();
    }
}
