<?php


namespace App\Contracts\Applications;


use App\Application;
use App\SendGridKey;

interface SendGridRepository
{

    /**
     * @param  int  $id
     *
     * @return \App\SendGridKey
     */
    public function get(int $id): SendGridKey;

    /**
     * @param  array  $data
     * @param  \App\Application  $application
     *
     * @return array
     */
    public function store(array $data, Application $application): array;

    /**
     * @throws \Throwable
     *
     * @param  int  $id
     * @param  array  $data
     *
     * @return \App\SendGridKey
     */
    public function update(int $id, array $data): SendGridKey;

    /**
     *
     * @throws \Exception
     *
     * @param  int  $id
     *
     * @return bool|mixed|null
     */
    public function delete(int $id): bool;
}
