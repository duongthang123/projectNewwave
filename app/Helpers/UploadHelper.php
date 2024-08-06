<?php

namespace App\Helpers;


class UploadHelper
{
    public static function uploadFile($request)
    {
        if($request->hasFile('avatar')) {
            try {
                $name = $request->file('avatar')->getClientOriginalName();
                $pathFull = 'uploads/' . 'users';
                $request->file('avatar')->storeAs('public/'. $pathFull. '/' . $name);
                return '/storage/' . $pathFull . '/' . $name;
            } catch (\Exception $e) {
                toastr()->error($e->getMessage());
                return false;
            }
        }
    }

    public static function studenStatus($status)
    {
        switch ($status) {
            case config('const.STUDENT_STATUS.STUDYING'):
                return '<span class="btn btn-success btn-xs">Studying</span>';
            case config('const.STUDENT_STATUS.STOPPED'):
                return '<span class="btn btn-secondary btn-xs">Stopped</span>';
            case config('const.STUDENT_STATUS.EXPELLED'):
                return '<span class="btn btn-danger btn-xs">Expelled</span>';
            case config('const.STUDENT_STATUS.PENDING'):
                return '<span class="btn btn-light btn-xs">Pending</span>';
            default:
                return '';
        }
    }
}