<?php
/**
 * @package wa-apps/blog
 */
abstract class waSettingWrapper
{
    /**
     *
     * @return array()
     */
    abstract public function store();
    /**
     *
     * @param $value mixed
     */
    abstract public function update($value);
}
