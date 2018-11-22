<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Collaborator;
use App\Traits\UserLogTrait;

class HomeController extends Controller
{
    use UserLogTrait;

    public function index(){
        $isActive = checkActiveSession();

        if ($isActive){

            $this->logActivity(" viewed the Homepage.");
            $usr = session()->get('user_id');
            $user_details = getUserDetails();

            $projects = getAllProjects();
            $project_list = [];
          
            //get all projects depending user_level
            if($user_details['user_level'] == '4'){

                $project_list = $this->getProjects($projects);
         
            }else{
                
                $user_id = session()->get('user_id');

                $user = User::where('id', $user_id)
                        ->first();
                
                $user_projects = $user->projects;

                $project_list = $this->getProjects($user_projects);

               
            }

            return view('pages.home')->with('user_details', $user_details)
                                    ->with('project_list', $project_list);
        }else{
            return redirect('/login')->with('error','Session has expired!');
        }
    }

    private function getProjects($projects){
        $project_list_items = [];

        //get the collaborators
        foreach($projects as $project){

            if ($project->active == 1){

                $collaborators = [];
                $emails = [];
                foreach($project->users as $collaborator){
                    $collaborators[] = $collaborator->full_name;
                    $emails[] = $collaborator->email;
                }
                
                $single_proj = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'collaborators' => $collaborators,
                    'emails' => $emails
                ];

                $project_list_items[] = $single_proj;
            }
        }

        return $project_list_items;
    }

    private function getInfo($project_id) {
        //collect project
        $email_collection = [];
        $project_collection =  Project::where('id', $project_id)->first();
        $user_details = $project_collection->users;

        if ($project_collection->active == 1 ){
            $collaborators = [];
            $emails = [];
            foreach($project_collection->users as $collaborator){
                $collaborators[] = $collaborator->fullname;
                $emails[] = $collaborator->email;
            }

            $single_proj = [
                'id' => $project_collection->id,
                'name' => $project_collection->name,
                'collaborators' => $collaborators,
                'emails' => $emails
            ];

            $email_collection[] = $single_proj;
        }

        return $email_collection;
    }
}
