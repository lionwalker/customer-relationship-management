<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Logout",
 *     description="Logout model",
 *     @OA\Xml(
 *         name="Logout"
 *     )
 * )
 */
class Logout
{
    /**
     * @OA\Property(
     *     title="Message",
     *     description="Response message",
     *     example="Successfully logged out"
     * )
     *
     * @var integer
     */
    private $message;
}
