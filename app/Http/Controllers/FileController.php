<?php

namespace App\Http\Controllers;

use App\Jobs\SendFileDeleteEmail;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{

    /**
     * The file listing.
     */
    public function index() {
        $files = File::all();
        return view('files.index', compact('files'));
    }

    /**
     * File upload form.
     */
    public function show() {
        return view('files.upload');
    }

    /**
     * Save file.
     */
    public function store(Request $request) {
        // File validation.
        $validator = Validator::make($request->all(),[
            'file' => 'required|file|mimes:pdf,docx|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first('file'),
            ], 400);
        }

        $file = $request->file('file');
        $path = $file->store('uploads');

        $fileModel = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'expires_at' => now()->addDay(),
        ]);

        return response()->json([
            'message' => 'Файл успішно завантажено!',
            'file' => $fileModel,
        ]);
    }


    /**
     * Delete file.
     */
    public function destroy(File $file) {
        // Save file data for future operations.
        $data = [
            'file_name' => $file->name,
            'file_size' => $file->size,
        ];

        $deleted = $file->deleteFile();

        if ($deleted) {
            $data['deleted_at'] = now();
            // Try to send data to RabbitMQ.
            try {
                dispatch(new SendFileDeleteEmail($data))->onQueue('send_email');
            } catch (\Exception $e) {
                Log::error('Error dispatching file deletion job: ' . $e->getMessage());
            }

            return redirect()->route('files.index')->with('success', 'File was deleted.');
        }
        else {
            return redirect()->route('files.index')->with('success', 'File wasn\'t deleted.');
        }
    }

}
