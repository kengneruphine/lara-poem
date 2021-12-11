<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response(Comment::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate(['user_id' => 'required|integer',
            'poem_id' => 'required|integer',
            'message' => 'required|string']);

        $comment = Comment::create($request->all());
        return response(['message' => "Comment create", 'comment' => $comment]);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return Response
     */
    public function show(Comment $comment): Response
    {
        return response(Comment::find($comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $request->validate(['message' => 'required|string']);

        $comment = Comment::find($id);
        if ($comment !== null) {
            $comment->update(['message' => $request->input('message')]);
            return response($comment);
        }

        return response(['message' => 'Comment does not exist']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        return response(Comment::destroy($id));
    }
}