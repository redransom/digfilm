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
    public function index($type = '')
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        if ($type == '') {
            $sitecontents = SiteContent::paginate(10);
            $title = 'Site Content';
        }
        else {
            $sitecontents = SiteContent::where('type', $type)->paginate(10);
            if ($type == 'F')
                $title = 'Front Page Slider Content';
            elseif ($type == 'C')
                $title = 'Page Content';
            elseif ($type == 'N')
                $title = 'News/Blog Content';                
            elseif ($type == 'M')
                $title = 'Movie Review';
        }
        $sections = $this->get_sections();

        return View("sitecontents.all")
            ->with('sitecontents', $sitecontents)
            ->with('authUser', $authUser)
            ->with('page_name', 'sitecontents')
            ->with('sections', $sections)
            ->with('title', 'All '.$title);
    }

    /**
     * Create new content - types are C - Page Content / N - News or Blog 
     *
     * @return Response
     */
    public function create($type = 'C', $movie_id = 0)
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $sections = $new_sections = null;

        $movie = null;
        if ($movie_id != 0) {
            $movie = Movie::find($movie_id);
        }
        if ($type == 'C') {
            $sections = $this->get_sections();

            $current_sections = SiteContent::where('type', 'C')->lists('section');
            $new_sections = array();
            foreach($sections as $available_section_key => $available_section_label)
                if (!in_array($available_section_key, $current_sections))
                    $new_sections[$available_section_key] = $available_section_label;
        }


        return View("sitecontents.add")
            ->with('authUser', $authUser)
            ->with('type', $type)
            ->with('movie', $movie)
            ->with('sections', $new_sections)
            ->with('page_name', 'sitecontent-add')
            ->with('title', 'Add Site Content');
    }

    private function get_sections() {
        return ['HOM'=> 'Home Page',
                'ABT' => 'About Us', 
                'TER' => 'Terms & Conditions',
                'RUL' => 'Rules',
                'PRI' => 'Privacy',
                'CON' => 'Contact',
                'LOG' => 'Login',
                'PRO' => 'Profile',
                'REG' => 'Register',
                'COF' => 'Contact Footer',
                'CRS' => 'Contact Right Side'];
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
        $sitecontent->slug = str_slug($sitecontent->title, "-");

        if (isset($input['movies_id']))  {
            $sitecontent->movies_id = $input['movies_id'];
        }

        if ($request->file('thumbnail') != "") {
            $imageName = $sitecontent->id.'thumb_'.str_replace(' ', '_', strtolower(str_slug($input['title']))) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->thumbnail = "/images/sitecontents/".$imageName;
        } else
            $sitecontent->thumbnail = null;

        if ($request->file('main_image') != "") {
            $imageName = $sitecontent->id.'main_'.str_replace(' ', '_', strtolower(str_slug($input['title']))) . '.' . $request->file('main_image')->getClientOriginalExtension();
            $request->file('main_image')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->main_image = "/images/sitecontents/".$imageName;
        } else
            $sitecontent->main_image = null;
            
        $sitecontent->save();

        Flash::message('Content created.');
        if ($input['type'] == 'M') {
            //redirect to movies show page
            return Redirect::route('movies.show', [$input['movies_id']]);
        }
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

        $sections = null;
        if ($sitecontent->type == 'C')
            $sections = $this->get_sections();

        return View("sitecontents.edit")
            ->with('content', $sitecontent)
            ->with('authUser', $authUser)
            ->with('sections', $sections)
            ->with('page_name', 'sitecontent-edit')
            ->with('object', $sitecontent)
            ->with('title', $title);
    }

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
        $sitecontent->slug = str_slug($sitecontent->title, "-");
        if(isset($input['link_url']) && !empty($input['link_url']))
            $sitecontent->link_url = $input['link_url'];

        if (isset($input['meta_keywords']) && !empty($input['meta_keywords']))
            $sitecontent->meta_keywords = $input['meta_keywords'];

        if (isset($input['meta_description']) && !empty($input['meta_description']))
            $sitecontent->meta_description = $input['meta_description'];
        
        if ($sitecontent->type == 'N' || $sitecontent->type == 'F')
            $sitecontent->summary = $input['summary'];

        $sitecontent->body = $input['body'];

        if ($request->file('thumbnail') != "") {
            $imageName = $sitecontent->id.'thumb_'.str_replace(' ', '_', strtolower(str_slug($input['title']))).str_random(5) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->thumbnail = "/images/sitecontents/".$imageName;
        }

        if ($request->file('main_image') != "") {
            $imageName = $sitecontent->id.'main_'.str_replace(' ', '_', strtolower(str_slug($input['title']))).str_random(5) . '.' . $request->file('main_image')->getClientOriginalExtension();
            $request->file('main_image')->move(base_path() . '/public/images/sitecontents/', $imageName);

            $sitecontent->main_image = "/images/sitecontents/".$imageName;
        }
        $sitecontent->save();

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
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $content = SiteContent::find($id);
            $message = "";
            if (!empty($content)) {
                $message = "Content " .$content->title. " has been removed.";
                $content->delete();
            }
        } else 
            $message = 'You don\'t have the permissions to complete this task.';

        Flash::message($message);
        return redirect()->back();
    }

    /**
     * Disable the site content
     *
     * @param  int  $id
     * @return Response
     */
    public function disable($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $content = SiteContent::find($id);
            $message = "";
            if (!empty($content)) {
                $message = "Content " .$content->title. " has been disabled.";
                Flash::message($message);
                $content->enabled = false;
                $content->save();
            }
        } else 
            Flash::message('You don\'t have the permissions to complete this task.');

        return redirect()->back();
    }

    /**
     * Enable the site content
     *
     * @param  int  $id
     * @return Response
     */
    public function enable($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $content = SiteContent::find($id);
            $message = "";
            if (!empty($content)) {
                $message = "Content " .$content->title. " has been enabled.";
                Flash::message($message);
                $content->enabled = true;
                $content->save();
            }
        } else 
            Flash::message('You don\'t have the permissions to complete this task.');

        return redirect()->back();
    }

}
