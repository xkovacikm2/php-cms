<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 17.7.2015
 * Time: 8:23
 */

namespace model\article;
use model\database\DBHelper;

class ArticleManager {
    /**
     * @param $url of the article
     * @return mixed processed article pulled from db
     */
    public function getArticleOne($url){
        return DBHelper::fetch(
            'SELECT `article_id`, `article_title`, `article_content`, `article_key_words`, `article_description`, `article_url`
            FROM `mvc_articles`
            WHERE `article_url` = ?',
        array($url));
    }

    /**
     * @return array of articles pulled from db
     */
    public function getArticlesAll(){
        return DBHelper::fetchAll(
            'SELECT `article_id`, `article_title`, `article_description`, `article_url`
            FROM `mvc_articles`
            ORDER BY `article_id` DESC');
    }

    /**
     * Inserts new article into db if no id is given, else updates existing article
     * @param $article
     * @param int $id
     */
    public function saveArticle($article, $id=0){
        if($id==0){
            DBHelper::insert("mvc_articles", $article);
        }
        else{
            DBHelper::update("mvc_articles", $article, "WHERE article_id = ?", array($id));
        }
    }

    /**
     * Deletes article with given url from db
     * @param $url
     */
    public function deleteArticle($url){
        DBHelper::query("DELETE FROM `mvc_articles`
        WHERE `article_url` = ?", array($url));
    }
}