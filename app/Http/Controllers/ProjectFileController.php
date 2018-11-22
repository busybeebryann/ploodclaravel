<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\ProjectFile;
use App\Traits\ProjectReportTrait;
use Storage;
use \Crypt;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;


class ProjectFileController extends Controller
{
    use ProjectReportTrait;
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public  $collaborators_info = [];
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'uploadFile' => 'required',
    	]);

    	if ($request->hasFile('uploadFile')) {
    		$files = $request->file('uploadFile');

    		foreach ($files as $file){

                //get original file name
    			$filename = $file->getClientOriginalName();

    			$filegetcontents = file_get_contents($file);
                //moving the files
    			$filepath = storage_path('app/uploads/') . $filename;
                //encrypt the file contents
    			$encrypted = encrypt($filepath);
                // encrypt file part
    			$fileEncrypt = Crypt::encrypt(file_get_contents($file->getRealPath()));

    			$projectFile = new ProjectFile;
    			$projectFile->project_id = $request->project_id;
    			$projectFile->encrypted_file_path = $encrypted;

    			if(File::exists(storage_path('/app/uploads/') . $filename)){
    				$actual_name = pathinfo($filepath,PATHINFO_FILENAME);
    				$original_name = $actual_name;
    				$extension = pathinfo($filepath, PATHINFO_EXTENSION);
    				$i = 1;
    				do {
    					$actual_name = (string)$original_name.'('.$i.')';
    					$name = $actual_name.".".$extension;
    					$i++;
    				} while(File::exists(storage_path('app/uploads/' . $name)));
    				$filenameNew = pathinfo($filepath, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . $name;
    				$projectFile->file_name = pathinfo($filenameNew, PATHINFO_BASENAME);
    				$projectFile->file_path = $filenameNew;
    				$projectFile->encrypted_content = File::put($filenameNew, $fileEncrypt);
    				$projectFile->save();
    			} else {
    				$projectFile->file_name = $filename;
    				$projectFile->file_path = $filepath;
    				$projectFile->encrypted_content = File::put($filepath, $fileEncrypt);
    				$projectFile->save();
                }
                
    			$project_id = $request->project_id;
    			$path  = $projectFile->file_path;
                $message = "uploaded";
                
              
               //send email
                $this->sendEmailNotif($message, $projectFile->file_name,$project_id);

                $this->logProjectReport(" has uploaded file: " . $projectFile->file_name, $request->project_id);
            }
            
            if ($projectFile){
           
             return redirect('/projects/'. $request->project_id)->with('success', 'File has been uploaded!');
         }
         else{
             return redirect('/projects/'. $request->project_id)->with('error', 'Error saving uploaded file to Database. Check your connection and Try again!');
         }

        } else {
                //this should be before the form submits
        return redirect('/projects/'. $request->id)->with('error', 'No file uploaded!');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }

    public function download(Request $request)
    {
    	$path = $request->project_file;
    	$project_name = $request->project_name;
    	$message = "downloaded";
        //send email notif
        //$this->sendEmailNotif($message, $path, $project_name);
        //make tmp folder
       $tmp_dir = storage_path('app/uploads/tmp/'); 
       if( is_dir($tmp_dir) === false ){
          mkdir($tmp_dir,0777,true);
          chmod($path, 0777);
      }      
        // copy download file to tmp folder
      $tmp_file = storage_path('app/uploads/tmp/' . pathinfo($path, PATHINFO_BASENAME));
      File::copy($path, $tmp_file);

     //Decrypt file in tmp
      $getFileDecrypt = Crypt::decrypt(file_get_contents($tmp_file));
      $decryptedFile = File::put($tmp_file, $getFileDecrypt);
      $this->logProjectReport(" has downloaded file: " . $path . " in ", $request->project_id);

    //Download file
      return response()->download($tmp_file)->deleteFileAfterSend(true);
    }

    public function delete(Request $request)
    {
        $project_id = $request->project_file_id;
        $path       = $request->project_file_path;
        $message    = "deleted";
        $projectFile  = ProjectFile::where('project_id', $project_id)
        ->where('file_path', $path)
        ->delete();

        if ($projectFile){
            File::delete($path);
            
          
            //send email
            //$this->sendEmailNotif($message, $path,  $project_id);

            $this->logProjectReport(" has successfully deleted a file in ", $project_id);

            return redirect('/projects/'. $project_id)->with('success', 'A File has been Deleted!');
        }
        else{
            $this->logProjectReport(" has encountered a problem while deleting a file.", $project_id);
            return redirect('/projects/'. $project_id)->with('error', 'Error deleting file in Database. Check your connection and Try again!');
        }

    }

    public function sendEmailNotif($message, $file, $project_id) {
        $mail_prop = $file;
        $user_id = session()->get('user_id');
        $session_user = User::where('id', $user_id)->first();
        //collect collaborators info
        $collaborators_info = $this->getInfo($project_id);
  
        return Mail::to($collaborators_info[0]['emails'])
                    ->send(new EmailNotification($session_user['username'], $message, $mail_prop, $project_id,$collaborators_info[0]['name']));   
    }
    //
    public function getInfo($project_id) {
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