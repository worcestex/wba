<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

use App;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Language::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $language = new Language($request->all());
        $language->save();

        return response()->json(['message' => 'Successful', 'data' => $request->all()], 201);


        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLanguageRequest  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanguageRequest $request, Language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {   

        
        $language = Language::find($request);
        if(!$language){
            return response()->json(['message' => 'language not found'], 404);

        }
        else{
            Language::find($request)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }

    public function changeLanguage ($locale) {

        if(!Language::where('language_code', '=',$locale )->exists())
        {
            abort(404);
        }
    
        App::setLocale($locale);
        // Session
        session()->put('locale', $locale);

        return response()->json(['message' => 'Success'], 200);

    
        return redirect()->back();


    }
}
