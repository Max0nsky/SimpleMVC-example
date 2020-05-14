<?php

use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
?>

<div class="row">
  <div class="col ">
    <h1><?php echo $homepageTitle ?></h1>
  </div>
</div>
<ul id="headlines">
  <?php foreach ($results['results'] as $article) { ?>
    <li class='<?php echo $article->id ?>'>
      <h2>
        <span class="pubDate">
          <?php echo date('j F', $article->publicationDate) ?>
        </span>
        <a href="<?= $Url::link("homepage/viewOneArticle&id=" . $article->id) ?>">
          <?php echo htmlspecialchars($article->title) ?>
        </a>

        <?php if (isset($article->categoryId)) { ?>
          <span class="category">
            Категория:
            <a href="<?= $Url::link("&categoryId=" . $article->categoryId) ?>">
              <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name) ?>
            </a>
          </span>
          <span class="category">
            Подкатегория:
            <a href="<?= $Url::link("&subcategoryId=" . $article->subcategoryId) ?>">
              <?php echo htmlspecialchars($results['subcategories'][$article->subcategoryId]->name) ?>
            </a>
          </span>
        <?php } else { ?>
          <span class="category">
            <?php echo "Без категории" ?>
          </span>
        <?php } ?>
      </h2>
      <p class="summary<?php echo $article->id ?>"><?php echo mb_substr(htmlspecialchars($article->content), 0, 50) . "..." ?></p>
      <img id="loader-identity" src="JS/ajax-loader.gif" alt="gif">

      <ul class="ajax-load">
        <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>" class="ajaxArticleBodyByPost" data-contentId="<?php echo $article->id ?>">Показать продолжение (POST)</a></li>
        <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>" class="ajaxArticleBodyByGet" data-contentId="<?php echo $article->id ?>">Показать продолжение (GET)</a></li>
        <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>" class="my_ajaxArticleBodyByPost" data-contentId="<?php echo $article->id ?>">(POST) -- NEW</a></li>
        <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>" class="my_ajaxArticleBodyByGet" data-contentId="<?php echo $article->id ?>">(GET) -- NEW</a></li>
      </ul>
      <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>" class="showContent" data-contentId="<?php echo $article->id ?>">Показать полностью</a>
    </li>
  <?php } ?>
</ul>
<p><a href="./?action=archive">Article Archive</a></p>