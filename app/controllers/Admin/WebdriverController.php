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
        $host = '127.0.0.1:5555';

        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities);

        // Mở trang web
        $driver->get($url);

        // Đảm bảo cửa sổ trình duyệt có kích thước đủ lớn để hiển thị toàn bộ trang web
        $window = new WebDriverDimension(1920, 1080);
        $driver->manage()->window()->setSize($window);

        // Delay 3 giây
        sleep(3);

        // Khởi tạo thư mục lưu trữ ảnh
        $imageDir = 'image';
        if (!is_dir($imageDir)) {
            mkdir($imageDir);
        }

        // Tạo tên file và đường dẫn tới thư mục image
        $filename = $imageDir . '/' . uniqid() . '.png';

        // Chụp màn hình và lưu thành file
        $driver->takeScreenshot($filename);

        $driver->quit();
    }
}
