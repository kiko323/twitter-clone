<?php
// src/Controller/LuckyController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TestController extends controller
{
    /**
     * @Route("/test/")
     */

    public function useri(Connection $conn)
    {

        return new Response('Helllo');


    }
}

?>