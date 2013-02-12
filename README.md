![Siesta](http://icecave.com.au/assets/img/project-icons/icon-siesta.png)<br>&nbsp;&nbsp;
[![Build Status](https://api.travis-ci.org/IcecaveStudios/siesta.png)](http://travis-ci.org/IcecaveStudios/siesta)

---

**Siesta** is a small RESTful API framework aimed at ultimate testability.

## Installation

Available as [Composer](http://getcomposer.org) package [icecave/siesta](https://packagist.org/packages/icecave/siesta).

```php
<?php

class UserEndpoint implements EndpointInterface
{
    public function index($sort = null)
    {
        $response = array();
        foreach (Domain\User::findAll() as $user) {
            $response[] = new UserRepr($user);
        }
        return $response;
    }

    public function get($id)
    {
        $user = Domain\User::find($id);
        return new UserRepr($user);
    }

    public function put($id, $name = null, $email = null, $homepage = null)
    {
        $user = Domain\User::find($id);
        $user->setName($name);
        $user->setEmail($email);
        $user->setHomePage($homepage);
    }

    public function post($name, $email, $homepage = null)
    {
        $user = new Domain\User($name, $user, $homepage);
        return new UserRepr($user);
    }
}

// get = get
// post = create
// put = update

$r = new Router;
$r->get('/user/:id?', new UserEndPoint);
$r->put('/user/:id', new )

$endpoint = $router->resolve($request);
$endpoint->execute($request, $response);

```