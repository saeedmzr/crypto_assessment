<?php

namespace Domains\Customer\Http\Controllers\Api;

use App\Http\Requests\CustomerDeleteRequest;
use App\Http\Requests\FindOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Domains\Customer\Http\Resources\CustomerResource;
use Domains\Customer\Services\CustomerService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{

    public function __construct(private CustomerService $customerService)
    {
    }

    /**
     * @OA\Get(
     *     path="/customers",
     *     summary="Get a paginated list of customers",
     *                    tags={"customer Management"},
     *     description="Retrieves a list of customers.",

     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/CustomerSchema")),
     *         ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        $customers = $this->customerService->getCustomers();
        return self::successResponse(
            CustomerResource::collection($customers),
            'Customers List has been generated successfully.',
        );
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
        $customer = $this->customerService->getCustomerById(['customerId' => $request->id]);
        return self::successResponse(
            new CustomerResource($customer),
            'Customer show has been generated successfully.',
        );
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
        $customer = $this->customerService->createCustomer($request->validated());

        return self::successResponse(
            new CustomerResource($customer),
            'Customer has been created successfully.', 201);
    }

    /**
     * @OA\Put(
     *     path="/customers/{customerId}",
     *     summary="Update a customer",
     *     description="Updates an existing customer with the provided details.",
     *               tags={"customer Management"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         description="ID of the customer to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerSchema"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden: Could not update this customer"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="customer not found"
     *     )
     * )
     */
    public function update(CustomerUpdateRequest $request, $customerId): JsonResponse
    {
        $this->customerService->updateCustomer($request->validated(), $customerId);
        $customer = $this->customerService->getCustomerById(['customerId' => $customerId]);
        return self::successResponse(
            new CustomerResource($customer),
            'Customer has been updated successfully.');
    }
    /**
     * @OA\Delete(
     *     path="/customers/{customerId}",
     *     summary="Delete a customer",
     *     description="Deletes a customer with the provided ID.",
     *               tags={"customer Management"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         description="ID of the customer to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="customer deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="customer not found"
     *     )
     * )
     */
    public function destroy(CustomerDeleteRequest $request): JsonResponse
    {
        $customer = $this->customerService->getCustomerById(['customerId' => $request->id]);
        $this->customerService->deleteCustomer($request->id);
        return self::successResponse(
            new CustomerResource($customer),
            'Customer has been deleted successfully.');
    }
}
