<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 17.7.2015
 * Time: 8:59
 */

namespace controller;
use model\article\ArticleManager;

class ArticleController extends Controller{

    private $articleManager;

    public function __construct(){
        $this->articleManager = new ArticleManager();
    }

    /**
     * this is where magic happens
     * @param $params to be processed
     * @return mixed
     */
    public function process($params){
        if(!empty($params[0]))
            $this->processOne($params);
        else
            $this->processAll();
    }

    private function processOne($params){
        $article = $this->articleManager->getArticleOne($params[0]);

        if (!$article)
            $this->redirect('error');

        $this->header = array(
            title => $article['article_title'],
            description => $article['article_description'],
            keywords => $article['article_key_words']
        );
        $this->data = array(
            article_title => $article['article_title'],
            article_content => $article['article_content']
        );
        $this->view = 'Article';
    }

    private function processAll(){
        $articles = $this->articleManager->getArticlesAll();
        $this->data['articles'] = $articles;
        $this->view = 'ArticleList';
        $this->header = array(
            title => 'Zoznam článkov',
            description => 'Zoznam článkov na našom webe',
            keywords => 'články, zoznam, list, rozcestník'
        );
    }
}