
<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;

/* HOME *********************/
$app->get('/',function() use ($app) {
	$data = array('title' => 'Home',);
	return $app['twig']->render('home.twig',$data); 
})->bind('home');

/* GET ALL ARTICLES *********************/
$app->get('/articles',function() use ($app, $articles_model) {
	$all_articles = $articles_model->get_all_articles();
	$data = array('title' => 'Articles','all_articles' => $all_articles,);
	return $app['twig']->render('articles.twig',$data); 
})->bind('articles');

/* SHOW SELECTED ARTICLE *********************/
$app->match('/articles/{slug}',function($slug) use ($app, $articles_model) {
	$single_article = $articles_model->get_article($slug);
	$data = array('title' => $single_article->slug,'article' => $single_article,);
	return $app['twig']->render('article.twig',$data); 
}) ->assert('slug','[a-zA-Z0-9_-]+') ->bind('article');

/* SEARCH *********************/
$app->match('/search', function(Request $request) use($app, $articles_model) {
    $form_builder = $app['form.factory']->createBuilder('form'); 
    $form_builder->setAction($app['url_generator']->generate('search'));
    $form_builder->setMethod('post');
    $form_builder->add('word','text',array('max_length' => 50,'trim' => true,'error_bubbling' => true,));
    $form_builder->add('submit', 'submit',array('label' => 'ok',));
	$form = $form_builder->getForm();
    $form->handleRequest($request);

    if($form->isSubmitted()){
    	$form_data = $form->getData();

        if($form->isValid()){
	       	$inputresult = $articles_model->search($request->query->get('word'));
            $search_result = $articles_model->search($form_data['word']);
            $data = array('title' => 'Recherche','articles' => $inputresult,'result' => $search_result,);
            $data['form'] = $form->createView();
            return $app['twig']->render('search.twig',$data);
        }
    }
    
    $data['form'] = $form->createView();
    return $app['twig']->render('search.twig',$data);
})->assert('search','[a-z]+') ->bind('search');

/* TEST *********************/
$app->match('/test', function(Request $request) use($app, $articles_model) {
    $form_builder = $app['form.factory']->createBuilder('form'); 
    $form_builder->setAction($app['url_generator']->generate('test'));
    $form_builder->setMethod('post');
    $form_builder->add('title','text');
    $form_builder->add('preview','text');
    $form_builder->add('picture','text');
    $form_builder->add('slug','text');
    $form_builder->add('content','text');
    $form_builder->add('submit', 'submit',array('label' => 'Enregistrer',));
    $form = $form_builder->getForm();
    $form->handleRequest($request);

    if($form->isSubmitted()){
        $form_data = $form->getData();

        if($form->isValid()){
           
        }
    }
    
    $data['form'] = $form->createView();
    $data = array('title' => 'test');
    return $app['twig']->render('test.twig',$data);
})->assert('test','[a-z]+') ->bind('test');

/* ERROR *********************/
$app->error(function(\Exception $e,$code) use ($app) {
	if($app['debug']) return;
	$data = array('title' => 'Error');
	return $app['twig']->render('error.twig',$data); 
});
