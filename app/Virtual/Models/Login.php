<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Login",
 *     description="Login model",
 *     @OA\Xml(
 *         name="Login"
 *     )
 * )
 */
class Login
{

    /**
     * @OA\Property(
     *     title="Message",
     *     description="Response message",
     *     example="Successfully logged in"
     * )
     *
     * @var integer
     */
    private $message;

    /**
     * @OA\Property(
     *      title="Token",
     *      description="Token of logged in user",
     *      example="1|DFhE1owmYYobMAMgfILjSRuMZz0BRkgqQn3tdvvd"
     * )
     *
     * @var string
     */
    public $token;
}
