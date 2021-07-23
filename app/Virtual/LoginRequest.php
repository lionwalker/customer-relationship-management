<?php


namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Login user request",
 *      description="Login user request body data",
 *      type="object",
 *      required={"email","password"}
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the user",
     *      example="admin@admin.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="passowrd of the customer",
     *      example="Admin@123"
     * )
     *
     * @var string
     */
    public $password;
}
