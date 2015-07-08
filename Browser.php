<?php
namespace AutoRu\Browser {
    require_once("PangParser.php");
    use AutoRu\Parse\PangParser;
    use AutoRu\Parse\DataParser;
    /**
     * Класс для загрузки всех страниц по автомобилю
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
         * @return array
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
            return $this->pages;
        }
    }
}
