<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $notifications = Notification::where(
            'user_id',
            Auth::id()
        )
            ->latest()
            ->paginate(20);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | READ
    |--------------------------------------------------------------------------
    */

    public function read($id)
    {
        $notification = Notification::findOrFail($id);

        if (
            $notification->user_id != Auth::id()
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | MARK READ
        |--------------------------------------------------------------------------
        */

        $notification->update([

            'is_read' => 1,

        ]);

        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        $content = $notification->content;

        /*
        |--------------------------------------------------------------------------
        | JOB CREATED
        |--------------------------------------------------------------------------
        */

        if (str_contains($content, 'vừa đăng tin tuyển dụng')) {

            preg_match('/#(\d+)/', $content, $matches);

            $jobId = $matches[1] ?? null;

            return redirect(
                '/admin/jobs/'.$jobId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | USER REGISTER
        |--------------------------------------------------------------------------
        */

        if (str_contains($content, 'vừa đăng ký tài khoản')) {

            return redirect(
                '/admin/users'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | APPLY
        |--------------------------------------------------------------------------
        */

        if (str_contains($content, 'ứng tuyển')) {

            preg_match('/#(\d+)/', $content, $matches);

            $jobId = $matches[1] ?? null;

            return redirect(
                '/employer/applications?job='.$jobId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | APPROVED JOB
        |--------------------------------------------------------------------------
        */

        if (str_contains($content, 'được admin duyệt')) {

            preg_match('/#(\d+)/', $content, $matches);

            $jobId = $matches[1] ?? null;

            return redirect(
                '/employer/jobs/'.$jobId
            );
        }
        if ($notification->link) {

            return redirect($notification->link);

        }

        return back();
    }
}
