<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Room;
use App\Models\Quiz;
use App\Models\Answer;

class PelajarController extends Controller
{
    public function index () {
        return view('pelajar.index');
    }

    public function enter_room (Request $request) {
        $enter = Room::where([['code', $request->code], ['is_active', 1]])->first();
        if ($enter) {
            return redirect()->route('pelajar.room',$enter)->withSuccess('Berhasil masuk');
        }
        return redirect()->back()->withError('Room tidak ditemukan');
    }

    public function room($id) {
        $detail = Room::where('id', $id)->firstOrFail();
        $room = Room::findOrFail($id);
        $quizzes = Quiz::where([['id_room', $room->id]])->get();
        return view('pelajar.room', ['detail' => $detail, 'quizzes' => $quizzes]);
    }

    public function play($id) {
        $link = Room::where('id', $id)->firstOrFail();
        $name = Room::findOrFail($id);
        $quizzes = Quiz::where([['id_room', $name->id]])->paginate(1);
        // dd($room);
        return view('pelajar.room_post', ['quizzes' => $quizzes, 'name' => $name, 'link' => $link]);
    }

    

    public function answer_save(Request $request, $id) {
        $room = Room::findOrFail($id);
        
        $this->validate($request, [
            'answer' => 'required',
            'answer.*' => 'required',
        ]);

        foreach($request->answer as $key=>$answer) {
            // dd($request->all());
            $quiz = Quiz::find($key);
            // dd($quiz);
            $score = 0;
            if($quiz->key == $answer) {
                $score = 1;
            }
            if($score == 1) {
                $desc = 'benar';
            } else {
                $desc = 'salah';
            }
            Answer::create([
            'id_quiz' => $quiz->id,
            'question' => $quiz->question,
            'id_room' => $room->id,
            'id_user' => auth()->user()->id,
            'username' => auth()->user()->username,
            'answer' => $answer,
            'score' => $score,
            'desc' => $desc,
            ]);
        }

        return redirect()->route('pelajar.done',$room)->withSuccess('Berhasil masuk');
    }

    public function done($id) {
        $done = Room::where('id', $id)->firstOrFail();
        $room = Room::findOrFail($id);
        $table = Answer::where([['id_room', $room->id], ['id_user', auth()->user()->id]])->get();
        return view('pelajar.done', ['done' => $done, 'table' => $table]);
    }

    public function stand($id) {
        $link = Room::where('id', $id)->firstOrFail();
        $room = Room::findOrFail($id);
        $stand = Answer::where([['id_room', $room->id]])
        ->orderBy('total', 'desc')
        ->groupBy('answers.username')
        ->get([
            'username',
            Answer::raw('sum(score) as total')
        ]);
        // dd($stand);

        return view('pelajar.standing', ['link' => $link, 'stand' => $stand]);
    }
}