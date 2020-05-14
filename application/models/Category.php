<?php

namespace application\models;

/**
 * Класс для обработки категорий статей
 */
class Category extends BaseExampleModel
{
  // Свойства

  /**
  * @var string Название таблицы
  */
  public $tableName = 'categories';
  
  /**
  * @var string Критерий сортировки
  */
  public $orderBy = 'name ASC';

  /**
   * @var int ID категории из базы данных
   */
  public $id = null;

  /**
   * @var string Название категории
   */
  public $name = null;

  /**
   * @var string Короткое описание категории
   */
  public $description = null;

}
