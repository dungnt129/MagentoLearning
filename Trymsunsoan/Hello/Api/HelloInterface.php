<?php
namespace Trymsunsoan\Hello\Api;

interface HelloInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function name($name);

    /**
     * @return string
    */
    public function getProduct();

    /*
     * @return string
     * */
    public function sum( $nums );
}