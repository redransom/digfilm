<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\SiteContent;
use App\Models\Role;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateSiteContentRequest;
use App\Http\Requests\UpdateSiteContentRequest;
use Flash;
use Illuminate\Http\Request;

class SiteContentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $sitecontents = SiteContent::paginate(10);

        return View("sitecontents.all")
            ->with('sitecontents', $sitecontents)
            ->with('authUser', $authUser)
            ->with('page_name', 'sitecontents')
            ->with('instructions', 'All Site Content')
            ->with('title', 'Content');
    }

    /**
     * Create new content - types are C - Page Content / N - News or Blog 
     *
     * @return Response
     */
    public function create($type = 'C')
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $sections = $this->get_sections();

        return View("sitecontents.add")
            ->with('authUser', $authUser)
            ->with('type', $type)
            ->with('sections', $sections)
            ->with('page_name', 'sitecontent-add')
            ->with('instructions', 'Add page content or news/blog articles.')
            ->with('title', 'Add SiteContent');
    }

    private function get_sections() {
        return ['ABT' => 'About Us', 
                'TER' => 'Terms & Conditions',
                'RUL' => 'Rules',
                'PRI' => 'Privacy',
                'CON' => 'Contact'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateSiteContentRequest $request)
    {
        //      
        $input = Input::all();
        $sitecontent = SiteContent::create( $input );

        if ($request->file('thumbnail') != "") {
            $imageName = $sitecontent->id.'thumb_'.str_replace(' ', '_', strtolower(str_slug($input['title']))) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->thumbnail = "/images/sitecontents/".$imageName;
            $sitecontent->save();
        }

        if ($request->file('main_image') != "") {
            $imageName = $sitecontent->id.'main_'.str_replace(' ', '_', strtolower(str_slug($input['title']))) . '.' . $request->file('main_image')->getClientOriginalExtension();
            $request->file('main_image')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->main_image = "/images/sitecontents/".$imageName;
            $sitecontent->save();
        }

        Flash::message('Content created.');
        return Redirect::route('sitecontent.index');

    }

    /**
     * Display the specified resource.
     *  
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $sitecontent = SiteContent::find($id);
        $title = "SiteContent ".$sitecontent->name;

        return View("sitecontents.show")
            ->with('authUser', $authUser)
            ->with('sitecontent', $sitecontent)
            ->with('object', $sitecontent)
            ->with('page_name', 'sitecontent-show')
            ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $sitecontent = SiteContent::find($id);
        $title = "Edit Content for ".$sitecontent->title;

        $sections = $this->get_sections();

        return View("sitecontents.edit")
            ->with('content', $sitecontent)
            ->with('authUser', $authUser)
            ->with('sections', $sections)
            ->with('page_name', 'sitecontent-edit')
            ->with('object', $sitecontent)
            ->with('title', $title);

/*        return View("sitecontents.edit")
            ->with('authUser', $authUser)
            ->with('sitecontent', $sitecontent)
            ->with('object', $sitecontent)
            ->with('page_name', 'sitecontent-edit')
            ->with('title', $title);
*/    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateSiteContentRequest $request)
    {
        //
        $sitecontent = SiteContent::find($id);
        $input = $request->all();

        $sitecontent->section = $input['section'];
        $sitecontent->title = $input['title'];
        if ($sitecontent->type == 'N')
            $sitecontent->summary = $input['summary'];

        $sitecontent->body = $input['body'];

        if ($request->file('thumbnail') != "") {
            $imageName = $sitecontent->id.'thumb_'.str_replace(' ', '_', strtolower(str_slug($input['title']))) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->thumbnail = "/images/sitecontents/".$imageName;
            $sitecontent->save();
        }

        if ($request->file('main_image') != "") {
            $imageName = $sitecontent->id.'main_'.str_replace(' ', '_', strtolower(str_slug($input['title']))) . '.' . $request->file('main_image')->getClientOriginalExtension();
            $request->file('main_image')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->main_image = "/images/sitecontents/".$imageName;
            $sitecontent->save();
        }

        Flash::message($sitecontent->title.' content has been updated!');
        $sitecontent->save();

        return Redirect::route('sitecontent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
