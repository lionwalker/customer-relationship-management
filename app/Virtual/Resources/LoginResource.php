<?php


namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="LoginResource",
 *     description="Login resource",
 *     @OA\Xml(
 *         name="LoginResource"
 *     )
 * )
 */
class LoginResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Login[]
     */
    private $data;
}
