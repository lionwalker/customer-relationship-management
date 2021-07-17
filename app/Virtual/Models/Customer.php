<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Customer",
 *     description="Customer model",
 *     @OA\Xml(
 *         name="Customer"
 *     )
 * )
 */
class Customer
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="First Name",
     *      description="First name of the new customer",
     *      example="John"
     * )
     *
     * @var string
     */
    public $first_name;

    /**
     * @OA\Property(
     *      title="Last Name",
     *      description="Last name of the new customer",
     *      example="Doe"
     * )
     *
     * @var string
     */
    public $last_name;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email of the new customer",
     *      example="admin@admin.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="Phone Number",
     *      description="Phone number of the new customer",
     *      example="94773333333"
     * )
     *
     * @var string
     */
    public $phone_number;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2021-01-01 00:00:01",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2021-01-01 00:00:01",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;
}
