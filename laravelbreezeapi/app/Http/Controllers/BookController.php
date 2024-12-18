<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Retrieve the search query from the request
        $perPage = $request->input('per_page', 10);

        $books = Books::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%")
                    ->orWhere('isbn', 'LIKE', "%{$search}%");
            })
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => $search ? 'Search Results' : 'Book List',
            'data' => $books, // Return all books
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string',
            'image' => 'required|file|mimes:jpg,png,jpeg|max:2048', // Limit file size to 2MB
            'author' => 'required|string',
            'description' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'isbn' => 'nullable|string',
        ]);

        try {
            // Upload the image to Cloudinary
            $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'books',
            ]);

            // Get the secure URL and public ID
            $uploadedFileUrl = $uploadedFile->getSecurePath();
            $publicId = $uploadedFile->getPublicId();

            // Create a new book record
            $book = new Books();
            $book->title = $request->title;
            $book->image = $uploadedFileUrl; // Store the Cloudinary URL
            $book->image_public_id = $publicId; // Store the public ID
            $book->author = $request->author;
            $book->description = $request->description;
            $book->publish_date = $request->publish_date;
            $book->isbn = $request->isbn;
            $book->save();

            return response()->json([
                'success' => true,
                'message' => 'Book Added',
                'data' => $book,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Image Upload Failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $book = Books::find($id);

        if ($book) {
            return response()->json([
                'success' => true,
                'message' => 'Book Details',
                'data' => $book
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Book Not Found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book Not Found',
            ], 404);
        }

        // Validate the request
        $request->validate([
            'title' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // Optional image upload
            'author' => 'nullable|string',
            'description' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'isbn' => 'nullable|string',
        ]);

        try {
            // Initialize default values for image URL and public ID
            $uploadedFileUrl = $book->image;
            $publicId = $book->image_public_id;

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image from Cloudinary
                if ($book->image_public_id) {
                    Cloudinary::destroy($book->image_public_id);
                }

                // Upload the new image
                $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'books',
                ]);

                // Update the image URL and public ID
                $uploadedFileUrl = $uploadedFile->getSecurePath();
                $publicId = $uploadedFile->getPublicId();
            }

            // Update book details
            $book->title = $request->title ?? $book->title;
            $book->author = $request->author ?? $book->author;
            $book->image = $uploadedFileUrl; // Store the Cloudinary URL
            $book->image_public_id = $publicId; // Store the public ID
            $book->description = $request->description ?? $book->description;
            $book->publish_date = $request->publish_date ?? $book->publish_date;
            $book->isbn = $request->isbn ?? $book->isbn;
            $book->save();

            return response()->json([
                'success' => true,
                'message' => 'Book Updated',
                'data' => $book,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update Failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found.',
            ], 404);
        }

        try {
            // Delete the image from Cloudinary
            if ($book->image_public_id) {
                Cloudinary::destroy($book->image_public_id);
            }

            // Delete the book record
            $book->delete();

            return response()->json([
                'message' => 'Book deleted.',
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Delete Failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
