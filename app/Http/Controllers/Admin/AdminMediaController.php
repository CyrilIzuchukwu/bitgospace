<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminMediaController extends Controller
{
    //

    public function addVideo()
    {
        return view('admin.media.add-video');
    }

    public function storeVideo(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'language' => 'required|string|max:50',
                'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:50000', // 50MB max
                'description' => 'nullable|string'
            ]);

            // ✅ Save the video using the 'public' disk
            $videoPath = $request->file('video')->store('videos', 'public'); // this saves to storage/app/public/videos
            $publicPath =  $videoPath; // this is the URL accessible via the browser

            // ✅ Create a unique reference ID
            $referenceId = 'VID-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(6));

            // ✅ Store in DB
            MediaVideo::create([
                'title' => $request->title,
                'language' => $request->language,
                'video_path' => $publicPath,
                'reference_id' => $referenceId,
                'description' => $request->description
            ]);

            return redirect()->route('admin.media.list')->with('success', 'Video uploaded successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = implode(' ', array_map(fn($errors) => implode(' ', $errors), $e->errors()));
            return redirect()->back()->with('error', $errorMessages);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function index()
    {
        $videos = MediaVideo::latest()->paginate(10);
        return view('admin.media.list', compact('videos'));
    }

    public function edit($reference, $language)
    {
        try {
            $video = MediaVideo::where('reference_id', $reference)
                ->where('language', $language)
                ->firstOrFail();

            return view('admin.media.edit', compact('video'));
        } catch (\Exception $e) {
            return redirect()->route('admin.media.list')->with('error', 'Video not found');
        }
    }


    public function updateVideo(Request $request, $reference, $language)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'language' => 'required|string|max:50',
                'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:50000',
                'description' => 'nullable|string'
            ]);

            $video = MediaVideo::where('reference_id', $reference)
                ->where('language', $language)
                ->firstOrFail();

            $updateData = [
                'title' => $request->title,
                'language' => $request->language,
                'description' => $request->description
            ];

            // Handle video update if new file is provided
            if ($request->hasFile('video')) {
                // Delete old video file
                Storage::disk('public')->delete($video->video_path);

                // Store new video
                $videoPath = $request->file('video')->store('videos', 'public');
                $updateData['video_path'] = $videoPath;
            }

            $video->update($updateData);

            return redirect()->route('admin.media.list')->with('success', 'Video updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($reference, $language)
    {
        try {
            $video = MediaVideo::where('reference_id', $reference)->where('language', $language)->firstOrFail();

            // Delete the video file from storage
            Storage::disk('public')->delete($video->video_path);

            // Delete the record from database
            $video->delete();

            return redirect()->route('admin.media.list')->with('success', 'Video deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.media.list')->with('error', 'Failed to delete video: ' . $e->getMessage());
        }
    }
}
