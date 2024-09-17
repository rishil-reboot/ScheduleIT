<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Backup;
use Session;

class BackupController extends Controller
{
    public function index() {
      $data['backups'] = Backup::orderBy('id', 'DESC')->paginate(10);
      return view('admin.backup', $data);
    }

    public function store() {
      
      $filename = uniqid() . '.sql';
      $host = 'localhost';
      $username = env('DB_USERNAME');
      $password = env('DB_PASSWORD');
      $database = env('DB_DATABASE');
      // Command to export the database using mysqldump
      $command = "mysqldump --host=$host --user=$username --password=$password $database > core/storage/app/public/".$filename."";
      // Execute the command using shell_exec
      $output = shell_exec($command);
      // Check if the command was executed successfully
      if ($output === null) {

          $backup = new Backup;
          $backup->filename = $filename;
          $backup->save();

          Session::flash('success', 'Backup saved successfully');

      }else {

          Session::flash('error', 'Error exporting database');
      }

      return back();

    }

    public function download(Request $request) {
      return response()->download('core/storage/app/public/'.$request->filename, 'backup.sql');
    }

    public function delete($id) {
      $backup = Backup::find($id);
      @unlink('core/storage/app/public/'.$backup->filename);
      $backup->delete();

      Session::flash('success', 'Database sql file deleted successfully!');
      return back();
    }
}