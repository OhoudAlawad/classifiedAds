<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Repositories\Comments\CommentsInterface;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentsInterface $commentRepository)
    {
        $this->comment = $commentRepository;

        $this->middleware('auth')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function store(CommentRequest $request)
    {
        $this->comment->addComment($request);

        return back();
    }

    public function reply(CommentRequest $request)
    {
        $this->comment->addReply($request);

        return back();
    }

}
