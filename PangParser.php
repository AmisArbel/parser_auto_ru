<?php

namespace AutoRu\Parse {
    require_once("AbstractParser.php");

    /**
     * @property string pattern
     */
    class PangParser extends AbstractParser
    {
        /**
         * Устанавливает необходимый шаблон
         *
         */
        function __construct()
        {
            $this->pattern = "/.a href=.._p=[0-9]+&_l=10..([0-9]+)..a./s";
        }
        /**
         * Извлекает из контента номер последней страницы
         *
         * @param string content
         * @return int
         */
        public function getData()
        {
            $outArray = $this->parseContent(1);
            $numPage = $outArray[count($outArray) - 1];
            $intNumPage = intval($numPage);
            return $intNumPage;
        }
    }
}
