<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AdsRequest;
use App\Models\Favorite;
use App\Repositories\ {
    Ads\AdInterface,
Favorites\FavoriteInterface
};


class AdsController extends Controller
{
    //
    protected $ads;

    protected $favorite;

    public function __construct(AdInterface $ads,FavoriteInterface $favorite)
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'delete']]);

        $this->ads=$ads;

        $this->favorite=$favorite;
    }
    public function all(){
        $ads=$this->ads->all();
    }
    public function create()
    {
        return view('ads.create');
    }
    public function store(AdsRequest $request)
    {
        $ads = $this->ads->store($request);

        return back()->with  ('success','تم إضافة الإعلان');
    }
    public function index()
    {
        $ads=$this->ads->getCommonAds();
        return view('index',compact('ads'));
    }
    public function getUserAds()
    {
        $userAds = $this->ads->getByUser();

        return view('ads.userAds',compact('userAds'));
    }
    public function edit($id)
    {
        $ad = $this->ads->getById($id);


        if (\Gate::allows('edit-ad', $ad)) {
            return view('ads.edit',compact('ad'));
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ads = $this->ads->update($request,$id);

        return back()->with('success','تم تعديل الإعلان');
    }
    public function destroy($id)
    {
        $this->ads->delete($id);

        return back()->with('success','تم حذف الإعلان');
    }

    public function getByCategory($id)
    {
        $ads = $this->ads->getByCategory($id);

        return view('ads.adsByCategory',compact('ads'));
    }
    public function show($id)
    {
        $ad = $this->ads->getDetails($id);
        if (\Auth::check())
            $favorited = $this->favorite->show($id);

        return view('ads.show',compact('ad'),compact('favorited'));
    }
    public function search(Request $request)
    {
        $ads=$this->ads->search($request);

        return view('ads.showResults',compact('ads'));
    }


}
