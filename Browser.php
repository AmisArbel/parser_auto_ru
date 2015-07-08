<?php
namespace AutoRu\Browser {
    require_once("PangParser.php");
    require_once("DataParser.php");
    use AutoRu\Parse\PangParser;
    use AutoRu\Parse\DataParser;
    /**
     * Класс для загрузки все страниц по автомобилю
     * @property string link
     */
    class Browser
    {
        private $link;
        /**
         * Устанавливает ссылку для загрузки страниц с отзывами
         *
         */
        function __construct($link)
        {
            $this->link = $link;
        }
        /**
         * Получает страницу по ссылке
         *
         * @param string link
         * @return string
         */
        private function getPage($link)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $downloaded_page = curl_exec($ch);
            curl_close($ch);
            return $downloaded_page;
        }
        /**
         * Сохраняет страницы в массив $this->pages[]
         *
         */
        public function getPages()
        {
            $firstPage = $this->getPage($this->link);
            $pangParser = new PangParser();
            $pangParser->setContent($firstPage);
            $this->lastPage = $pangParser->getData();
            $this->pages = array();
            $this->pages[] = $firstPage;
            for ($i = 2; $i <= $this->lastPage; $i++) {
                print "$this->link?_p=$i&_l=10".PHP_EOL;
                $this->pages[] = $this->getPage("$this->link?_p=$i&_l=10");
            }
        }

        /**
         * Парсит все страницы $this->pages[]
         */
        public function parsePages()
        {
            $dataParser = new DataParser();
            $data = array();
            foreach ($this->pages as $page) {
                $dataParser->setContent($page);
                $data = array_merge($data, $dataParser->getData());
            }
            return $data;
        }
    }
}
