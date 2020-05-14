<?php

namespace application\models;

/**
 * Класс для обработки статей
 */
class Article extends BaseExampleModel
{
  // Свойства
  /**
   * @var string Название таблицы
   */
  public $tableName = 'articles';

  /**
   * @var string Критерий сортировки
   */
  public $orderBy = 'publicationDate DESC';

  /**
   * @var int ID статей из базы данны
   */
  public $id = null;

  /**
   * @var int Дата первой публикации статьи
   */
  public $publicationDate = null;

  /**
   * @var string Полное название статьи
   */
  public $title = null;

  /**
   * @var int ID категории статьи
   */
  public $categoryId = null;

  /**
   * @var int ID подкатегории статьи
   */
  public $subcategoryId = null;

  /**
   * @var string Краткое описание статьи
   */
  public $summary = null;

  /**
   * @var string HTML содержание статьи
   */
  public $content = null;

  /**
   * @var string Возможность просмотра статьи
   */
  public $active = null;

  /**
   * @var string Авторы статьи
   */
  public $authors = [];

  /**
   * Возвращает все (или диапазон) объекты Article из базы данных
   *
   * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
   * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
   */
  public function getActiveList($numRows = 1000000, $categoryId = null, $subcategoryId = null)
  {
    if ($categoryId) {
      $clause = "active = 1 AND categoryId = :categoryId";
    } elseif ($subcategoryId) {
      $clause = "active = 1 AND subcategoryId = :subcategoryId";
    } else {
      $clause = "active = 1";
    }

    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) 
            AS publicationDate
            FROM $this->tableName
            WHERE $clause
            ORDER BY $this->orderBy 
            LIMIT :numRows";

    $st = $this->pdo->prepare($sql);

    $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
    if ($categoryId) {
      $st->bindValue(":categoryId", $categoryId, \PDO::PARAM_INT);
    } elseif ($subcategoryId) {
      $st->bindValue(":subcategoryId", $subcategoryId, \PDO::PARAM_INT);
    }
    $st->execute();

    $modelClassName = static::class;

    $list = array();
    while ($row = $st->fetch()) {
      $article = new $modelClassName($row);
      $list[] = $article;
    }

    // Получаем общее количество статей, которые соответствуют критерию
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $this->pdo->query($sql)->fetch();

    return (array(
      "results" => $list,
      "totalRows" => $totalRows[0]
    ));
  }

  /**
   * Получаем имена авторов по id статьи
   */
  public function getAuthorsById($id)
  {
    $sql = "SELECT users.login FROM users_articles 
              LEFT JOIN users ON idUser = users.id 
              WHERE users_articles.idArticle = :id ";
    $st = $this->pdo->prepare($sql);
    $st->bindValue(":id", $id, \PDO::PARAM_INT);
    $st->execute();
    $list = array();
    while ($row = $st->fetch()) {
      $list[] = $row['login'];
    }

    return $list;
  }
}
