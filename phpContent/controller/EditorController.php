<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 23.7.2015
 * Time: 10:54
 */

namespace controller;


use model\article\ArticleManager;

class EditorController extends Controller{

    private $model;

    public function __construct(){
        $this->model = new ArticleManager();
        $this->view = 'ArticleEditor';
        $this->header['title'] = 'Editor článkov';
        $this->header['description'] = 'Editor článkov';
        $this->header['keywords'] = 'editor, články';
    }

    /**
     * this is where magic happens
     * @param $params to be processed
     * @return mixed
     */
    public function process($params){
        if($_POST){
            $keys = array('article_id', 'article_url', 'article_content', 'article_key_words', 'article_description', 'article_title');
            $this->data['article'] = array_intersect_key($_POST, array_flip($keys));

            $this->model->saveArticle($this->data['article'], $this->data['article']['article_id']);
            $this->addSysMessage("Článok úspešne uložený");
            $this->redirect('article/'.$this->data['article']['article_url']);
        }
        elseif(!empty($params)){
            $article = $this->model->getArticleOne($params[0]);
            if($article){
                $this->data['article'] = $article;
            }
            else
                $this->addSysMessage('Článok nenájdený');
        }
    }
}