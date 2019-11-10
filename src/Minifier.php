<?php

namespace MinThemAll;

class Minifier extends \MatthiasMullie\Minify\CSS  {
    protected $imageExtensions = [
        '.gif',
        '.png',
        '.jpe',
        '.jpg',
        '.jpeg',
        '.svg',
        '.woff',
        '.tif',
        '.tiff',
        '.xbm'
    ];

    protected function importFiles($source, $content)
    {
        $regex = '/url\((["\']?)(.+?)\\1\)/i';
        if (preg_match_all($regex, $content, $matches, PREG_SET_ORDER)) {
            $search = [];
            $replace = [];
            // loop the matches
            foreach ($matches as $match) {
                $path = $match[2];

                if (!$this->isImage($path)) {
                    continue;
                }

                $importContent = file_get_contents($path);
                $importContent = base64_encode($importContent);

                $search[] = $match[0];
                $type = "image/jpeg";
                $replace[] = 'url(data:'.$type.';base64,'.$importContent.')';
            }
            $content = str_replace($search, $replace, $content);
        }

        return $content;
    }

    protected function combineImports($source, $content, $parents)
    {
        return $content;
    }

    protected function isImage($path)
    {
        foreach ($this->imageExtensions as $ext) {
            if (stripos($path, $ext) > 0) {
                return true;
            }
        }
        return false;
    }

}
