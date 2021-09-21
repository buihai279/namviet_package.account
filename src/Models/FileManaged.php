<?php

namespace Namviet\Account\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

class FileManaged extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected static $fieldFile = 'files';
    protected static $fieldFileUri = 'file_uris';
    protected $collection = 'files';
    protected $connection = 'mongodb';
    protected $fillable = [
        'name', 'size', 'mime', 'status', 'uri'
    ];
    protected $casts = [
        "url" => "string",
    ];

    public static function showFile(&$data)
    {
        $fileObj = [];
        if (empty($data['files']) || !is_array($data['files'])) {
            return $data;
        }
        $files = $data['files'];
        unset($data['files']);
        $ids = Arr::flatten($files, 2);
        $fileData = FileManaged::whereIn('_id', $ids)->get();
        if (empty($fileData)) {
            return $data;
        }
        $arr = [];
        foreach ($fileData as $key => $value) {
            $arr[$value['_id']] = $value;
        }
        foreach ($files as $type => $fileArr) {
            if (!is_array($fileArr) || empty($fileArr)) continue;
            foreach ($fileArr as $k => $id) {
                if (!empty($arr[(string)$id])) {
                    $fileObj[$type][] = $arr[(string)$id];
                }
            }
        }
        $data['files'] = $fileObj;
        return $data;
    }

    public static function getInfoByUri($uris)
    {
        if (empty($uris)) {
            return [];
        }
        if (is_string($uris)) {
            $uris = [$uris];
        }
        if (is_array($uris)) {
            $files = self::whereIn('uri', $uris)->get();
            foreach ($files as $key => $file) {
                $fileInfos[$key] = $file->toArray();
                $fileInfos[$key]['url'] = asset($file->uri);
            }
        }
        return $fileInfos ?? [];
    }

    public static function processFile(&$data)
    {
        $fileObj = $fileUris = [];
        if (empty($data['files']) || !is_array($data['files'])) {
            return $data;
        }
        $files = $data['files'];
        unset($data['files']);
        foreach ($files as $key => $item) {
            if (empty($item)) continue;
            if (is_string($item) && json_decode($item)) {
                $json = json_decode($item);
                self::moveFile($json);
                $fileObj[$key][] = json_decode($item);
            } else if (is_array($item)) {
                foreach ($item as $file) {
                    if (is_string($file) && json_decode($file)) {
                        $json = json_decode($file);
                        self::moveFile($json);
                        $fileObj[$key][] = $json;
                        $fileUris[$key][$json->_id] = $json->uri;
                    }
                }
            } else {
                continue;
            }
            $fileIds = data_get($fileObj, $key . '.*._id');
            $fileObjIds = array_map(function ($id) {
                return new ObjectId($id);
            }, $fileIds);
            $data['files'][$key] = $fileObjIds;
            $data['file_uris'] = $fileUris;
        }
        return $data;
    }

    private static function moveFile(&$file)
    {
        $module_name = 'posts_files';
        $pretty_mime = strtolower($file->mime);
        $extract_mime = explode('/', $pretty_mime);
        $data_file_path = 'data_files';
        $folder_structure = array(
            $data_file_path,
            $module_name,
            $extract_mime[0],
            date('Ym'),
            date('d'),
        );

        $folder_path = storage_path('');
        foreach ($folder_structure as $item) {
            $folder_path .= DIRECTORY_SEPARATOR . $item;
            if (File::isDirectory($folder_path) !== true) {
                File::makeDirectory($folder_path, 0755);
            }
        }
        if (!File::isFile($folder_path . DIRECTORY_SEPARATOR . $file->name) && File::isFile(storage_path() . $file->uri)) {
//            File::copy(storage_path($file->uri)  , $folder_path . DIRECTORY_SEPARATOR . $file->name);
//            File::delete(storage_path($file->uri));
            File::move(storage_path() . $file->uri, $folder_path . DIRECTORY_SEPARATOR . $file->name);
            $filePath = implode('/', $folder_structure);
            $file->uri = $filePath . DIRECTORY_SEPARATOR . $file->name;
        }
        if ($file->status === 0) {
            $check = self::where('_id', new ObjectId($file->_id))->update(['status' => 1, 'uri' => $file->uri], ['upsert' => true]);
        }
        return $file;
    }

    public static function showFileCustom(&$data)
    {
        $fieldName = self::$fieldFile;
        if (empty($data[$fieldName]) || !is_array($data[$fieldName])) {
            return $data;
        }
        $files = $data[$fieldName];
        $ids = Arr::flatten($files, 2); //get all id from $data['files']
        if (empty($ids)) {
            return $data;
        }
        $fileArr = self::whereIn('_id', $ids)->get()->toArray();
        if (empty($fileArr)) {
            return $data;
        }
        foreach ($fileArr as $key => $value) {
            $arr[$value['_id']] = $value;
        }
        $fileNews = array_map(static function ($fileType) use ($arr) {
            return array_map(static function ($id) use ($arr) {
                if (!empty($arr[(string)$id])) {
                    return $arr[(string)$id];
                }
            }, $fileType);
        }, $files);
        $data[$fieldName] = $fileNews;
        return $data;
    }

    public static function processFileCustom(&$data)
    {
        $fieldFile = self::$fieldFile;
        $fieldFileUri = self::$fieldFileUri;
        $fileObj = $fileUris = [];
        if (empty($data[$fieldFile]) || !is_array($data[$fieldFile])) {
            return $data;
        }
        $files = $data[$fieldFile];
        unset($data[$fieldFile]);
        foreach ($files as $key => $item) {
            if (empty($item)) continue;
            if (is_string($item) && json_decode($item)) {
                $json = json_decode($item);
                self::moveFile($json);
                $fileObj[$key][] = json_decode($item);
            } else if (is_array($item)) {
                foreach ($item as $file) {
                    if (is_string($file) && json_decode($file)) {
                        $json = json_decode($file);
                        self::moveFile($json);
                        $fileObj[$key][] = $json;
                        $fileUris[$key][$json->_id] = $json->uri;
                    }
                }
            } else {
                continue;
            }
            $fileIds = data_get($fileObj, $key . '.*._id');
            $fileObjIds = array_map(function ($id) {
                return new ObjectId($id);
            }, $fileIds);
            $data[$fieldFile][$key] = $fileObjIds;
            $data[$fieldFileUri] = $fileUris;
        }
        return $data;
    }

    public static function showFileApi(&$data, $fieldName)
    {
        $data = (array)$data;
        $fileObj = [];
        if (empty($data[$fieldName])) {
            $data = (object)$data;

            return $data;
        }

        $fileData = self::select(['name', 'status', 'size', 'mime', 'uri'])->where('uri', $data[$fieldName])->get()->toArray();

        if (!empty($fileData)) {
            $data['files'][$fieldName][] = $fileData[0];
            $data['file_uris'] [$fieldName][$fileData[0]['_id']] = $fileData[0]['uri'];
        }

        $data = (object)$data;
        return $data;
    }

    private static function moveFileCustom(&$file)
    {
        $module_name = 'posts_files';
        $pretty_mime = strtolower($file->mime);
        $extract_mime = explode('/', $pretty_mime);
        $data_file_path = 'data_files';
        $folder_structure = array(
            $data_file_path,
            $module_name,
            $extract_mime[0],
            date('Ym'),
            date('d'),
        );

        $folder_path = storage_path('');
        foreach ($folder_structure as $item) {
            $folder_path .= DIRECTORY_SEPARATOR . $item;
            if (File::isDirectory($folder_path) !== true) {
                File::makeDirectory($folder_path, 0755);
            }
        }
        if (!File::isFile($folder_path . DIRECTORY_SEPARATOR . $file->name) && File::isFile(storage_path() . $file->uri)) {
//            File::copy(storage_path( $file->uri), $folder_path . DIRECTORY_SEPARATOR . $file->name);
//            File::delete(storage_path($file->uri));
            File::move(storage_path() . $file->uri, $folder_path . DIRECTORY_SEPARATOR . $file->name);
        }
        $filePath = implode('/', $folder_structure);
        $file->uri = $filePath . DIRECTORY_SEPARATOR . $file->name;
        if ($file->status === 0) {
            $check = self::where('_id', new ObjectId($file->_id))->update(['status' => 1, 'uri' => $file->uri]);
        }
        return $file;
    }

    public function getUrlAttribute()
    {
        return str_replace('approve', '', asset($this->uri));
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getFirst($id)
    {
        return self::find($id);
    }

    /**
     * @return string
     */
    public function getFieldFile(): string
    {
        return self::$fieldFile;
    }

    /**
     * @param string $fieldFile
     */
    public function setFieldFile(string $fieldFile): void
    {
        self::$fieldFile = $fieldFile;
    }

    /**
     * @return string
     */
    public function getFieldFileUri(): string
    {
        return self::$fieldFileUri;
    }

    /**
     * @param string $fieldFileUri
     */
    public function setFieldFileUri(string $fieldFileUri): void
    {
        self::$fieldFileUri = $fieldFileUri;
    }
}
