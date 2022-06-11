<?php

namespace Tessmann\Helpers;

class LoaderComponentHelper
{
    /**
     * @param string $section
     * @param int $post_id
     * @param int $size
     * @return string
     */
    public static function add($section, $post_id, $size)
    {
        $loader = plugin_dir_url( dirname( __FILE__ ) ) . 'src/img/loader.gif';
        return '<img class="' . $section . '-loader-' . $post_id . '" src="' . $loader . '" style="width:' . $size . 'px; display:none;" />';
    }
}
