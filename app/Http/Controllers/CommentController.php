<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Original_product_comment;
use App\Models\Original_product;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OriginalProductCommentRequest;

class CommentController extends Controller
{

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index()
    {
    }

    public function create()
    {
    }

    public function store(OriginalProductCommentRequest $request, Original_product $product)
    {
        $validatedData = $request->validated();

        $this->commentService->createComment($validatedData, $product->id);

        return redirect()->route('products.show', $product->id);
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
