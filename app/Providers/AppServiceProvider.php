<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\ExamAttempt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.top_nav', function ($view) {
            $notifications = collect();
            $email = Session::get('email');

            if ($email) {
                $user = User::where('email', $email)->first();

                if ($user) {
                    $oneWeekAgo = Carbon::now()->subDays(7);

                    // 1. Pengingat: Belum melanjutkan kursus selama > 7 hari
                    $reminders = CourseUser::where('user_id', $user->id)
                        ->where('updated_at', '<', $oneWeekAgo)
                        ->with('course')
                        ->get();

                    foreach ($reminders as $rem) {
                        if ($rem->course) {
                            // Cek apakah kursus ini sudah selesai (opsional, misalnya cek exam attempt posttest)
                            $isFinished = ExamAttempt::where('user_id', $user->id)
                                ->whereHas('exam', function($q) use ($rem) {
                                    $q->where('course_id', $rem->course->id)
                                      ->where('title', 'like', '%Posttest%');
                                })->whereNotNull('submitted_at')->exists();

                            if (!$isFinished) {
                                $notifications->push([
                                    'type' => 'reminder',
                                    'title' => 'Lanjutkan Pelatihan',
                                    'message' => 'Anda belum melanjutkan pelatihan "' . $rem->course->title . '" selama lebih dari 1 minggu.',
                                    'time' => $rem->updated_at->diffForHumans(),
                                    'link' => route('my_course', ['id' => $rem->course->slug]),
                                    'icon' => 'ri-time-line text-warning',
                                    'timestamp' => $rem->updated_at
                                ]);
                            }
                        }
                    }

                    // 2. Pelatihan Baru: Dibuat dalam 7 hari terakhir
                    $newCourses = Course::where('status', 'active')
                        ->where('created_at', '>=', $oneWeekAgo)
                        ->get();

                    foreach ($newCourses as $nc) {
                        $notifications->push([
                            'type' => 'new_course',
                            'title' => 'Pelatihan Baru',
                            'message' => 'Ada pelatihan baru rilis: "' . $nc->title . '".',
                            'time' => $nc->created_at->diffForHumans(),
                            'link' => route('my_course', ['id' => $nc->slug]),
                            'icon' => 'ri-book-3-line text-info',
                            'timestamp' => $nc->created_at
                        ]);
                    }
                }
            }

            // Urutkan berdasarkan waktu paling baru
            $notifications = $notifications->sortByDesc('timestamp')->values();

            $view->with('notifications', $notifications)->with('user', $user ?? null);
        });
    }
}
