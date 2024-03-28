<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;
use App\Models\Card;
use App\Models\Civil;
use App\Models\Type;
use App\Models\Rarity;
use App\Models\Race;


class SeleniumTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test for scraping';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 5ページ分のURLを生成
        $urls = [];
        for ($i = 1; $i <= 5; $i++) {
            array_push($urls, "https://dm.takaratomy.co.jp/card/?v=%7B%22suggest%22:%22on%22,%22keyword_type%22:%5B%22card_name%22,%22card_ruby%22,%22card_text%22%5D,%22culture_cond%22:%5B%22%E5%8D%98%E8%89%B2%22,%22%E5%A4%9A%E8%89%B2%22%5D,%22pagenum%22:%22".$i."%22,%22samename%22:%22show%22,%22sort%22:%22release_new%22%7D");
        }

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
                // chrome ドライバーの起動、ウイーーーーーーーーーーーン
                return RemoteWebDriver::create($host, $caps, 60000, 60000);
            }, 1000);

            // サイトにアクセス
            $driver->get($urls[0]);

            // ページタイトルが読み込まれるまで待つ
            $driver->wait()->until(
                WebDriverExpectedCondition::titleIs('カード検索 | デュエル・マスターズ')
            );

            // カード画像から詳細ページURLを取得
            $card_elements = $driver->findElements(WebDriverBy::className('cardImage'));
            $card_info_urls = [];
            foreach ($card_elements as $element) {
                array_push($card_info_urls, "https://dm.takaratomy.co.jp" . $element->getAttribute('data-href'));
            }

            sleep(3);
            // 詳細ページにアクセス
            $driver->get($card_info_urls[1]);

            $table_element = $driver->findElement(WebDriverBy::tagName('table'));
            $elems_head = $table_element->findElement(WebDriverBy::className('cardname'))->getText();
            $pos = mb_strripos($elems_head, "(");
            $cardname = mb_substr($elems_head, 0, $pos);
            $packname = $table_element->findElement(WebDriverBy::className('packname'))->getText();
            $type = $table_element->findElement(WebDriverBy::className('typetxt'))->getText();
            $rarity = $table_element->findElement(WebDriverBy::className('raretxt'))->getText();
            $power = $table_element->findElement(WebDriverBy::className('powertxt'))->getText();
            $cost = $table_element->findElement(WebDriverBy::className('costtxt'))->getText();
            $mana = $table_element->findElement(WebDriverBy::className('manatxt'))->getText();
            $illustrator = $table_element->findElement(WebDriverBy::className('illusttxt'))->getText();
            $ability = $table_element->findElement(WebDriverBy::className('abilitytxt'))->getText();
            $flavor = $table_element->findElement(WebDriverBy::className('flavortxt'))->getText();
            $civil_text = $table_element->findElement(WebDriverBy::className('civtxt'))->getText();
            $civil_texts = explode("/", $civil_text);
            $race_text = $table_element->findElement(WebDriverBy::className('racetxt'))->getText();
            $race_texts = explode("/", $race_text);

            $base_image_url = 'https://dm.takaratomy.co.jp' . $driver->findElement(WebDriverBy::className('cardimg'))->findElement(WebDriverBy::tagName('img'))->getAttribute('src');

            // データベースへの登録
            $card = Card::create([
                "card_name" => $cardname,
                "pack_name" => $packname,
                "base_image_url" => $base_image_url,
                "image_url" => "",
                "power" => $power,
                "cost" => $cost,
                "mana" => $mana,
                "illust" => $illustrator,
                "ability" => $ability,
                "flavor" => $flavor,
                "type_id" => Type::getId($type),
                "rarity_id" => Rarity::getId($rarity)
            ]);

            $civils = [];
            foreach($civil_texts as $civil_name) {
                array_push($civils, Civil::getId($civil_name));
            }
            $card->civils()->attach($civils);

            $races = [];
            foreach($race_texts as $race_name) {
                $race = Race::where("name", $race_name)->first();
                if (isset($race)) {
                    array_push($races, $race->id);
                } else {
                    $new_race = Race::create(["name" => $race_name]);
                    array_push($races, $new_race->id);
                }
            }
            $card->races()->attach($races);

            // 処理終了
            return;
        } catch (\Exception $e) {
            echo 'エラーによりスクレイピングが失敗しました。ERROR MESSAGE : ' . $e->getMessage() . ' TRACE : ' . $e->getTraceAsString();
        } finally {
            $driver->quit();
        }
    }
}
