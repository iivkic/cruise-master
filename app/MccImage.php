<?php

namespace App;

use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageFormatter;

class MccImage extends Model
{
    use SoftDeletes;

    protected $table = "mcc_images";
    protected $fillable = [
        'alt', 'image_type_id', 'ch_ship_id', 'mcc_excursion_id', 'mcc_destination_id', "sequence", "url", "thumbnail_320", "thumbnail_375", "thumbnail_620", "thumbnail_768", "thumbnail_1150", "title"
    ];
    protected $appends = ["webps", "url"];

    public function getWebpsAttribute()
    {

        $object = ["url" => substr($this->url, 0, -3) . "webp",
            "thumbnail_120" => substr($this->thumbnail_120, 0, -3) . "webp",
            "thumbnail_320" => substr($this->thumbnail_320, 0, -3) . "webp",
            "thumbnail_375" => substr($this->thumbnail_375, 0, -3) . "webp",
            "thumbnail_620" => substr($this->thumbnail_620, 0, -3) . "webp",
            "thumbnail_768" => substr($this->thumbnail_768, 0, -3) . "webp",
            "thumbnail_1150" => substr($this->thumbnail_1150, 0, -3) . "webp"];
        if (App::environment('local')) {
            foreach ($object as $key => $value) {
                 if($key!="url") $object[$key] = "https://mycroatiacruise.com" . $value;
            }
        }

        return (object)$object;
    }

    function getUrlAttribute($url)
    {
        if (App::environment('local')) {
            return "https://mycroatiacruise.com" . $url;
        }
        return $url;
    }


    public static function saveForWeb($base64, $name = null, $fields = [], $subfolder = false)
    {
        $base64 = preg_replace('#^data:image/[^;]+;base64,#', '', $base64);
        $fields = array_merge(["alt" => "", "title" => "", "sequence" => 0, "portal_id" => 0, "folder_id" => 0], $fields);
        if ($name) {
            $name = pathinfo($name, PATHINFO_FILENAME);
            $name = str_replace(" ", "_", urldecode($name));
        }
        $img = ImageFormatter::make($base64);
        $model = new MccImage;

        if (!$name) $name = time();
        $name = $subfolder ? $subfolder . "/" . $name : $name;
        $ext = MccImage::extensionForImage($img);
        if (!$ext) return false;
        $counter = "";
        while (Storage::disk('public')->exists($name . $counter . $ext)) {
            if ($counter == "") $counter = 0;
            $counter++;
        }
        $fullName = $name . $counter . $ext;
        $fullNameWebp = $name . $counter . ".webp";

        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($fullName, $img->encode());
        Storage::disk('public')->put($fullNameWebp, $img->encode("webp", 70));
        $model->url = Storage::url($fullName);

        foreach ([1150, 768, 620, 375, 320] as $res) {
            $fullNameThumb = $name . $counter . "_thumb_$res" . $ext;
            $fullNameThumbWebp = $name . $counter . "_thumb_$res" . ".webp";
            $img->resize($res, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($fullNameThumb, $img->encode());
            Storage::disk('public')->put($fullNameThumbWebp, $img->encode("webp", 70));
            $model["thumbnail_" . $res] = Storage::url($fullNameThumb);
        }

        $model->alt = $fields["alt"];
        $model->image_type_id = $fields["image_type_id"];
        $model->sequence = $fields["sequence"];
        $model->title = $fields["title"];

        $model->save();
        return $model;
    }

    public static function saveForWebFromUrl($url, $name = null, $fields = [], $subfolder = false)
    {
        $image = file_get_contents($url);
        if ($image !== false) {
            $base64 = 'data:image/jpg;base64,' . base64_encode($image);
        } else return;
        $base64 = preg_replace('#^data:image/[^;]+;base64,#', '', $base64);
        $fields = array_merge(["alt" => "", "title" => "", "sequence" => 0, "portal_id" => 0, "folder_id" => 0], $fields);
        if ($name) {
            $name = pathinfo($name, PATHINFO_FILENAME);
            $name = str_replace(" ", "_", urldecode($name));
        }
        $img = ImageFormatter::make($base64);
        $model = new MccImage;

        if (!$name) $name = time();
        $name = $subfolder ? $subfolder . "/" . $name : $name;
        $ext = MccImage::extensionForImage($img);
        if (!$ext) return false;
        $counter = "";
        while (Storage::disk('public')->exists($name . $counter . $ext)) {
            if ($counter == "") $counter = 0;
            $counter++;
        }
        $fullName = $name . $counter . $ext;
        $fullNameWebp = $name . $counter . ".webp";
        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($fullName, $img->encode());
        $model->url = Storage::url($fullName);

        Storage::disk('public')->put($fullNameWebp, $img->encode("webp", 70));
        foreach ([1150, 768, 620, 375, 320] as $res) {
            $fullNameThumb = $name . $counter . "_thumb_$res" . $ext;
            $fullNameThumbWebp = $name . $counter . "_thumb_$res" . ".webp";
            $img->resize($res, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($fullNameThumb, $img->encode());
            Storage::disk('public')->put($fullNameThumbWebp, $img->encode("webp", 70));
            $model["thumbnail_" . $res] = Storage::url($fullNameThumb);
        }

        $model->alt = $fields["alt"];
        $model->image_type_id = $fields["image_type_id"];
        $model->sequence = $fields["sequence"];
        $model->title = $fields["title"];

        $model->save();
        return $model;
    }

    private static function extensionForImage($img)
    {
        $mime = $img->mime();  //edited due to updated to 2.x
        if ($mime == 'image/jpeg')
            $extension = '.jpg';
        elseif ($mime == 'image/png')
            $extension = '.png';
        elseif ($mime == 'image/gif')
            $extension = '.gif';
        else
            $extension = '';
        //TODO a šta kad je prazan sunce mu
        return $extension;
    }

}
