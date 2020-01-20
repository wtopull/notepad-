<?php

function create_token()
{
    return md5(time() . rand(0, time()));
}