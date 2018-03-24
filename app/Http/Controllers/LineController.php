<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index(Request $request)
    {
        $img = $request->file('image');
        $dateDirName = date('Ymd', time() - 86400 * 2);
        $imgRelatePath = $img->store('public/' . $dateDirName);//自动创建日期文件夹

        $jsonParams = json_encode($request->only(['inner_cut_line', 'cut_line_type', 'cut_line_color', 'bleed_line_color', 'bleed_line_type', 'bleed_len']));
        if ($jsonParams == '[]') {
            $jsonParams = '{}';
        }
        $v = 0;
        $filePath = storage_path('app') . '/' . $imgRelatePath;//全路径
        $result = system("/home/x/bin/test " . $filePath . " $jsonParams " . $filePath, $v);
        $resultArray = json_decode($result, true);
        if ($resultArray['status'] != 0) {
            return $result;
        } else {
            $pathInfo = pathinfo($imgRelatePath);
            return [
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-1.' . $pathInfo['extension']),//APP_URL的地址
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-2.' . $pathInfo['extension']),
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-3.' . $pathInfo['extension']),
            ];
        }
    }
}
