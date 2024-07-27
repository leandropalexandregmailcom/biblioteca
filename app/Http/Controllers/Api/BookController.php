<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Book API",
 *     version="1.0.0",
 *     description="API for managing books"
 * )
 */

/**
 * @OA\Tag(
 *     name="Books",
 *     description="Endpoints for managing books"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     required={"title", "author_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Pride and Prejudice"),
 *     @OA\Property(property="author_id", type="integer", example=1),
 *     @OA\Property(property="published_date", type="string", format="date"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/bookIndex",
     *     summary="List all books",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="List of books",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function bookIndex()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * @OA\Post(
     *     path="/bookStore",
     *     summary="Create a new book",
     *     tags={"Books"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author_id"},
     *             @OA\Property(property="title", type="string", example="Pride and Prejudice"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="published_date", type="string", format="date", example="1813-01-28")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function bookStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer|exists:authors,id',
            'published_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Criação de um novo livro
        $book = Book::create($request->all());
        return new BookResource($book);
    }


    /**
     * @OA\Get(
     *     path="/bookShow/{id}",
     *     summary="Get a specific book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book details",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function bookShow($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return new BookResource($book);
    }

    /**
     * @OA\Put(
     *     path="/bookUpdate/{id}",
     *     summary="Update a book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author_id"},
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="published_date", type="string", format="date", example="1813-01-28")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function bookUpdate(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer|exists:authors,id',
            'published_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $book->update($request->all());
        return new BookResource($book);
    }

    /**
     * @OA\Delete(
     *     path="/bookDestroy/{id}",
     *     summary="Delete a book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Book deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function bookDestroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        $book->delete();
        return response()->json(null, 204);
    }
}
