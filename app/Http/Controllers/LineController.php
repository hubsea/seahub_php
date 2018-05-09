<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index(Request $request)
    {
        return json_encode(json_encode(['bleed_line_color'=>[0,100,0]]));
        $img = $request->file('image');
        $dateDirName = date('Ymd', time());
        $imgRelatePath = $img->store('public/' . $dateDirName);//自动创建日期文件夹

        $data = array_map(function ($value) {
                return intval($value);
            }, $request->only(['inner_cut_line', 'cut_line_type', 'bleed_line_type', 'bleed_len']));
        if ($request->has('cut_line_color')) {
            $data['cut_line_color'] = array_map(function ($value) {
                return intval($value);
            },
                explode('|', $request->cut_line_color));
        }
        if ($request->has('bleed_line_color')) {
            $data['bleed_line_color'] = array_map(function ($value) {
                return intval($value);
            }, explode('|', $request->bleed_line_color));
        }
        $jsonParams = json_encode($data);
        if ($jsonParams == '[]') {
            $jsonParams = '{}';
        }
        $jsonParams = json_encode($jsonParams);
        $v = 0;
        $filePath = storage_path('app') . '/' . $imgRelatePath;//全路径
        $result = exec("/home/x/bin/test " . $filePath . " $jsonParams " . $filePath, $v);
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
