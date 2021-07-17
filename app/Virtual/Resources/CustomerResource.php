<?php


namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="CustomerResource",
 *     description="Customer resource",
 *     @OA\Xml(
 *         name="CustomerResource"
 *     )
 * )
 */
class CustomerResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Customer[]
     */
    private $data;
}
