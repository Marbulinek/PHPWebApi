<?php
/**
 * IAuthentification Interface
 */
interface IAuthentification
{
    public function validate();
    public function refresh();
    public function generate($auth);
}
?>