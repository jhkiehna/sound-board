<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use App\Http\Requests\BoardRequest;
use App\Http\Resources\BoardResource;
use App\Http\Resources\BoardResourceCollection;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        return new BoardResourceCollection($request->user()->boards()->get());
    }

    public function store(BoardRequest $request)
    {
        $board = Board::make($request->all());
        $request->user()->boards()->save($board);

        return new BoardResource($board);
    }

    public function show(Board $board)
    {
        return new BoardResource($board);
    }

    public function update(BoardRequest $request, Board $board)
    {
        $board->update($request->all());

        return new BoardResource($board->refresh());
    }

    public function destroy(Board $board)
    {
        $board->delete();

        return response(null, 204);
    }
}
