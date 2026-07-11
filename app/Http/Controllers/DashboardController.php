<?php

namespace App\Http\Controllers;

use App\Models\Ai_chat_history;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamAnswer;
use App\Models\ExamOption;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Models\CourseCertificateTemplate;
use App\Models\UserFeedback;
use App\Models\CourseReview;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


use Hash;
use Session;
use Auth;
use DB;

use OpenAI\Laravel\Facades\OpenAI;

class DashboardController extends Controller
{

	public function __construct()
	{	

        // if (empty(Session::get('email'))) {
        //     Session::put('name' , 'Okta');
        //     Session::put('email' , 'oktafirdaus231111@gmail.com');
        // }

		$this->middleware('logincheck');
	}

    public function index()
    {

        $course = Course::where('status' , 'active')->get();
        $user = User::where('email', Session::get('email'))->first();

    	return view('dashboard.index' , compact('course', 'user'));
    }

    public function carrier()
    {
    	$user = User::where('email', Session::get('email'))->first();
    
        $course = Exam::with([
        'attempts' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        },
        'attempts.user',
        'course.cert'
    ])
    ->where('title', 'like', '%Posttest%')
    ->whereHas('attempts', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->get();

        $courses_in_progress = \App\Models\CourseUser::where('user_id', $user->id)
            ->with('course')
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $saved_courses = \App\Models\SavedCourse::with('course')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
    	return view('dashboard.carrier' , compact('course', 'user', 'courses_in_progress', 'saved_courses'));
    }

    public function update_target_karir(Request $request)
    {
        $user = User::where('email', Session::get('email'))->first();
        if ($user && $request->has('target_karir')) {
            $user->target_karir = $request->target_karir;
            $user->save();
        }
        return redirect()->back();
    }

    public function update_target_mingguan(Request $request)
    {
        $user = User::where('email', Session::get('email'))->first();
        if ($user && $request->has('target_waktu')) {
            $user->target_mingguan = $request->target_waktu;
            $user->save();
        }
        return redirect()->back();
    }

    public function content()
    {
        $user = User::where('email', Session::get('email'))->first();

        // 1. Kursus Diikuti
        $kursus_diikuti = \App\Models\CourseUser::where('user_id', $user->id)->count();

        // 2. Pengujian Hasil
        $pengujian_hasil = \App\Models\ExamAttempt::where('user_id', $user->id)->whereNotNull('submitted_at')->count();

        // 3. Kursus Tersimpan
        $saved_course_ids = \App\Models\SavedCourse::where('user_id', $user->id)->pluck('course_id')->toArray();
        $kursus_tersimpan = count($saved_course_ids);

        // 4. Sertifikat (Proxy by checking completed exams that usually grant certificates)
        $get_exam_atemp = \App\Models\Exam::with([
            'attempts' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
            'course'
        ])
        ->whereHas('attempts', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereIn('id', function ($query) {
            $query->select(\DB::raw('MAX(id)'))
                ->from('exams')
                ->groupBy('course_id');
        })
        ->get();
        
        $sertifikat = count($get_exam_atemp);

        // 5. Dalam Proses
        $course_in_progress = \App\Models\CourseUser::where('user_id', $user->id)
            ->with('course')
            ->orderBy('updated_at', 'desc')
            ->first();

        // 6. Rekomendasi (Sort by target_karir match)
        $course = Course::where('status', 'active')->get();
        if ($user->target_karir) {
            // Ubah underscore jadi spasi dan pisah jadi array kata
            $target_karir_clean = str_replace('_', ' ', $user->target_karir);
            $keywords = explode(' ', $target_karir_clean);
            
            $course = $course->sortByDesc(function ($c) use ($keywords) {
                $score = 0;
                foreach ($keywords as $kw) {
                    // Abaikan kata hubung atau kata pendek
                    if (strlen($kw) > 3) {
                        if (stripos($c->title, $kw) !== false) {
                            $score += 2;
                        }
                        if (stripos($c->description, $kw) !== false) {
                            $score += 1;
                        }
                    }
                }
                return $score;
            })->values();
        }

        return view('dashboard.content' , compact('course', 'user', 'kursus_diikuti', 'pengujian_hasil', 'kursus_tersimpan', 'sertifikat', 'course_in_progress', 'saved_course_ids'));
    }

    public function toggle_save_course(Request $request)
    {
        $user = User::where('email', Session::get('email'))->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $course_id = $request->course_id;
        if (!$course_id) {
            return response()->json(['status' => 'error', 'message' => 'Missing course_id'], 400);
        }

        $saved = \App\Models\SavedCourse::where('user_id', $user->id)->where('course_id', $course_id)->first();
        if ($saved) {
            $saved->delete();
            return response()->json(['status' => 'unsaved']);
        } else {
            \App\Models\SavedCourse::create([
                'user_id' => $user->id,
                'course_id' => $course_id
            ]);
            return response()->json(['status' => 'saved']);
        }
    }

    public function certificate()
    {

        $url = "https://admin.smartteacherai.id/api/v1";

        

        $course = Course::where('status' , 'active')->get();
        
        $user = User::where('email', Session::get('email'))->first();

        $get_exam_atemp = Exam::with([
            'attempts' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
            'attempts.user',
            'course.cert'
        ])
        ->whereHas('attempts', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('exams')
                ->groupBy('course_id');
        })
        ->get();


        $data_cert = [];

        foreach ($get_exam_atemp as $key => $value) {
            
            $response[$key] = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . Session::get('lms_token')
            ])
            ->get($url . '/my-courses/courses/'.$value['course']->slug.'/certificate', [
                'access_token' => Session::get('lms_token'),
            ]);

            $jsonResponse = $response[$key]->json();
            $certUrl = isset($jsonResponse['data']['url']) ? $jsonResponse['data']['url'] : null;
            array_push($data_cert, $certUrl);

        }

        return view('dashboard.certificate' , compact('course' , 'get_exam_atemp' , 'user' , 'data_cert'));



    }

    public function ask_ai()
    {
        return view('dashboard.ask_ai');
    }

    public function chat_ai()
    {
        return view('dashboard.chat_ai');
    }

    public function submit_chat_ai(Request $request)
    {
        set_time_limit(120);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Referer' => 'https://smartteacherai.id',
            'x-goog-api-key' => 'AIzaSyDOvkjOJEP1W_Y_0USDDyTFKXqAHf4h1w8',
        ])->timeout(120)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent', [
            'contents' => [[
                'role' => 'user',
                'parts' => [['text' => $request->message]]
            ]]
        ]);

        $history = Ai_chat_history::create([

            'email'     => Session::get('email'),
            'question'  => $request->message,
            'answer'    => $response->json('candidates.0.content.parts.0.text') ?? 'Maaf, tidak ada jawaban dari AI.'

        ]);

        return response()->json([
            'raw' => $response->json(), // untuk debugging
            'reply' => $response->json('candidates.0.content.parts.0.text') ?? 'Maaf, tidak ada jawaban dari AI.',
        ]);
    }

    public function history_chat_ai()
    {

        $get_history = Ai_chat_history::where('email' , Session::get('email'))->get();

        return view('dashboard.history_chat_ai' , compact('get_history'));
    }

    public function my_course($param)
    {
        $user = User::where('email' , Session::get('email'))->first();

        // get 

        $course     = Course::where('status' , 'active')->with(['course_videos' , 'user'])->where('slug' , $param)->first();
        
        if ($course) {
            // Tandai kursus ini sebagai "Dalam Proses" (diikuti) oleh user
            \App\Models\CourseUser::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['updated_at' => now()]
            );
        }

        $get_exam   = Exam::where('course_id', $course->id)->where('title', 'like', '%Pretest%')->first();

        if (empty($get_exam)) {
            $exam_opt   = null;
            $get_exam_attemp = null;
        }
        else
        {
            $exam_opt   = ExamQuestion::with(['options'])->where('exam_id', $get_exam->id)->get();
            $get_exam_attemp    = ExamAttempt::where('user_id' , $user->id)->where('exam_id' , $get_exam->id)->first();
        }
        

        $get_exam_pretest   = Exam::where('course_id', $course->id)->where('title', 'like', '%Posttest%')->first();

        if(empty($get_exam_pretest))
        {
            $exam_opt_pretest   = null;
            $get_exam_attemp_pretest = null;
        }
        else
        {
            $exam_opt_pretest   = ExamQuestion::with(['options'])->where('exam_id', $get_exam_pretest->id)->get();
            $get_exam_attemp_pretest    = ExamAttempt::where('user_id' , $user->id)->where('exam_id' , $get_exam_pretest->id)->first();
        }

        // feedback
        // Ambil data dari API
        $response = Http::get('https://admin.smartteacherai.id/api/v1/user-feedbacks');

        // Decode hasil ke array
        $data_feedback = $response->json();

        // Pastikan ada key 'data'
        if (!isset($data_feedback['data'])) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Bagi data berdasarkan is_user
        $feedbackUser = collect($data_feedback['data'])->where('is_user', 1)->values();
        $feedbackInstruktur = collect($data_feedback['data'])->where('is_user', 0)->values();

        // Upload pelatihan check
        $check_course_review = CourseReview::where('course_id' , $course->id)->where('user_id' , $user->id)->first();

        // Cek apakah user sudah mengisi feedback untuk kursus ini
        $feedbackIds = collect($data_feedback['data'])->pluck('id')->toArray();
        $has_feedback = \App\Models\UserFeedback::whereIn('feedback_id', $feedbackIds)
                            ->where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->exists();

        $cert = CourseCertificateTemplate::where('course_id' , $course->id)->first();

        return view('dashboard.my_course' , compact('course' , 'get_exam' , 'exam_opt' , 'get_exam_pretest' , 'exam_opt_pretest' , 'get_exam_attemp' , 'get_exam_attemp_pretest' , 'data_feedback' , 'cert' , 'feedbackUser' , 'feedbackInstruktur' , 'check_course_review', 'has_feedback'));
    }

    public function image_evaluate()
    {
        return view('dashboard.image_evaluate');
    }

    public function submit_evaluate_image(Request $request)
    {
        set_time_limit(120);
        $request->validate([
            'image'           => 'required|image|max:5120',
            'jenis_pelatihan' => 'required',
            'indikator'       => 'nullable'
        ]);

        $image = $request->file('image');
        $jenis_pelatihan = $request->jenis_pelatihan;
        $indikator = $request->indikator;
        
        $promptText = "Tolong evaluasi gambar ini. Gambar ini adalah tugas pembuatan: {$jenis_pelatihan}.";
        if ($jenis_pelatihan == 'Materi Pembelajaran' && !empty($indikator)) {
            $promptText .= " Lakukan analisis dan penilaian yang mendalam secara spesifik berdasarkan indikator berikut:\n{$indikator}";
        }

        $apiKey = 'AIzaSyDOvkjOJEP1W_Y_0USDDyTFKXqAHf4h1w8';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Referer' => 'https://smartteacherai.id',            ])->timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [[
                    'parts' => [
                        ['text' => $promptText],
                        [
                            'inline_data' => [
                                'mime_type' => $image->getMimeType(),
                                'data' => base64_encode(file_get_contents($image->getRealPath())),
                            ]
                        ]
                    ]
                ]]
            ]
        );

        // simpan hasil mentah ke log
        \Log::info('Gemini Response:', $response->json());

        $result = $response->json();

        // untuk debug, kalau tidak ada candidates, tampilkan semua
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'success' => false,
                'debug' => $result, // kirim balik semua isi response
                'message' => 'Tidak ada respon dari Gemini.'
            ]);
        }

        $output = $result['candidates'][0]['content']['parts'][0]['text'];

        $history = Ai_chat_history::create([

            'email'     => Session::get('email'),
            'question'  => "Evaluasi gambar: {$jenis_pelatihan}",
            'answer'    => $output ?? 'Maaf, tidak ada jawaban dari AI.'

        ]);

        return response()->json([
            'success' => true,
            'message' => $output,
            'debug' => $result // opsional: bisa dibuang kalau sudah oke
        ]);
    }

    public function teaching_module()
    {
        return view('dashboard.teaching_module');
    }

    public function submit_teaching_module(Request $request)
    {
        set_time_limit(120);

        $request->validate([
            'image'             => 'nullable|max:5120',
            'instansi'          => 'required',
            'tahun_penyusunan'  => 'required',
            'mata_pelajaran'    => 'required',
            'kelas'             => 'required',
            'topik'             => 'required',
            'waktu'             => 'required',
            'deskripsi'         => 'required',

        ]);

        $image = $request->file('image');
        $apiKey = 'AIzaSyDOvkjOJEP1W_Y_0USDDyTFKXqAHf4h1w8';

        // make CRT text
        $text = "Tolong buat modul ajar dengan pendekatan CRT berikut : Instansi {$request->instansi} , Tahun Penyusunan : {$request->tahun_penyusunan}, Mata Pelajaran : {$request->mata_pelajaran}, Kelas {$request->kelas}, Topik : {$request->topik} , Waktu : {$request->waktu}, Deskripsi : {$request->deskripsi} .";
        if ($image) {
            $text .= " Kemudian referensi/bahan ajar ada di lampiran berikut.";
        }

        $parts = [['text' => $text]];
        if ($image) {
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $image->getMimeType(),
                    'data' => base64_encode(file_get_contents($image->getRealPath())),
                ]
            ];
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Referer' => 'https://smartteacherai.id',            
        ])->timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [[
                'parts' => $parts
            ]]
        ]);

        // simpan hasil mentah ke log
        \Log::info('Gemini Response:', $response->json());

        $result = $response->json();

        // untuk debug, kalau tidak ada candidates, tampilkan semua
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'success' => false,
                'debug' => $result, // kirim balik semua isi response
                'message' => 'Tidak ada respon dari Gemini.'
            ]);
        }

        $output = $result['candidates'][0]['content']['parts'][0]['text'];

        $history = Ai_chat_history::create([

            'email'     => Session::get('email'),
            'question'  => $text,
            'answer'    => $output ?? 'Maaf, tidak ada jawaban dari AI.'

        ]);

        return response()->json([
            'success' => true,
            'message' => $output,
            'debug' => $result // opsional: bisa dibuang kalau sudah oke
        ]);
    }

    public function make_exam()
    {
        return view('dashboard.make_exam');
    }

    public function submit_make_exam(Request $request)
    {
        set_time_limit(120);

        $request->validate([
            'image'             => 'nullable|max:5120',
            'bentuk_soal'       => 'required',
            'jenjang'           => 'required',
            'mapel'             => 'required',
            'jumlah_soal'       => 'required',
            'deskripsi'         => 'required',
        ]);

        $image = $request->file('image');
        $apiKey = 'AIzaSyDOvkjOJEP1W_Y_0USDDyTFKXqAHf4h1w8';

        $opsi = $request->opsi_jawaban ? " dengan opsi jawaban {$request->opsi_jawaban}" : "";

        // make bentuk soal
        $text = "Tolong buatkan {$request->jumlah_soal} soal {$request->bentuk_soal}{$opsi} untuk mata pelajaran {$request->mapel} tingkat {$request->jenjang}. Topik: {$request->deskripsi}.";
        if ($request->bentuk_soal == 'Pilihan Ganda') {
            $text .= " WAJIB susun opsi jawaban (A, B, C, dst) tepat di bawah masing-masing soal. Setiap opsi jawaban HARUS berada di baris baru yang terpisah. (Gunakan format list markdown atau beri jarak baris (enter) yang jelas agar opsi tidak menyatu dalam satu baris).";
        }
        $text .= " Harap sertakan kunci jawabannya di akhir.";

        $parts = [['text' => $text]];
        if ($image) {
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $image->getMimeType(),
                    'data' => base64_encode(file_get_contents($image->getRealPath())),
                ]
            ];
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Referer' => 'https://smartteacherai.id',            ])->timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [[
                    'parts' => $parts
                ]]
            ]
        );

        // simpan hasil mentah ke log
        \Log::info('Gemini Response:', $response->json());

        $result = $response->json();

        // untuk debug, kalau tidak ada candidates, tampilkan semua
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'success' => false,
                'debug' => $result, // kirim balik semua isi response
                'message' => 'Tidak ada respon dari Gemini.'
            ]);
        }

        $output = $result['candidates'][0]['content']['parts'][0]['text'];

        $history = Ai_chat_history::create([

            'email'     => Session::get('email'),
            'question'  => $text,
            'answer'    => $output ?? 'Maaf, tidak ada jawaban dari AI.'

        ]);

        return response()->json([
            'success' => true,
            'message' => $output,
            'debug' => $result // opsional: bisa dibuang kalau sudah oke
        ]);
    }

    public function chat_with_docs()
    {
        return view('dashboard.chat_with_docs');
    }

    public function submit_chat_with_docs(Request $request)
    {
        set_time_limit(120);

        $request->validate([
            'deskripsi' => 'required',
            'document'  => 'nullable|max:5120',
        ]);

        $document = $request->file('document');
        $apiKey = 'AIzaSyDOvkjOJEP1W_Y_0USDDyTFKXqAHf4h1w8';

        $text = "{$request->deskripsi}";
        
        $parts = [['text' => $text]];
        if ($document) {
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $document->getMimeType(),
                    'data' => base64_encode(file_get_contents($document->getRealPath())),
                ]
            ];
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Referer' => 'https://smartteacherai.id',            ])->timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [[
                    'parts' => $parts
                ]]
            ]
        );

        // simpan hasil mentah ke log
        \Log::info('Gemini Response:', $response->json());

        $result = $response->json();

        // untuk debug, kalau tidak ada candidates, tampilkan semua
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'success' => false,
                'debug' => $result, // kirim balik semua isi response
                'message' => 'Tidak ada respon dari Gemini.'
            ]);
        }

        $output = $result['candidates'][0]['content']['parts'][0]['text'];

        $history = Ai_chat_history::create([

            'email'     => Session::get('email'),
            'question'  => $text,
            'answer'    => $output ?? 'Maaf, tidak ada jawaban dari AI.'

        ]);

        return response()->json([
            'success' => true,
            'message' => $output,
            'debug' => $result // opsional: bisa dibuang kalau sudah oke
        ]);
    }

    public function submit_pretest($id , Request $request)
    {

        $point_modal = 0;

        foreach($request->answer as $key => $val_point)
        {
            $poin_answer = ExamOption::where('id' , $val_point)->first();

            $point_modal+=$poin_answer->is_correct == 1 ? 10 : 0;

        }

        $user = User::where('email' , Session::get('email'))->first();

            // create attemp

        $point = 0;

            try {

                $exam_attemp = ExamAttempt::create([

                    'exam_id'       => $id,
                    'user_id'       => $user->id,
                    'started_at'    => date('Y-m-d H:i:s'),
                    'submitted_at'  => date('Y-m-d H:i:s'),
                    'status'        => 'graded',
                    'score'         => $point_modal,

                ]);

                foreach($request->answer as $key => $value)
                {
                    $poin_answer = ExamOption::where('id' , $value)->first();

                    ExamAnswer::create([
                        'exam_attempt_id'   => $exam_attemp->id,
                        'exam_question_id'  => $key,
                        'selected_option_id'=> $value,
                        'score_awarded'     => $poin_answer->is_correct == 1 ? 10 : 0,
                    ]);

                }

                
                
            } catch (Exception $e) {
                return $e;
            }

            Session::put('message_pretest_modal', 'Pretest selesai dikerjakan. Tidak ada syarat kelulusan, skor ini hanya ditampilkan sebagai informasi awal kemampuan Anda.');
            Session::put('nilai_pretest', $point_modal);
            Session::put('status_pretest', 'Selesai');

            return redirect()->back();

        // $user = User::where('email' , Session::get('email'))->first();

        // // create attemp

        // $point = 0;

        // try {

        //     $exam_attemp = ExamAttempt::create([

        //         'exam_id'       => $id,
        //         'user_id'       => $user->id,
        //         'started_at'    => date('Y-m-d H:i:s'),
        //         'submitted_at'  => date('Y-m-d H:i:s'),
        //         'status'        => 'graded',
        //         'score'         => $point,

        //     ]);

        //     foreach($request->answer as $key => $value)
        //     {
        //         $poin_answer = ExamOption::where('id' , $value)->first();

        //         $point+=$poin_answer->is_correct == 1 ? 10 : 0;

        //         ExamAnswer::create([
        //             'exam_attempt_id'   => $exam_attemp->id,
        //             'exam_question_id'  => $key,
        //             'selected_option_id'=> $value,
        //             'score_awarded'     => $poin_answer->is_correct == 1 ? 10 : 0,
        //         ]);

        //     }

            
            
        // } catch (Exception $e) {
        //     return $e;
        // }

        // Session::put('message', 'Pretest berhasil dibuat');
        // Session::put('class', 'alert-success');

        // return redirect()->back();


    }

    public function submit_posttest($id , Request $request)
    {


        $point_modal = 0;

        foreach($request->answer as $key => $val_point)
        {
            $poin_answer = ExamOption::where('id' , $val_point)->first();

            $point_modal+=$poin_answer->is_correct == 1 ? 10 : 0;

        }

        if ($point_modal < 80) {
            Session::put('message', 'Kamu harus mendapatkan skor minimal 80 atau lebih untuk menyelesaikan pelatihan ini');
            Session::put('class', 'alert-danger');
            Session::put('nilai', $point_modal);
            Session::put('status_lulus', 'Dibawah Batas Lulus');

            return redirect()->back();
        }
        else
        {

            $user = User::where('email' , Session::get('email'))->first();

            // create attemp

            $point = 0;

            try {

                $exam_attemp = ExamAttempt::create([

                    'exam_id'       => $id,
                    'user_id'       => $user->id,
                    'started_at'    => date('Y-m-d H:i:s'),
                    'submitted_at'  => date('Y-m-d H:i:s'),
                    'status'        => 'graded',
                    'score'         => $point_modal,

                ]);

                foreach($request->answer as $key => $value)
                {
                    $poin_answer = ExamOption::where('id' , $value)->first();

                    ExamAnswer::create([
                        'exam_attempt_id'   => $exam_attemp->id,
                        'exam_question_id'  => $key,
                        'selected_option_id'=> $value,
                        'score_awarded'     => $poin_answer->is_correct == 1 ? 10 : 0,
                    ]);

                }

                
                
            } catch (Exception $e) {
                return $e;
            }

            Session::put('message', 'Kamu harus mendapatkan skor minimal 80 atau lebih untuk menyelesaikan pelatihan ini');
            Session::put('class', 'alert-success');
            Session::put('nilai', $point_modal);
            Session::put('status_lulus', 'Lulus');

            return redirect()->back();
        }

        



        // $user = User::where('email' , Session::get('email'))->first();

        // // create attemp

        // $point = 0;

        // try {

        //     $exam_attemp = ExamAttempt::create([

        //         'exam_id'       => $id,
        //         'user_id'       => $user->id,
        //         'started_at'    => date('Y-m-d H:i:s'),
        //         'submitted_at'  => date('Y-m-d H:i:s'),
        //         'status'        => 'graded',
        //         'score'         => $point,

        //     ]);

        //     foreach($request->answer as $key => $value)
        //     {
        //         $poin_answer = ExamOption::where('id' , $value)->first();

        //         $point+=$poin_answer->is_correct == 1 ? 10 : 0;

        //         ExamAnswer::create([
        //             'exam_attempt_id'   => $exam_attemp->id,
        //             'exam_question_id'  => $key,
        //             'selected_option_id'=> $value,
        //             'score_awarded'     => $poin_answer->is_correct == 1 ? 10 : 0,
        //         ]);

        //     }

            
            
        // } catch (Exception $e) {
        //     return $e;
        // }

        // Session::put('message', 'Pretest berhasil dibuat');
        // Session::put('class', 'alert-success');

        // return redirect()->back();


    }
    
    public function submit_feedback(Request $request)
    {
        // Ambil user yang sedang login
        $user = User::where('email', Session::get('email'))->first();

        if (!$user) {
            Session::put('message_pretest', 'User tidak ditemukan');
            Session::put('class', 'alert-danger');
            return redirect()->back();
        }

        // Loop semua inputan dari form
        foreach ($request->all() as $key => $value) {

            // Pastikan input ini adalah bagian dari feedback
            if (Str::startsWith($key, ['feedback_user_', 'feedback_instruktur_'])) {

                // Ambil feedback_id dari name input
                // contoh: feedback_user_7 → ambil "7"
                $parts = explode('_', $key);
                $feedbackId = end($parts);

                // Cek apakah ini textarea (komentar) atau nilai angka
                if (is_numeric($value)) {
                    // Ini nilai radio (skor)
                    UserFeedback::create([
                        'course_id'   => $request->course_id,
                        'feedback_id' => $feedbackId,
                        'user_id'     => $user->id,
                        'score'       => $value,
                        'comments'    => null,
                    ]);
                } elseif (!empty($value)) {
                    // Ini textarea (komentar)
                    UserFeedback::create([
                        'course_id'   => $request->course_id,
                        'feedback_id' => $feedbackId,
                        'user_id'     => $user->id,
                        'score'       => null,
                        'comments'    => $value,
                    ]);
                }
            }
        }

        // Setelah semua data disimpan
        Session::put('message_pretest', 'Feedback berhasil dikirim');
        Session::put('class', 'alert-success');

        return redirect()->back();
    }

    public function upload_pelatihan(Request $request)
    {

        $url = "https://admin.smartteacherai.id/api/v1";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Session::get('lms_token')
        ])
        ->attach(
            'file',
            file_get_contents($request->file('file')->getRealPath()),
            $request->file('file')->getClientOriginalName()
        )
        ->post($url . '/user-course-reviews', [
            // 'access_token' => Session::get('lms_token'),
            'course_id'    => $request->course_id,
        ]);

        // return $response->json();

        session()->flash('message_pretest', 'Upload Pelatihan Berhasil');
        session()->flash('class', 'alert-success');

        return response()->json([
            $response
        ]);

    }

    public function materi_presentasi()
    {
        return view('dashboard.materi_presentasi');
    }

    public function submit_materi_presentasi(Request $request)
    {
        set_time_limit(120);
        // 1. Validasi Input
        $request->validate([
            'kelas'              => 'required',
            'jumlah_slide'       => 'required|numeric',
            'deskripsi'          => 'required_without:dokumen',
            'dokumen'            => 'nullable|file|max:5120', // Maks 5MB
            'deskripsi_tambahan' => 'nullable',
            'dokumen_tambahan'   => 'nullable|file|max:5120',
        ]);

        $apiKey = 'AIzaSyDOvkjOJEP1W_Y_0USDDyTFKXqAHf4h1w8'; // Ganti dengan API Key kamu

        // 2. Susun Prompt Teks
        $prompt = "Tolong buatkan materi presentasi terstruktur dengan detail sebagai berikut:\n";
        $prompt .= "- Fase/Kelas: {$request->kelas}\n";
        $prompt .= "- Jumlah Slide: {$request->jumlah_slide}\n";
        $prompt .= "- Topik Utama: {$request->deskripsi}\n";
        
        if ($request->deskripsi_tambahan) {
            $prompt .= "- Kriteria Tambahan: {$request->deskripsi_tambahan}\n";
        }

        $prompt .= "\nGunakan dokumen lampiran sebagai dasar referensi materi jika dilampirkan.\n";
        $prompt .= "WAJIB: Susun pemaparan materi per slide secara berurutan (Mulai dari Slide 1, Slide 2, dst hingga Slide {$request->jumlah_slide}).\n";

        // 3. Siapkan Array Parts untuk Gemini (Mendukung Multi-modal)
        $parts = [
            ['text' => $prompt]
        ];

        // Cek jika ada file dokumen utama
        if ($request->hasFile('dokumen')) {
            $doc = $request->file('dokumen');
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $doc->getMimeType(),
                    'data' => base64_encode(file_get_contents($doc->getRealPath())),
                ]
            ];
        }

        // Cek jika ada file dokumen tambahan
        if ($request->hasFile('dokumen_tambahan')) {
            $docAdd = $request->file('dokumen_tambahan');
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $docAdd->getMimeType(),
                    'data' => base64_encode(file_get_contents($docAdd->getRealPath())),
                ]
            ];
        }

        // 4. Kirim ke API Gemini
        // Catatan: Gunakan gemini-1.5-flash untuk kecepatan dan dukungan file yang stabil
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Referer' => 'https://smartteacherai.id',
        ])->timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => $parts]
            ]
        ]);

        $result = $response->json();

        // 5. Handling Response
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'success' => false,
                'debug' => $result,
                'message' => 'Gagal mendapatkan respon dari AI.'
            ]);
        }

        $output = $result['candidates'][0]['content']['parts'][0]['text'];

        // Simpan History
        Ai_chat_history::create([
            'email'    => Session::get('email'),
            'question' => "Presentasi {$request->kelas}: {$request->deskripsi}",
            'answer'   => $output
        ]);

        return response()->json([
            'success' => true,
            'message' => $output
        ]);
    }

    public function profil()
    {
        $user = User::where('email', Session::get('email'))->first();
        return view('dashboard.profil', compact('user'));
    }

    public function submit_profil(Request $request)
    {
        $user = User::where('email', Session::get('email'))->first();

        $request->validate([
            'name'               => 'required',
            'phone_number'       => 'required',
            'profesi'            => 'required',
            'bidang'             => 'required',
            'institusi'          => 'required',
            'tingkat_pendidikan' => 'required',
            'target_karir'       => 'required',
            'minat_pembelajaran' => 'required',
            'avatar'             => 'nullable|image|max:5120'
        ]);

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->profesi = $request->profesi;
        $user->bidang = $request->bidang;
        $user->institusi = $request->institusi;
        $user->tingkat_pendidikan = $request->tingkat_pendidikan;
        $user->target_karir = $request->target_karir;
        $user->minat_pembelajaran = $request->minat_pembelajaran;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/users'), $filename);
            $user->avatar = 'assets/images/users/' . $filename;
        }

        $user->is_profile_completed = 1;
        $user->save();

        Session::put('name', $user->name);

        session()->flash('message_pretest', 'Profil berhasil disimpan!');
        session()->flash('class', 'alert-success');

        return redirect()->route('dashboard');
    }

    public function download_pdf_exam(Request $request)
    {
        $request->validate([
            'html_content' => 'required',
            'mapel' => 'nullable',
            'jenjang' => 'nullable',
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $html = '<h2>Soal ' . htmlspecialchars($request->mapel ?? '') . ' - ' . htmlspecialchars($request->jenjang ?? '') . '</h2>';
        
        // Fix unclosed tags for XML parser
        $clean_html = str_replace(['<br>', '<hr>'], ['<br/>', '<hr/>'], $request->html_content);
        $html .= $clean_html;

        $mpdf->WriteHTML($html);
        return $mpdf->Output('Soal_Ujian.pdf', 'D');
    }

    public function download_docx_exam(Request $request)
    {
        $request->validate([
            'html_content' => 'required',
            'mapel' => 'nullable',
            'jenjang' => 'nullable',
        ]);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $html = '<h2>Soal ' . htmlspecialchars($request->mapel ?? '') . ' - ' . htmlspecialchars($request->jenjang ?? '') . '</h2>';
        
        // Fix unclosed tags for XML parser
        $clean_html = str_replace(['<br>', '<hr>'], ['<br/>', '<hr/>'], $request->html_content);
        $html .= $clean_html;
        
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        
        $fileName = 'Soal_Ujian.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}


