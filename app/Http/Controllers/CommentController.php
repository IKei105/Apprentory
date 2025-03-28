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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OriginalProductCommentRequest $request, Original_product $product)
    {
        // バリデーション
        $validatedData = $request->validated();

        $this->commentService->createComment($validatedData, $product->id);

        // リダイレクト（リロードしてコメントを反映）
        return redirect()->route('products.show', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
