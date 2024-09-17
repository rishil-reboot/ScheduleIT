<?php

namespace App\Http\Controllers\Admin;

use Aws\S3\S3Client;
use Session;
use Validator;
use App\Language;
use App\Scategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ScreenRecorder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class ScreenRecorderController extends Controller
{
    public function index()
    {
        $screenRecorders = ScreenRecorder::all(); // Retrieve all records from the screen_recorder table

        return view('admin.screen_recorder.index', ['screenRecorders' => $screenRecorders]);
    }

    public function save(Request $request)
    {
        $videoData = $request->input('videoData');
        $video = base64_decode($videoData);
        $videoName = 'video_' . time() . '.webm'; // Replace with the actual video name
        Storage::disk('videos')->put($videoName, $video);
        $permanentUrl = asset('assets/videos/' . $videoName); // Fix the URL path

        // Save the video data to a temporary file
        $tempPath = storage_path('app/temp/' . $videoName);
        file_put_contents($tempPath, base64_decode($videoData));

        // Calculate video duration using the separate function
        $videoDuration = $this->calculateVideoDurationManually($tempPath);
        $videoSize = intval(filesize($tempPath)); // Size in bytes
        $formattedSize = $this->formatVideoSize($videoSize);

        // Clean up the temporary file
        @unlink($tempPath);
        // Save the video URL, duration, size, and other data to the database
        $screenRecorder = new ScreenRecorder();
        $screenRecorder->external_link = $permanentUrl;
        $screenRecorder->duration = $videoDuration;
        $screenRecorder->size = $formattedSize;
        $screenRecorder->name = $videoName;
        $screenRecorder->save();

        // Redirect or return a response as needed
        return redirect('/admin/play/' . $videoName);
    }

    
    private function calculateVideoDurationManually($videoFilePath)
    {
        // Check if the file exists
        if (!file_exists($videoFilePath)) {
            throw new \Exception('Video file not found.');
        }

        // Open the video file for reading
        $fileHandle = fopen($videoFilePath, 'rb');

        // Check if the file handle was opened successfully
        if (!$fileHandle) {
            throw new \Exception('Failed to open the video file.');
        }

        // Seek to the end of the file to get the file size
        fseek($fileHandle, 0, SEEK_END);
        $fileSize = ftell($fileHandle);
        $duration = $fileSize * 0.00000005;

        // Close the file handle
        fclose($fileHandle);

        return round($duration, 2); // Rounded to 2 decimal places
    }

    private function formatVideoSize($sizeInBytes)
    {
        $formats = ['bytes', 'KB', 'MB', 'GB', 'TB']; // Define the size formats
        $formatIndex = 0; // Initialize the format index

        while ($sizeInBytes >= 1024 && $formatIndex < count($formats) - 1) {
            $sizeInBytes /= 1024; // Divide by 1024 to move to the next format
            $formatIndex++;
        }

        $formattedSize = round($sizeInBytes, 2); // Round to 2 decimal places

        return $formattedSize . ' ' . $formats[$formatIndex];
    }



    public function play($videoName)
    {
        $videoUrl = Storage::disk('videos')->url($videoName);
        return view('admin.screen_recorder.play', compact('videoUrl'));
    }


    public function edit($id)
    {
        $screenRecorder = ScreenRecorder::find($id);

        if (!$screenRecorder) {
            return redirect()->route('admin.screen-recorder.index')->with('error', 'Screen Recorder not found');
        }

        return view('admin.screen_recorder.edit', compact('screenRecorder'));
    }


    public function update(Request $request, $id)
    {
        $screenRecorder = ScreenRecorder::find($id);

        if (!$screenRecorder) {
            return redirect()->route('admin.screen-recorder.index')->with('error', 'Screen Recorder not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $screenRecorder->name = $request->input('name');
        $screenRecorder->meta_keywords = $request->input('meta_keywords');
        $screenRecorder->meta_description = $request->input('meta_description');
        $screenRecorder->save();

        return redirect()->route('admin.screen-recorder.index')->with('success', 'Screen Recorder updated successfully');
    }

    public function delete(Request $request)
    {
        $videoID = $request->videoid;
        $video = ScreenRecorder::findOrFail($videoID);
        @unlink('assets/videos/' . $video->name);

        $video->delete();
        Session::flash('success', 'Video deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $page = ScreenRecorder::findOrFail($id);
            @unlink('assets/videos/' . $page->name);
            $page->delete();
        }

        Session::flash('success', 'Videos deleted successfully!');
        return "success";
    }
}
