<?php

class shopImporthelperPlugin extends shopPlugin
{
  public $connection;
  public function DataBaseConnection(){
    $config = array (
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'name' => 'shopscript',
          ); 
        $this -> connection = mysqli_connect(
        $config['server'],
        $config['username'],
        $config['password'],
        $config['name']
      );
      if ($this -> connection == true)
      {
        echo "Подключение к базе данных выполнено успешно.\n";
      }
      else 
      {
        echo "Не удалось подключиться к базе данных!\n".mysqli_connect_error();
        exit;
      }
      return $this -> connection;
  }

  public $categories = array();
  public $offers = array();
  public function XmlLoadOut(){
    $xml = new XMLReader();
    $xmlLoadOut = $xml -> open(__DIR__.'\config\yml-feed-short.xml') or exit("Не удалось найти данный файл.");
    if ($xmlLoadOut == true){
      echo "Файл подключен.\n";
    }
    else {
      exit ("Не удалось подключить файл.\n");
    }

    while ($xml -> read()){
      if ($xml->nodeType == XmlReader::ELEMENT and $xml->localName == 'category'){
        $category = array();
        $category['id'] = $xml->getAttribute('id');
        if ($xml->getAttribute('parentId') == true){
          $category['parentId'] = $xml->getAttribute('parentId');
        }
        $xml -> read();
        $category['name'] = $xml->value;
        ($this -> categories)[] = $category;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'offer'){
        $offer = array();
        $offer['available'] = $xml->getAttribute('available');
        $offer['id'] = $xml->getAttribute('id');
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'url'){
        $xml->read();
        $offer['url'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'price'){
        $xml->read();
        $offer['price'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'currencyId'){
        $xml->read();
        $offer['currencyId'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'vat'){
        $xml->read();
        $offer['vat'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'categoryId'){
        $xml->read();
        $offer['categoryId'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'picture'){
        $xml->read();
        $offer['picture'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'name'){
        $xml->read();
        $offer['name'] = $xml->value;
      }

      if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'description'){
        $xml->read();
        $offer['description'] = $xml->value;
      }

    if ($xml->nodeType == XMLReader::ELEMENT and $xml->localName == 'barcode'){
        $xml->read();
        $offer['barcode'] = $xml->value;
        ($this -> offers)[] = $offer;
      }
    }
    $xml -> close(__DIR__.'\config\yml-feed.xml');
    echo "Выгрузка XML-файла успешно завершена.\n";
  }

  public function StartImport(){
    $connection = $this -> connection;
    $categories = $this -> categories;
    $offers = $this -> offers;
    $test = mysqli_query($connection, "SELECT * FROM shop_category ");
    while ($data = mysqli_fetch_assoc($test)){
      for ($i=0; $i<count($categories); $i++){
        if ($categories[$i]['name'] !== $data['name']){
         mysqli_query($connection, "SELECT * FROM shop_category");
        }
      }
    }
  }
}