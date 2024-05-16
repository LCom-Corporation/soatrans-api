<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('offre.{offre}', function ($offre) {
    return $offre;
});

Broadcast::channel('setPlace.{offre}', function ($offre) {
    return $offre;
});

Broadcast::channel('unSetPlace.{offre}', function ($offre) {
    return $offre;
});
