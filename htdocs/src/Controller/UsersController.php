<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserLog;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as V;

class UsersController
{
    /** @var \Slim\Views\Twig */
    protected $view;

    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;


    protected $router;

    /**
     * UsersController constructor.
     *
     * @param $view
     * @param $db
     */
    public function __construct($view, $db, $router) {
        $this->view = $view;
        $this->db = $db;
        $this->router = $router;
    }

    /**
     * @param RequestInterface|\Slim\Http\Request $request
     * @param ResponseInterface|\Slim\Http\Response $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function index($request, $response, $args)
    {
        //$users = User::all();
        $users = User::with('userLogs')->get();

        return $this->view->render($response, 'users/index.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param RequestInterface|\Slim\Http\Request $request
     * @param ResponseInterface|\Slim\Http\Response $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function detail($request, $response, $args)
    {
        $id = $args['id'];
        $user = User::find($id);
        //$user = User::where('id', $id)->first();
        //$user = User::findOrFail($id);

        return $this->view->render($response, 'users/detail.twig', [
            'user' => $user
        ]);
    }

    /**
     * @param RequestInterface|\Slim\Http\Request $request
     * @param ResponseInterface|\Slim\Http\Response $response
     * @param array $args
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function create($request, $response, $args)
    {
        $this->db->getConnection()->transaction(function () {
            $user = new User();
            $user->name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);
            $user->save();
        });

        return $response->withRedirect($this->router->pathFor('users.index'));
    }
}