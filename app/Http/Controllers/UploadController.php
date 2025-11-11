<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        Upload::create([
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'File berhasil diupload.');
    }

    public function destroy(Upload $upload)
    {
        if ($upload->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        \Storage::delete('public/ ' . $upload->file_path);
        $upload->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }

}