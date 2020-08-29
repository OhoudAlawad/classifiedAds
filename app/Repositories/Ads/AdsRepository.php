<?php
namespace App\Repositories\Ads;
use App\Traits\ImageUploadTrait;
use App\Models\ {
    Ad,
    Favorite,
    Image
};


class AdsRepository implements AdInterface
{
    use ImageUploadTrait;

    protected $ads;

    public function __construct(Ad $ads)
    {
        $this->ads=$ads;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function store($request)
    {
        $ad = $request->user()->ads()->create($request->all()+['slug'=>$request->title]);

        if($request->file('images'))
            $this->storeImags($ad,$request->file('images'));
    }

    public function getDetails($id)
    {
        // TODO: Implement getDetails() method.
        return $this->ads::with('comments')->find($id);

    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->ads::find($id);

    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
        $request->merge(['user_id' => $request->user()->id]);

        return $this->ads->find($id)->update($request->all());
    }

    public function getByUser()
    {
        // TODO: Implement getByUser() method.
        return $this->ads::select('id','title','price','slug','created_at')->whereUser_id(\Auth::user()->id)->get();
    }

    public function storeImags($ad,$imgArry)
    {
        foreach($imgArry as $img)
        {
            $img_name=$this->saveImages($img);

            $image=new Image();
            $image->image = $img_name;
            $ad->images()->save($image);
        }
    }

    public function getByCategory($catId)
    {
        // TODO: Implement getByCategory() method.
        return $this->ads::with('images','category')->where('category_id',$catId)->get();

    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->ads->findOrFail($id)->delete();
    }

    public function search($request)
    {
        return $this->ads->Filter($request);
    }

    public function getCommonAds()
    {

        return $this->ads::with('images')->select('id','title','slug','price')->whereIn('id',
            Favorite::select('ad_id')
            ->groupBy('ad_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(8)
            ->get()
        )->get();
    }

}
