<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class AudioController extends Controller
{

    public function get ($audioName) {

        return $this->streamFile("audio/mp3", dirname(__FILE__) . '/../../../public/audio/' . $audioName);

    }

    public function download ($audioName) {

        $headers = array(
            'Content-Type: audio/mp3',
        );

        return Response::download(dirname(__FILE__) . '/../../../public/audio/' . $audioName, $audioName.'.mp3', $headers);

    }

    private function streamFile( $contentType, $path ) {
        $fullsize = filesize($path);
        $size = $fullsize;
        $stream = fopen($path, "r");
        $response_code = 200;
        $headers = array("Content-type" => $contentType);

        // Check for request for part of the stream
        $range = Request::header('Range');
        if($range != null) {
            $eqPos = strpos($range, "=");
            $toPos = strpos($range, "-");
            $unit = substr($range, 0, $eqPos);
            $start = intval(substr($range, $eqPos+1, $toPos));
            $success = fseek($stream, $start);
            if($success == 0) {
                $size = $fullsize - $start;
                $response_code = 206;
                $headers["Accept-Ranges"] = $unit;
                $headers["Content-Range"] = $unit . " " . $start . "-" . ($fullsize-1) . "/" . $fullsize;
            }
        }

        $headers["Content-Length"] = $size;

        return Response::stream(function () use ($stream) {
            fpassthru($stream);
        }, $response_code, $headers);
    }

}