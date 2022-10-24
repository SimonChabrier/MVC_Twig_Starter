<?php

namespace App\Controllers;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends CoreController{

    public function __construct() 
    {
        parent::__construct();
        $this->user = new User();
    }

    /**
     * Display home page
     * @return User
     */
    public function home()
    {
        $users = $this->user->findAll();
        $user = $this->user->findById(1);

        echo $this->twig->render('home/index.html.twig', compact('users', 'user')); 
    }

    /**
     * Display create page
     * @return void
     */
    public function create()
    {

        $this->user

        ->setFirstname('Jean')
        ->setLastname('Claude')
        ->setUsername('jeanclaude')
        ->setEmail('user@user.fr')
        ->setPassword('password')
        ->setRole('ROLE_USER')
        ->save();

        $response = new RedirectResponse('/', 302);
        return $response->send();

    }

    /**
     * Display update page
     * @return void
     */
    public function delete (array $params) 
    {

        $this->user->findById($params['id']);
        $this->user->delete($params['id']);

        $response = new RedirectResponse('/', 302);
        return $response->send();
    }

    /**
     * Display update page
     * @return void
     */
    public function update (array $params) 
    {

        $this->user->findById($params['id'])

        ->setFirstname('Jean2')
        ->setLastname('Claude2')
        ->setUsername('jeanclaude2')
        ->setEmail('user@user.fr')
        ->setPassword('password')
        ->setRole('ROLE_USER')

        ->update($params['id']);

        $response = new RedirectResponse('/', 302);
        return $response->send();

    }    

    public function json()
    {
        $users = $this->user->findAll();

        foreach ($users as $user) {

            $data[] = [
                'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $user->getRole(),
            ];
        }
        
        $response = new Response();
        $response->setContent(json_encode([
            'data' => $data
        ]));
        
        $response->headers->set('Content-Type', 'application/json');
        return $response->send();
    }
}