<?php

/**
 * An endpoint 
 */
class CompanyWorkerEndpoint
{
    /**
     * The index method serves get requests that do not specify and ID.
     */
    public function index($company)
    {
        return Domain\Worker::findAllByCompany($company);
    }

    /**
     * The get method serves get requests that DO specify an ID
     */
    public function get($company, $id)
    {
        return Domain\Worker::findByCompanyAndId($companty, $id);
    }

    /**
     * Post parameters are unrolled into regular method parameters.
     */
    public function post($company, $name, $description)
    {
        $worker = new Domain\Worker;
        $worker->setCompany($company);
        $worker->setName($name);
        $worker->setDescription($description);
        $worker->save();
        return $worker;
    }

    /**
     * As are put parameters.
     */
    public function put($company, $id, $name, $description)
    {
        $worker = Domain\Worker::findByCompanyAndId($companty, $id);
        if ($worker) {
            $worker->setName($name);
            $worker->setDescription($description);
        } else {
            throw new ResourceNotFoundException;
        }
    }

    public function delete($company, $id)
    {
        $worker = Domain\Worker::findByCompanyAndId($companty, $id);
        $worker->delete();
    }
}

// The variable names (:company and :id) are matched against the parameter names from the methods on the endpoint.
// The ? indicates that :id is an optional parameter
$router->route('/companies/:company/workers/:id?', new CompanyWorkerEndpoint);
