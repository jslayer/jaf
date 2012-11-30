<?php
class IndexController extends Jaf_Controller {
  public function indexAction() {


    $xmlString = @file_get_contents('http://www.nytimes.com/services/xml/rss/nyt/HomePage.xml');

    if (!$xmlString) {
      $this->view->set('html.title', 'Error');
      $this->view->set('error.message', 'Could not load data');
    }
    else {
      /**
       * @var SimpleXMLElement $xml
       */
      $xml = simplexml_load_string($xmlString);

      $this->view->set('html.title',        htmlentities($xml->channel->title))
                 ->set('channel.copyright', (string) $xml->channel->copyright)
                 ->set('channel.image.url', (string) $xml->channel->image->url);

      $news = array();

      foreach($xml->xpath('channel/item') as $item) {
        $news[ ] = new NewsItemModel($item);
      }

      $this->view->set('news.items', $news);
    }
  }
}