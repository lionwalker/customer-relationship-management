<?php


namespace App\Virtual;

use phpDocumentor\Reflection\File;

/**
 * @OA\Schema(
 *      title="Store Customer request",
 *      description="Store Customer request body data",
 *      type="object",
 *      required={"first_name","last_name","email","phone_number"}
 * )
 */
class CreateCustomerRequest
{
    /**
     * @OA\Property(
     *      title="first_name",
     *      description="First name of the new customer",
     *      example="John"
     * )
     *
     * @var string
     */
    public $first_name;

    /**
     * @OA\Property(
     *      title="last_name",
     *      description="Last name of the new customer",
     *      example="Doe"
     * )
     *
     * @var string
     */
    public $last_name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the new customer",
     *      example="admin@admin.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="phone_number",
     *      description="Phone number of the new customer",
     *      example="94773333333"
     * )
     *
     * @var string
     */
    public $phone_number;
}
