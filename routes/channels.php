<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('room_{room_id}', function () {
    return true;
});
