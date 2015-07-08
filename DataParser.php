<?php

namespace AutoRu\Parse {
    require_once("AbstractParser.php");
    /**
     * @property string pattern
     */
    class DataParser extends AbstractParser
    {
        private $reFeedback;
        private $reHead;
        private $reRaiting;
        private $reModel;
        private $reDate;
        private $reAuthor;
        private $reYesNo;
        private $reLink;
        /**
         * Устанавливает необходимые шаблоны
         */
        function __construct()
        {
            //Шаблон для Тело отзыва
            $this->reFeedback = "/<tr class..b-opinion-list-row.+?\<\/tr>/s";
            //Шаблон для Заголовок
            $this->reHead = "/<a href=\"\/review\/.+?\.html\">(.+?)<\/a>/s";
            //Шаблон для Рейтинг $output_array[1][1]
            $this->reRaiting = "/<span itemprop=\"ratingValue\">([0-9,]+)<\/span>/s";
            //Шаблон для Модификация авто $output_array[1][1]
            //string strip( string $str )
            $this->reModel = "/<div class=\"b-opinion-list-details\">(.+)<br \/>/s";
            //Шаблон для Дата публикации $output_array[1][1]
            $this->reDate = "/<span class=\"b-opinion-list-details-d\">([^,]+)/s";
            //Шаблон для Автор $output_array[1][1]
            $this->reAuthor = "/автор: (.+?)<\/span>/s";
            //Шаблон для Да/Нет
            $this->reYesNo = "/<td class=\"b-utility\">.*?<span class=\".*?\">[^0-9]*?([0-9]+?)<\/span> .*?<span class=\".*?\">[^0-9]*?([0-9]+?)<\/span>.*?<\/td>/s";
            //Шаблон для ссылки на детальный отзыв
            $this->reLink = "/ <a href=\"(\/review\/[0-9]+.html)\">/s";
        }
        /**
         * Получает по странице данные по каждому отзыву
         *
         * @return array
         */
        private function parseCurrentFeedback($pattern)
        {
            $this->setPattern($pattern);
            $a = $this->parseContent(1);
            return !empty($a) ? $a[0] : "";
        }

        /**
         * Парсит странизу и возвращает параметры отзывов в виде массива
         *
         * @return array
         */
        public function getData()
        {
            //preg_match_all("", $downloaded_page, $arr1);
            $this->setPattern($this->reFeedback);
            $feedbacks = $this->parseContent();
            $data = array();
            foreach($feedbacks as $feedback)
            {
                $feedbackData = array();
                $this->setContent($feedback);
                $feedbackData["head"] = $this->parseCurrentFeedback($this->reHead);
                $feedbackData["raiting"] = $this->parseCurrentFeedback($this->reRaiting);
                $feedbackData["model"] = trim($this->parseCurrentFeedback($this->reModel));
                $feedbackData["date"] = $this->parseCurrentFeedback($this->reDate);
                $feedbackData["author"] = $this->parseCurrentFeedback($this->reAuthor);
                $feedbackData["link"] = $this->parseCurrentFeedback($this->reLink);
                $feedbackData["yes"] = $this->parseCurrentFeedback($this->reYesNo);
                $a = $this->parseContent(2);
                $feedbackData["no"] = !empty($a) ? $a[0] : "";
                $data[] = $feedbackData;
            }
            return $data;
        }
    }
}
