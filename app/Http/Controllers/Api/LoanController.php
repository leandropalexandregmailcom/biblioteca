<?php

namespace App\Http\Controllers\Api;

use App\Models\Loan;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Loan API",
 *     version="1.0.0",
 *     description="API for managing loans"
 * )
 */

/**
 * @OA\Tag(
 *     name="Loans",
 *     description="Endpoints for managing loans"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Loan",
 *     type="object",
 *     required={"user_id", "book_id", "loan_date"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="book_id", type="integer", example=1),
 *     @OA\Property(property="loan_date", type="string", format="date"),
 *     @OA\Property(property="return_date", type="string", format="date"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class LoanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/loanIndex",
     *     summary="List all loans",
     *     tags={"Loans"},
     *     @OA\Response(
     *         response=200,
     *         description="List of loans",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Loan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function loanIndex()
    {
        return LoanResource::collection(Loan::all());
    }

    /**
     * @OA\Post(
     *     path="/loanStore",
     *     summary="Create a new loan",
     *     tags={"Loans"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "book_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=1),
     *             @OA\Property(property="return_date", type="string", format="date", example="2024-08-26")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Loan created",
     *         @OA\JsonContent(ref="#/components/schemas/Loan")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function loanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'return_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => now(),
            'return_date' => $request->return_date,
        ]);

        return new LoanResource($loan);
    }

    /**
     * @OA\Get(
     *     path="/loanShow/{id}",
     *     summary="Get a specific loan",
     *     tags={"Loans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Loan details",
     *         @OA\JsonContent(ref="#/components/schemas/Loan")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Loan not found"
     *     )
     * )
     */
    public function loanShow($id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        return new LoanResource($loan);
    }

    /**
     * @OA\Put(
     *     path="/loanUpdate/{id}",
     *     summary="Update a loan",
     *     tags={"Loans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"book_id"},
     *             @OA\Property(property="book_id", type="integer", example=1),
     *             @OA\Property(property="return_date", type="string", format="date", example="2024-08-26")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Loan updated",
     *         @OA\JsonContent(ref="#/components/schemas/Loan")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Loan not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function loanUpdate(Request $request, $id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:books,id',
            'return_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan->update([
            'book_id' => $request->book_id,
            'return_date' => $request->return_date,
        ]);
        return new LoanResource($loan);
    }

    /**
     * @OA\Delete(
     *     path="/loanDestroy/{id}",
     *     summary="Delete a loan",
     *     tags={"Loans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Loan deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Loan not found"
     *     )
     * )
     */
    public function loanDestroy($id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        $loan->delete();
        return response()->json(null, 204);
    }
}
