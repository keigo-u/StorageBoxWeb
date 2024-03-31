<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use App\Models\Page;

class GetPageCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get DuelMasters card page count for scraping.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://dm.takaratomy.co.jp/card/';

        // クロームの機能を管理するクラスのインスタンス化
        $options = new ChromeOptions();
        // クローム起動時のオプション格納
        $options->addArguments([
            '--no-sandbox',
            '--headless'
        ]);

        // Chromeブラウザを起動
        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        // ブラウザを実行するプラットフォームを指定。クロームとのセッションがスムーズになる？？
        $caps->setPlatform("LINUX");

        // Selenium ServerのURL
        $host = 'http://selenium:4444/wd/hub';

        try {
            // ドライバーの生成
            $driver = retry(3, function () use ($host, $caps) {
                // chrome ドライバーの起動
                return RemoteWebDriver::create($host, $caps, 60000, 60000);
            }, 1000);

            $driver->get($url);
            $driver->wait(3);

            $page_count = $driver->findElement(WebDriverBy::className("nextpostslink"))->getAttribute("data-page");

            echo "現在の総ページ数：". $page_count;

            Page::create(["count" => $page_count]);

            // 処理終了
            return;
        } catch (\Exception $e) {
            echo 'エラーによりスクレイピングが失敗しました。ERROR MESSAGE : ' . $e->getMessage() . ' TRACE : ' . $e->getTraceAsString();
        } finally {
            $driver->quit();
        }
    }
}
