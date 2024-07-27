<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Author API",
 *     version="1.0.0",
 *     description="API for managing authors"
 * )
 */

/**
 * @OA\Tag(
 *     name="Authors",
 *     description="Endpoints for managing authors"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Jane Austen"),
 *     @OA\Property(property="birth_date", type="string", format="date"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/authorIndex",
     *     summary="List all authors",
     *     @OA\Response(
     *         response=200,
     *         description="A list of authors",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Author")
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="An unexpected error"
     *     )
     * )
     */
    public function authorIndex()
    {
        return AuthorResource::collection(Author::all());
    }

    /**
     * @OA\Post(
     *     path="/authorStore",
     *     summary="Create a new author",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Jane Austen"),
     *                 @OA\Property(property="birth_date", type="string", format="date", example="1775-12-16")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function authorStore(Request $request)
    {
        // Validação dos dados da solicitação
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Criação de um novo autor
        $author = Author::create($request->all());
        return new AuthorResource($author);
    }

    /**
     * @OA\Get(
     *     path="/authorShow/{id}",
     *     summary="Get an author by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author details",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function authorShow($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        return new AuthorResource($author);
    }

    /**
     * @OA\Put(
     *     path="/authorUpdate/{id}",
     *     summary="Update an author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Updated Name"),
     *                 @OA\Property(property="birth_date", type="string", format="date", example="1800-01-01")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function authorUpdate(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        // Validação dos dados da solicitação
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $author->update($request->all());
        return new AuthorResource($author);
    }

    /**
     * @OA\Delete(
     *     path="/authorDestroy/{id}",
     *     summary="Delete an author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Author deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function authorDestroy($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        $author->delete();
        return response()->json(null, 204);
    }
}
