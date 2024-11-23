<?php

namespace App\HelpersClasses;

use DateTime;
use Illuminate\Support\Carbon;

class StringProcess
{
    /**
     * @param string $str
     * @return string
     * @author moner khalil
     */
    public function camelCase(string $str): string
    {
        $i = array("-", "_");
        $str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $str);
        $str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
        $str = str_replace($i, ' ', $str);
        $str = str_replace(' ', '', ucwords(strtolower($str)));
        $str = strtolower(substr($str, 0, 1)) . substr($str, 1);
        return ucfirst($str);
    }

    /**
     * @param string $title
     * @param $model
     * @param string $column
     * @return string
     * @author moner khalil
     */
    function uniqueSlug(string $title, $model, string $column = 'slug'): string
    {

        $slug = $title;

        $string = mb_strtolower($slug, "UTF-8");;
        $string = preg_replace("/[\/.]/", " ", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $slug = preg_replace("/[\s_]/", '-', $string);

        //get unique slug...
        $nSlug = $slug;
        $i = 0;

        while (($model->where($column, '=', $nSlug)->count()) > 0) {
            $nSlug = $slug . '-' . ++$i;
        }

        return ($i > 0) ? substr($nSlug, 0, strlen($slug)) . '-' . $i : $slug;
    }

    /**
     * @description Check String is Date and Convert to YYYY-MM-DD
     * @param null||string $inputString
     * @return false|string
     * @author moner khalil
     */
    public function DateFormat(?string $inputString){
        $formats = [
            'Y-m-d',
            'd-m-Y',
            'd/m/Y',
            'm/d/Y',
        ];
        $isValid = false;
        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $inputString);
            if ($date !== false && $date->format($format) === $inputString) {
                $isValid = true;
                $inputString = Carbon::createFromFormat($format, $inputString)->format('Y-m-d');
                break;
            }
        }
        return $isValid ? $inputString : false;
    }
}
