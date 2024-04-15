<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="CreateCustomerSchema",
 *     @OA\Property(
 *         property="Firstname",
 *         type="string",
 *         description="customer's Firstname"
 *     ),
 *     @OA\Property(
 *         property="Lastname",
 *         type="string",
 *         description="customer's Lastname"
 *     ),
 *     @OA\Property(
 *         property="DateOfBirth",
 *         type="date",
 *         description="customer's DateOfBirth"
 *     ),
 *    @OA\Property(
 *          property="BankAccountNumber",
 *          type="string",
 *          description="customer's BankAccountNumber"
 *      ),
 *     @OA\Property(
 *         property="PhoneNumber",
 *         type="phonenumber",
 *         description="customer's PhoneNumber"
 *     ),
 *          @OA\Property(
 *          property="Email",
 *          type="email",
 *          description="customer's Email"
 *      ),
 * )
 */
class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'email' => 'required|string|email',
            'origin_currency_id' => 'required|exists:currencies,id',
            'destination_currency_id' => 'nullable||exists:currencies,id',
            'amount' => 'nullable|alpha_dash|max:32',
        ];
    }
}
