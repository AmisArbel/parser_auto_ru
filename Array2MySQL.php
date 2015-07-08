<?php

namespace AutoRu\SQL {
    /**
     * @property SimpleXMLElement xml_feedbacks
     */
    class Array2MySQL
    {
        /**
         * Создает подключение к БД
         */
        function __construct()
        {
            $this->mysqli = new \mysqli('localhost', 'root', '', 'test');
            if (\mysqli_connect_errno()) {
                printf("Подключение невозможно: %s\n", mysqli_connect_error());
                exit();
            }
        }

        /**
         * Устанавливает массив для дальнейшего сохранения
         * @param $array
         */
        public function setArray($array)
        {
            $this->array = $array;
        }

        /**
         * Сохраняет данные из массива в БД
         */
        public function save2DB()
        {
            $stmt = $this->mysqli->prepare("INSERT INTO feedbacks (head, raiting, model, date, author, link, yes, no) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
            $stmt->bind_param('ssssssss', $head, $raiting, $model, $date, $author, $link, $yes, $no);
            $this->mysqli->query("SET NAMES utf8");
            foreach($this->array as $item) {
                $head = $item["head"];
                $raiting = $item["raiting"];
                $model = $item["model"];
                $date = $item["date"];
                $author = $item["author"];
                $link = $item["link"];
                $yes = $item["yes"];
                $no = $item["no"];
                $stmt->execute();
            }
            $stmt->close();
            $this->mysqli->close();
        }
    }
}
