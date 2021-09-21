<?php

namespace Namviet\Account\Http\Controllers;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Namviet\Account\Repositories\FileManagedRepository;
use Namviet\Account\Services\FileManager;

class FilesController extends Controller
{
    private const FILE_EXTENSION = 'jpeg,jpg,png,mp4,mpeg,wav';
    private const MIME_TYPES = 'image/*,video/*,audio/*';
    private const MIMES = 'jpeg,png,mp4,mpeg,wav';

    public function apiUpload(FileManagedRepository $fileRepo, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => [
                'required',
                'file_extension:' . self::FILE_EXTENSION,
                'mimes:' . self::MIMES,
                'mimetypes:' . self::MIME_TYPES,
                'max:' . (1024 * 200),
            ]]);
        if ($validator->fails()) {
            abort('503');
        }
        ini_set("upload_max_filesize", "500M");
        ini_set("post_max_size", "500M");
        ini_set("memory_limit", "500M");
        ini_set("max_allowed_packet", "500M");
        ini_set("max_execution_time", 30);
        ini_set("max_input_time", 30);
        if ($request->file('file')) {
            $file = $request->file('file');
            $newName = $this->getNewName($file->getClientOriginalName());
            $uriPath = '/tmp/' . $newName;
            $size = $file->getSize();
            File::copy($file->path(), storage_path("tmp/$newName"));
            File::delete($file->path());
            $fullPath = storage_path($uriPath);
            $fileSaved = $fileRepo->create([
                'name' => $newName,
                'size' => $size,
                'mime' => $file->getClientMimeType(),
                'status' => 0,
                'uri' => $uriPath,//folder in tmp
            ]);
            $fileSaved->fullPath = $fullPath;
            $fileSaved->url = str_replace('approve', '', asset($fileSaved->uri));
            return response($fileSaved);
        }
        abort('503');
    }

    private function getNewName($name)
    {
        $extension = pathinfo($name)['extension'];
        $filename = pathinfo($name)['filename'];
        if (!in_array($extension, (array)explode(',', self::FILE_EXTENSION), true)) {
            abort(503);
        }
        return Str::slug($filename) . '-' . date('dmYHis') . '.' . $extension;
    }

    public function resizeFitThumb(Request $request)
    {
        $uri = $request->get('uri');
        $FileManager = new FileManager();
        $isResize = true;
        foreach (config('const.path_frame_video') as $framePath) {
            //nếu widh của ảnh < width của frame thì scale nhỏ lại
            [$wFrame, $hFrame] = getimagesize(public_path($framePath));
            [$wUri, $hUri] = getimagesize(storage_path($uri));
            $extension = pathinfo($framePath)['extension'];
            $filename = pathinfo($framePath)['filename'];
            if ($wUri < $wFrame) {
                $isResize = true;
                $ratio = $wUri / $wFrame;
                $newName = Str::slug($filename) . '-' . $wFrame * $ratio . '-' . $hFrame * $ratio . '.' . $extension;
                $newPath = 'tmp' . DIRECTORY_SEPARATOR . $newName;
                $FileManager->resizePng(public_path($framePath), storage_path($newPath), $ratio * 100, 9);// resize theo tỉ lể ảnh/frame
                $newUrls[] = str_replace('approve', '', asset($newPath));// thay đổi uri mới phù hợp tỉ lệ
            } else {
                $newUrls[] = asset($framePath);//giữ nguyên
            }
        }
        return response(['data' => $newUrls ?? [], 'is_resize' => $isResize ?? false]);
    }

    public function generateThumb(FileManagedRepository $fileRepo, Request $request)
    {
        $id = $request->get('id', '');
        $fileData = $fileRepo->find($id);
        if (empty($fileData)) {
            return response(['status' => 'SUCCESS', 'data' => []]);
        }
        $ffprobe = FFProbe::create(
            [
                'ffmpeg.binaries' => exec('which ffmpeg'),
                'ffprobe.binaries' => exec('which ffprobe')
            ]
        );
        $duration = $ffprobe->format(storage_path($fileData->uri))
            ->get('duration');
        $ffmpeg = FFMpeg::create(
            [
                'ffmpeg.binaries' => exec('which ffmpeg'),
                'ffprobe.binaries' => exec('which ffprobe')
            ]);
        $video = $ffmpeg->open(storage_path($fileData->uri));
        $seconds = $request->get('seconds', [0, random_int(1, $duration * 0.3), random_int(1, $duration), random_int($duration * 0.3, $duration * 0.6), random_int($duration * 0.3, $duration)]);
        $info = pathinfo($fileData->name);
        $imgBasename = basename($fileData->name, '.' . $info['extension']);
        foreach ($seconds as $second) {
            $imgName = $imgBasename . "-" . $second . ".jpg";
            $uri = "tmp" . DIRECTORY_SEPARATOR . $imgName;//save in tmp
            $uriFullPath = storage_path($uri);
            $video->frame(TimeCode::fromSeconds($second))
                ->save($uriFullPath);
            $wH = getimagesize($uriFullPath);
            $assetUrls[] = [
                'name' => $imgName,
                'size' => File::size($uriFullPath),
                'width' => $wH[0],
                'height' => $wH[1],
                'mime' => File::mimeType($uriFullPath),
                'status' => 0,
                'uri' => $uri,//folder in tmp
                'url' => str_replace('approve', '', asset($uri))
            ];
        }
        return response(['status' => 'SUCCESS', 'data' => $assetUrls ?? []]);
    }

}

