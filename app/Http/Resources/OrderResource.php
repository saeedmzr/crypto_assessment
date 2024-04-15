<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CustomerSchema",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Customer ID"
 *     ),
 *     @OA\Property(
 *         property="Firstname",
 *         type="string",
 *         description="Customer Firstname"
 *     ),
 *     @OA\Property(
 *         property="Lastname",
 *         type="string",
 *         description="Customer Lastname"
 *     ),
 *      @OA\Property(
 *         property="DateOfBirth",
 *         type="string",
 *         description="Customer DateOfBirth"
 *     ),
 *     @OA\Property(
 *         property="Email",
 *         type="string",
 *         description="Customer Email"
 *     ),
 *     @OA\Property(
 *          property="PhoneNumber",
 *          type="string",
 *          description="Customer PhoneNumber"
 *      ),
 *     @OA\Property(
 *           property="BankAccountNumber",
 *           type="string",
 *           description="Customer BankAccountNumber"
 *       ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="datetime",
 *         description="Customer updated_at datetime"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="datetime",
 *         description="Customer created_at datetime"
 *     ),
 * )
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'tracking_code' => $this->tracking_code,
            'amount_paid' => $this->amount_paid . ': ' . $this->rate->secondCurrency->symbol ?? '',
            'amount_received' => $this->amount_received . ': ' . $this->rate->firstCurrency->symbol ?? '',
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
