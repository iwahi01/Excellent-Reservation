<?php
use Facebook\WebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

//class firefoxTest extends PHPUnit_Framework_TestCase {
class chromeTest extends PHPUnit_Framework_TestCase {
  public function testWebUI() {
    $host = 'http://iwahi01-ta20:4444/wd/hub';
    $driver = RemoteWebDriver::create(
              $host,
              DesiredCapabilities::chrome(),
              180 * 1000, // Connection timeout in miliseconds
              180 * 1000  // Request timeout in miliseconds
              );

    $driver->get('http://iwahi01-ta20:5555/excellent/');
    $title = $driver->getTitle();
    print PHP_EOL.'ページタイトルは"'.$title.'"';
    $this->assertEquals('グローバル鉄道オンライン予約 Excellent予約ログイン', $title);

    $element = $driver->findElement(WebDriverBy::name('userid'));
    $element->sendKeys('iwahi01@ca.com');
    $element = $driver->findElement(WebDriverBy::name('password'));
    $element->sendKeys('P@ssw0rd');
    $element->submit();

    $driver->wait(10);
    $title = $driver->getTitle();
    print PHP_EOL.'ページタイトルは"'.$title.'"';
    $this->assertEquals('グローバル鉄道オンライン予約 Excellent予約トップ', $title);
    $element = $driver->findElement(WebDriverBy::id('reserve'));
    $element->click();

    $driver->wait(20);
    $title = $driver->getTitle();
    print PHP_EOL.'ページタイトルは"'.$title.'"';
    $this->assertEquals('グローバル鉄道オンライン予約 情報照会', $title);

    $driver->close();
  }
}
?>
