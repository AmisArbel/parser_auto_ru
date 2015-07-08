<?php

namespace AutoRu\Parse {
    /**
     * @property  pattern
     * @property  content
     */
    abstract class AbstractParser
    {
        protected $pattern;
        protected $content;
        /**
         * Устанавливает параметр pattern
         *
         * @param string pattern
         */
        public function setPattern($pattern)
        {
            $this->pattern = $pattern;
        }
        /**
         * Устанавливает параметр content
         *
         * @param string content
         */
        public function setContent ($content)
        {
            $this->content = $content;
        }
        /**
         * Парсит контент по шаблону и возвращат указанный массив результатов
         *
         * @param int numArray
         * @return array
         */
        protected function parseContent ( $numArray = 0 )
        {
            preg_match_all($this->pattern, $this->content, $outArray);
            return !empty($outArray) ? $outArray[$numArray] : array();
        }
        /**
         * Извлекает из контента нужные данные
         *
         * @param string content
         * @return string/int/array
         */
        abstract public function getData ();
    }
}
