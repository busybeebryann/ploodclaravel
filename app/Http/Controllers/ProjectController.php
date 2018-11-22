<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Collaborator;
use App\Project;
use App\ProjectFile;
use App\ProjectReport;
use App\Traits\UserLogTrait;
use App\Traits\ProjectReportTrait;
use App\Traits\ProjectFileTrait;


class ProjectController extends Controller
{
    use UserLogTrait;
    use ProjectReportTrait;
    use ProjectFileTrait;
    /**
     * Display a listing of the Projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/home');
    }

    /**
     * Show the form for creating a new Project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        $user_details = getUserDetails();

        $this->logActivity(" is trying to create a Project.");

        return view('projects.create')->with('user_details', $user_details)
                                    ->with('users', $users);
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate field
        $this->validate($request, [
            'projectname' => 'required',
            'description' => 'required',
            'collab' => 'required',
        ]);

        $project = new Project;
        $project->name = $request->projectname;
        $project->description = $request->description;
        $project->active = '1';
        $project->save();

        $collabArray = $request->collab;
        $project_id = $project->id;

        if($project){
            foreach ($collabArray as $key) {
                foreach ($key as $k => $value) {
                    $collab = new Collaborator;
                    $collab->project_id = $project_id;
                    $collab->user_id = $value;
                    $collab->save();
                }
            }

            if ($collab){
                $this->logActivity(" has created a new Project: " . $project->name);
                return redirect('/projects')->with('success', 'New Project has been added!');
            }else{
                $this->logActivity(" has encountered a problem while creating new Project.");
                return redirect('/projects/create')->with('error', 'Error saving New Project to Database. Check your connection and Try again!');
            }
        }else{
            $this->logActivity(" has encountered a problem while creating new Project.");
            return redirect('/projects/create')->with('error', 'Error saving New Project to Database. Try Again');
        }

    
        

    }

    /**
     * Display the specified Project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $user_details = getUserDetails();

        $collection_to_sort = collect($project->project_file);
        $sorted_project_file = $collection_to_sort->sortByDesc('created_at');

        foreach ($project->project_file as $project_file) {
            //get the extension
            $filename = explode( '.', $project_file['file_name']);
            $count_explode = count($filename);
            $mimetype = strtolower($filename[$count_explode-1]);
            //get the mime type
            $project_file->mimetype = $this->checkMimeType($mimetype);
        }

        $this->logActivity(" has viewed Project: " . $project->name);
        //$this->logProjectReport(" has viewed ", $project_id);

        return view('projects.single')->with('project', $project)
                                      ->with('user_details', $user_details)
                                      ->with('sorted_project',$sorted_project_file);
                                     //->with('project_report', $project_reports);
    }

    private function checkMimeType($mimetype){

        $icon_classes = array(

            // images
            'png' => 'fa-file-image-o',
            'jpe' => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'jpg' => 'fa-file-image-o',
            'gif' => 'fa-file-image-o',
            'bmp' => 'fa-file-image-o',
            'ico' => 'fa-file-image-o',
            'tiff' => 'fa-file-image-o',
            'tif' => 'fa-file-image-o',
            'svg' => 'fa-file-image-o',
            'svgz' => 'fa-file-image-o',

            // audio/video
            'mp3' => 'fa-file-audio-o',
            'qt' => 'fa-file-audio-o',
            'mov' => 'fa-file-video-o',
            'mp4' => 'fa-file-video-o',
            'flv' => 'fa-file-video-o',
            'avi' => 'fa-file-video-o',
            'mkv' => 'fa-file-video-o',


            // ms office
            'doc' => 'fa-file-word-o',
            'rtf' => 'fa-file-word-o',
            'xls' => 'fa-file-excel-o',
            'ppt' => 'fa-file-powerpoint-o',
            'docx' => 'fa-file-word-o',
            'xlsx' => 'fa-file-excel-o',
            'pptx' => 'fa-file-powerpoint-o',

            //documents
            'txt' => 'fa-file-text-o',
            'htm' => 'fa-file-code-o',
            'html' => 'fa-file-code-o',
            'php' => 'fa-file-code-o',
            'css' => 'fa-file-code-o',
            'js' => 'fa-file-code-o',
            'json' => 'fa-file-code-o',
            'xml' => 'fa-file-code-o',

            // archives
            'zip' => 'fa-file-archive-o',
            'rar' => 'fa-file-archive-o',
            'exe' => 'fa-file-archive-o',
            'msi' => 'fa-file-archive-o',
            'cab' => 'fa-file-archive-o',

          );

          if(isset($icon_classes[$mimetype])){
            return $icon_classes[$mimetype];
          }
          else {
            return "fa-file-o";
          }
    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects = getAllProjects();
        $users = User::all();

        $user_details = getUserDetails();
        $project_details = Project::where('id', $id)
            ->first();

        $collab_details = Collaborator::where('project_id', $id)
            ->get();

        $this->logActivity(" is trying to update Project: " . $project_details->name);

        return view('projects.edit')->with('project_details', $project_details)
                                    ->with('project', $projects)
                                    ->with('user_details', $user_details)
                                    ->with('users', $users)
                                    ->with('collab_details', $collab_details);
    }

    /**
     * Update the specified Project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate field
        $this->validate($request, [
            'projectname' => 'required',
            'description' => 'required',
        ]);


        $project = Project::where('id', $id)
                ->first();
        $project->name = $request->projectname;
        $project->description = $request->description;
        $project->active = '1';
        $project->save();

        $collabArray = $request->collab;
        $project_id = $project->id;

        $collab = Collaborator::where('project_id', $project_id)
            ->get();


        if($project){
            // if collab is empty
            if(!$collab->count()){
                // if there is collected data from collab array in edit view >>
                if(is_null($collabArray)){
                    return redirect('/projects/'. $project_id .'/edit')->with('success', 'Project has been updated! No collaborators added.');
                }
                // else there is collab data from array >>
                else {
                    // << add new data to collab table
                    foreach ($collabArray as $key) {
                        foreach ($key as $k => $value) {
                            $collab = new Collaborator;
                            $collab->project_id = $project_id;
                            $collab->user_id = $value;
                            $collab->save();
                        }
                    }

                    if ($collab){
                        $this->logActivity(" has succesfully updated Project: " . $project->name);
                        return redirect('/projects/'. $project_id .'/edit')->with('success', 'Project has been updated!');
                    }else{
                        $this->logActivity(" has encoountered a problem while updating Project: " . $project->name);
                        return redirect('/projects/'. $project_id .'/edit')->with('error', 'Error saving New Project to Database. Check your connection and Try again!');
                    }
                }
            }
            else {
                //put old collaboration data from table into array
                foreach ($collab as $key => $value) {
                    $oldCollabArray[] = $value['user_id'];
                }

                //put nested request array into new array
                foreach ($collabArray as $key) {
                    foreach ($key as $k => $value) {
                        $newCollabArray[] = $value;
                    }
                }
                //find the diff between old and new
                $arrayDiff = array_diff($oldCollabArray,$newCollabArray);

                foreach ($arrayDiff as $array => $user_id) {
                    $collabDelete = Collaborator::where('project_id', $project_id)
                                                ->where('user_id', $user_id)
                                                ->delete();
                }
                foreach ($newCollabArray as $newcollab) {

                    $collabUpdate = Collaborator::where('project_id', $project_id)
                                                ->where('user_id', $newcollab)
                                                ->first();

                    if(!$collabUpdate){
                        echo "create";
                        $collab = new Collaborator;
                        $collab->project_id = $project_id;
                        $collab->user_id = $newcollab;
                        $collab->save();
                    }
                    else {
                        echo "update";
                        $collabUpdate->user_id = $newcollab;
                        $collabUpdate->save();
                    }
                }

                $this->logActivity(" has succesfully updated Project: " . $project->name);
                return redirect('/projects/'. $project_id . '/edit')->with('success', 'Changes have been added!');
                
            }
        }
        else {
            $this->logActivity(" has encountered a problem while updating Project: " . $request->projectname);
            return redirect('/projects/create')->with('error', 'Error updating Project. Try Again');
        }
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "We do not delete Projects, only deactivate them!";
    }

    public function deactivate($id){

        $project = Project::where('id', $id)
                        ->first();

        $project->active = false;
        $project->save();   

        if($project){
            $this->logActivity(" has succesfully deactivated Project: " . $project->name);
            return redirect('/projects')->with('success', 'Project has been deactivated!');    
        }else{
            $this->logActivity(" has encoountered a problem while deactivating Project: " . $project->name);
            return redirect('/projects')->with('error', 'A problem was encountered while deactivating a project. Try Again.');
        }
    }

    public function archive(Request $request)
    {
        return 'here';
    }

    //Custom Functions for Project Module

    public function getArchivedProjects(){
        
        $user_details = getUserDetails();

        if ($user_details["user_level"] != 1){
            $projects = getAllProjects();
            $project_list = [];

            //get all projects depending user_level
            if($user_details['user_level'] == '4'){

                $project_list_items = [];

                //get the collaborators
                foreach($projects as $project){
                    if ($project->active == 0){

                        $collaborators = [];
                            foreach($project->users as $collaborator){
                                $collaborators[] = $collaborator->full_name;
                            }
                            
                            $single_proj = [
                                'id' => $project->id,
                                'name' => $project->name,
                                'collaborators' => $collaborators,
                            ];

                        $project_list_items[] = $single_proj;
                    }
                }

                $project_list = $project_list_items;

            }else if($user_details['user_level'] == '3'){
                //get only the projects assigned to this user
            }else if($user_details['user_level'] == '2'){
                //get only the projects assigned to this user
            }else if($user_details['user_level'] == '1'){
                //get only the projects assigned to this user
            }

            return view('projects.archive')->with('user_details', $user_details)
                                        ->with('project_list', $project_list);
        }else{
            return view('pages.error')->with('error', 'Access Denied. You are not allowed to access this page!');
        }
    }
}
