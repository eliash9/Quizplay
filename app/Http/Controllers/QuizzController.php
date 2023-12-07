<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
class QuizzController extends Controller
{
    public function index()
    {
        $pertanyaans = Pertanyaan::all();
        return view('quiz.index', compact('pertanyaans'));
    }
/*
    
    public function submit(Request $request, Pertanyaan $pertanyaan)
    {
        $jawabanPengguna = $request->input('jawaban');
        $jawabanBenar = $pertanyaan->jawaban;

        if ($jawabanPengguna == $jawabanBenar) {
            $pesan = 'Jawaban Anda benar!';
        } else {
            $pesan = 'Maaf, jawaban Anda salah. Jawaban yang benar adalah ' . ($jawabanBenar ? 'Benar' : 'Salah');
        }

        return view('quiz.result', compact('pesan'));
    }
*/
    public function submit(Request $request)
    {
        $user_id = Auth::id();
        $pertanyaans = $request->input('pertanyaans');
        foreach ($pertanyaans as $pertanyaan_id => $jawaban_pengguna) {
            Jawaban::updateOrCreate(
                ['user_id' => $user_id, 'pertanyaan_id' => $pertanyaan_id],
                ['jawaban_pengguna' => $jawaban_pengguna]
            );
        }

        

        return redirect()->route('quizz.result');
    }
/*
    public function result()
    {
        $user_id = Auth::id();
        $jawaban_user = Jawaban::where('user_id', $user_id)->with('pertanyaan')->get();
        return view('quiz.result', compact('jawaban_user'));
    }
*/
    public function result()
    {
        $user_id = Auth::id();
        $jawaban_user = Jawaban::where('user_id', $user_id)->with('pertanyaan')->get();

        // Calculate the score
        $score = 0;

        foreach ($jawaban_user as $jawaban) {
            if ($jawaban->jawaban_pengguna == $jawaban->pertanyaan->jawaban) {
                $score++;
            }
        }

        return view('quiz.result', compact('jawaban_user', 'score'));
    }

}
