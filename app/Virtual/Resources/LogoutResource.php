<?php


namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="LogoutResource",
 *     description="Logout resource",
 *     @OA\Xml(
 *         name="LogoutResource"
 *     )
 * )
 */
class LogoutResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Logout[]
     */
    private $data;
}
