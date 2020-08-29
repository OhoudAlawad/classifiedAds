<?php


namespace App\Repositories\Favorites;


Interface FavoriteInterface
{
    public function store($request);

    public function show($id);

    public function delete($id);
}

?>
