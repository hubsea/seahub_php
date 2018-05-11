<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    private $_intParams = [
        'cut_line_type' => 0, "cut_line_width" => 1, "cut_line_dot_space" => 5, "bleed_line_type" => 0, "bleed_line_width" => 2, "bleed_line_dot_space" => 5, "shape_line_type" => 0,
        "shape_line_width" => 3, "shape_line_dot_space" => 5, "bleed_length" => 5, "dpi" => 70, "filled" => 0, "filter" => -1,
    ];

    private $_stringParams = [
        "cut_line_color_str" => "255|0|0",
        "bleed_line_color_str" => "0|255|0",
        "shape_line_color_str" => "0|0|255",
    ];

    /**
     *  author:HAHAXIXI
     *  created_at: 2018-5-
     *  updated_at: 2018-6-
     * @param Request $request
     * @return array|string
     *  desc   :可执行文件  /home/x/bin/blood_line
     * 使用方法:
     * /home/x/bin/blood_line param1 param2 param3
     * 共需要三个命令行参数
     * --param1, 需要处理的图像路径，格式为jpg,jpeg,png
     *
     * --param2, 传送参数的配置文件，需要16个字段，参考如下所示，共需要画三条线：出血线(bleed_line)，裁剪线(cut_line)，轮廓线(shape_line)。line_type字段代表对应的线型(０－实线，１－虚线)，
     * line_width字段代表对应的线宽（单位为ｍｍ），line_dot_space字段代表对应的虚线每一段的长度（单位为ｍｍ），只有线型为虚线时有效，line_color_str字段代表对应的线的颜色，格式为ＢＧＲ。
     * bleed_length字段代表出血区域的宽度（单位为ｍｍ）。ｄｐｉ字段代表打印参数，与长度单位到像素单位的转换有关。 filled字段代表输入图片是否已经填充过（０－未填充，１－已经填充过），为０时输出五张图片，为１时输出四张图片。
     * filter参数代表滤波参数，当图像边缘存在噪声时需要滤波，典型取值为３－７，边缘无噪声时不需要滤波，设置为－１。
     *
     * "{\"cut_line_type\": 0,\"cut_line_width\":1,\"cut_line_dot_space\":5, \"cut_line_color_str\" : \"255|0|0\",\"bleed_line_type\":0,\"bleed_line_width\":2,\"bleed_line_dot_space\":5,
     * \"bleed_line_color_str\" : \"0|255|0\",\"shape_line_type\":0,\"shape_line_width\":3,\"shape_line_dot_space\":5, \"shape_line_color_str\" : \"0|0|255\", \"bleed_length\" :5,
     * \"dpi\" : 70, \"filled\" : 0,\"filter\":-1}"
     *
     * --param3,指定图像输出格式　param3为a.jpg时　输出图片保存为a-1.jpg a-2.jpg a-3.jpg a-４.jpg （filled==1时）或a-1.jpg a-2.jpg a-3.jpg a-4.jpg a-5.jpg（filled==0时）
     *
     *
     * 运行例子　　　./bin/blood_line 1.png "{\"cut_line_type\": 0,\"cut_line_width\":1,\"cut_line_dot_space\":5, \"cut_line_color_str\" : \"255|0|0\",\"bleed_line_type\":0,\"bleed_line_width\":2,
     * \"bleed_line_dot_space\":5, \"bleed_line_color_str\" : \"0|255|0\",\"shape_line_type\":0,\"shape_line_width\":3,\"shape_line_dot_space\":5, \"shape_line_color_str\" : \"0|0|255\",
     * \"bleed_length\" :5,\"dpi\" : 70, \"filled\" : 0,\"filter\":-1}" hh.png
     */
    public function index(Request $request)
    {
        $img = $request->file('image');
        $dateDirName = date('Ymd', time());
        $imgRelatePath = $img->store('public/' . $dateDirName);//自动创建日期文件夹
        $requestIntData = $request->except(array_merge(['image'], array_keys($this->_stringParams)));
        $requestIntData = array_map(function ($value) {//强转整型
            return intval($value);
        }, $requestIntData);
        $intData = array_merge($this->_intParams, $requestIntData);
        $requestStringData = $request->only(array_keys($this->_stringParams));
        $stringData = array_merge($this->_stringParams, $requestStringData);
        $data = array_merge($intData, $stringData);
        $jsonParams = json_encode(json_encode($data));
        $v = 0;
        $filePath = storage_path('app') . '/' . $imgRelatePath;//全路径
        $result = exec("/home/x/bin/blood_line " . $filePath . " $jsonParams " . $filePath, $v);
        $resultArray = json_decode($result, true);
        if ($resultArray['status'] != 0) {
            return $result;
        } else {
            $pathInfo = pathinfo($imgRelatePath);
            $array = [
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-1.' . $pathInfo['extension']),//APP_URL的地址
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-2.' . $pathInfo['extension']),
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-3.' . $pathInfo['extension']),
                asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-4.' . $pathInfo['extension']),
            ];
            if ($data['filled'] == 0) {
                array_push($array, asset('storage/' . $dateDirName . '/' . $pathInfo['filename'] . '-5.' . $pathInfo['extension']));
            }
            return $array;
        }
    }
}
