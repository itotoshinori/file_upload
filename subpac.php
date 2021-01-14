    <?
    function randomstr($length)
    {
        return substr(base_convert(md5(uniqid()), 16, 36), 0, $length);
    }