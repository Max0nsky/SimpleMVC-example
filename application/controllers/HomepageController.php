<?php

namespace application\controllers;

use \application\models\Article as Article;
use \application\models\Category as Category;
use \application\models\Subcategory as Subcategory;
use ItForFree\SimpleMVC\Config;


class HomepageController extends \ItForFree\SimpleMVC\mvc\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";

    public $layoutPath = 'main.php';

    /**
     * Вывод домашней ("главной") страницы сайта и списка статей
     */
    public function indexAction()
    {

        $Article = new Article;

        // Проверка условия выборки по категории/подкатегории либо вывод всех статей
        if (isset($_GET['categoryId'])) {
            $results = $Article->getActiveList(1000000, $_GET['categoryId'], null);
        } elseif (isset($_GET['subcategoryId'])) {
            $results = $Article->getActiveList(1000000, null, $_GET['subcategoryId']);
        } else {
            $results = $Article->getActiveList();
        }
        foreach ($results['results'] as $article) {
            $results['articles'][$article->id] = $article;
        }

        $Category = new Category();
        foreach ($Category->getList()['results'] as $category) {
            $results['categories'][$category->id] = $category;
        }

        $Subcategory = new Subcategory();
        foreach ($Subcategory->getList()['results'] as $subcategory) {
            $results['subcategories'][$subcategory->id] = $subcategory;
        }

        $results['pageTitle'] = "Простая CMS на PHP";

        $this->view->addVar('results', $results);
        $this->view->addVar('homepageTitle', $this->homepageTitle);
        $this->view->render('homepage/index.php');
    }

    /**
     * Вывод одной статьи по её id
     */
    public function viewOneArticleAction()
    {
        $Article = new Article;
        $results['article'] = $Article->getById($_GET['id']);
        $results['authors'] = $Article->getAuthorsById($results['article']->id);

        $Category = new Category;
        $results['category'] = $Category->getById($results['article']->categoryId);

        $Subcategory = new Subcategory();
        $results['subcategory'] = $Subcategory->getById($results['article']->subcategoryId);

        $this->view->addVar('results', $results);
        $this->view->render('homepage/viewArticle.php');
    }

}
