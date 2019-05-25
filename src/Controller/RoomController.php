<?php

namespace App\Controller;

use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{


    /**
     * @Route("/room/list", name="room_list", methods={"GET","OPTIONS"})
     */

    public function list(EntityManagerInterface $em)
    {

        $films = $em->getRepository(Film::class)->findAll();

        $result = [];

        foreach ($films as $film) $result[] = $film->toJson();

        return $this->json(['success' => true, 'items' => $result]);

    }


    /**
     * @Route("/room/create", name="room_create", methods={"POST","OPTIONS"})
     */

    public function create(Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['user']) || !isset($data['film_id']) || !isset($data['link']))
            return $this->json(['success' => false, 'message' => "Faltan parámetros"]);

        $user = $data['user'];
        $filmId = $data['film_id'];
        $link = $data['link'];


        //LOOP PORT POOL
        for ($port = 8000; $port <= 9000; $port++) {

            //CHECK IF PORT IS OCCUPIED
            $check = shell_exec("netstat -anp | grep $port");

            if (strlen($check) === 0) {

                //START A PEERFLIX PROCESS IN BACKGROUND WITH THE FREE PORT
                $command = "peerflix '$link' -h 0.0.0.0 -p $port";
                shell_exec("pm2 start \"$command\" --name \"$port\"");

                //KILL PROCESS IN 3 HOURS
                shell_exec("echo \"pm2 delete $port\" | at now + 3 hour ");

                $film = new Film();
                $film->setCreated(new \DateTime());
                $film->setLink($link);
                $film->setFilmId($filmId);
                $film->setUser($user);
                $film->setPort($port);


                $em->persist($film);
                $em->flush();

                return $this->json(['success' => true, 'film' => $film->toJson()]);
            }
        }

        return $this->json(['success' => false, 'message' => "No hay puertos disponibles. Inténtelo de nuevo mas tarde"]);

    }


}
