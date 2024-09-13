<?php

namespace Core;

require __DIR__."/../../vendor/autoload.php" ;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;



class AbstrcatController
{
    use ContainerAwareTrait ;

    protected  $loader ;
    protected  $twig   ;
    protected  $containerBuilder ;

    public function __construct($template_path)
    {

        $this->loader = new FilesystemLoader(array(__DIR__."/../../public",$template_path ) );
        $this->twig = new Environment($this->loader ,
                    array('debug'      => true ,
                         'auto_reload' => false  ,
                         'cache' => __DIR__."/../../cache"
                    ));
        $this->twig->addExtension(new DebugExtension());
        $this->init();
    }

    public function renderViewTwig(string $path_template_twig , $array ){
        $template = $this->twig->load($path_template_twig);
        $render = $template->render( $array );
        return new Response($render);
    }

    public function renderViewPhp(string $path_template_php , $data ){

        $response = new Response() ;
        ob_start();
        include $path_template_php ;
        $response->setContent(ob_get_clean());
        return $response ;

    }

}