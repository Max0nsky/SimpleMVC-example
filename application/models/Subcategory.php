<?php

namespace application\models;

/**
 * Класс для обработки категорий статей
 */
class Subcategory extends BaseExampleModel
{
  // Свойства

  /**
   * @var string Название таблицы
   */
  public $tableName = 'subcategory';

  /**
   * @var string Критерий сортировки
   */
  public $orderBy = 'name ASC';

  /**
   * @var int ID связанной категории из базы данных
   */
  public $id = null;

  /**
   * @var int ID подкатегории из базы данных
   */
  public $idCategory = null;

  /**
   * @var string Название категории
   */
  public $name = null;

  /**
   * @var string Короткое описание категории
   */
  public $description = null;

}
