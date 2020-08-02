<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function index()
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }

    /**
     * @Route("/hello/{name}", name="app_hello_hellomanytimes")
     *
     * @param $name
     *
     * @return Response
     */
    public function hello(string $name)
    {
        return $this->render('hello/hello.html.twig', [
            'name' => $name,
        ]);
    }

    /**
     * @Route("/hello/{name}/{times}", name="app_hello_hellomanytimes", requirements={"times"="\d+"})
     *
     * @param string $name
     * @param int $times
     *
     * @return Response
     */
    public function helloManyTimes(string $name, int $times = 3)
    {
        return $this->render('hello/hellomanytimes.html.twig', [
            'name' => $name,
            'times' => $times,
        ]);
    }
}
