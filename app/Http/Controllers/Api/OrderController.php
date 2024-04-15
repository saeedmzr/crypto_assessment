<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FindOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseController
{

    public function __construct(private OrderRepository $orderRepository, private OrderService $orderService)
    {
    }

    /**
     * @OA\Get(
     *     path="/customers/{customerId}",
     *     summary="Get a customer by ID",
     *     description="Retrieves a single customer identified by its ID.",
     *     tags={"customer Management"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         description="ID of the customer",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CustomerSchema"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function show(FindOrderRequest $request): JsonResponse
    {

        try {
            $customer = $this->orderRepository->getOrderbyTrackingCode($request->tracking_code);
            return self::successResponse(
                new OrderResource($customer),
                'Customer show has been generated successfully.',
            );
        } catch (\Exception $exception) {
            return self::errorResponse();
        }

    }

    /**
     * @OA\Post(
     *     path="/customers",
     *     summary="Create a new customer",
     *     description="Creates a new customer with the provided details.",
     *               tags={"customer Management"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateCustomerSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="customer created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerSchema"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors"
     *     )
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
//        try {
            $order = $this->orderService->createOrder($request->validated());

            return self::successResponse(
                new orderResource($order),
                'Order has been created successfully.', 201);
//        } catch (\Exception) {
//            return self::errorResponse();
//        }

    }

}
