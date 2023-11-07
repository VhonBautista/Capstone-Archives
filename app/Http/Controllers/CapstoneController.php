<?php

namespace App\Http\Controllers;

use App\Models\Capstone;
use App\Models\CapstoneRequest;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Log;
use App\Models\User;
use App\Notifications\NewNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CapstoneController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $type = $request->type;

        $capstones = Capstone::where('status', 'active');

        if ($search) {
            $capstones->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('authors', 'like', "%{$search}%")
                    ->orWhere('year_published', 'like', "%{$search}%");
            });
        }

        if ($type) {
            $capstones->where('type', $type);
        }

        $capstones = $capstones->paginate(10);

        return view('admin.capstone', [
            'user' => $request->user(),
            'capstones' => $capstones,
        ]);
    }

    public function view($id, Request $request)
    {
        $capstone = Capstone::with('images')
            ->findOrFail($id);
        $count = $capstone->view_count;
        $count += 1;
        $capstone->update(['view_count' => $count]);
            
        $authorString = $capstone->authors;

        $authors = explode(", ", $authorString);

        $formattedAuthors = [];

        foreach ($authors as $author) {
            $parts = explode(" ", $author);
            $lastName = array_pop($parts);
            $initials = array_map(function($part) {
                return strtoupper($part[0]);
            }, $parts);

            $formattedAuthors[] = $lastName . ', ' . implode('. ', $initials) . '.';
        }

        $year = Carbon::parse($capstone->year_published)->format('(Y)');
        $formattedString = implode(', ', $formattedAuthors);

        $citation = $formattedString . ' ' . $year . '. ' . $capstone->title . '. Pangasinan State University - Urdaneta Campus. ' . route('capstone.view', $capstone->id) ;

        $existingFavorite = Favorite::where('user_id', $request->user()->id)
            ->where('capstone_id', $request->id)
            ->first();
        
        return view('view', [
            'user' => $request->user(),
            'capstone' => $capstone,
            'citation' => $citation,
            'favorite' => $existingFavorite,
        ]);
    }

    public function preview($id, Request $request)
    {
        $capstone = Capstone::with('images')
            ->findOrFail($id);
        
        return view('admin.view', [
            'user' => $request->user(),
            'capstone' => $capstone,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:web,mobile,desktop,game,pos,others',
            'authors' => 'required|string',
            'panels' => 'required|string',
            'adviser' => 'required|string|max:255',
            'pdf' => 'mimes:pdf|max:10240',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);
    
        $pdfName = null;
        if ($request->hasFile('pdf')) {
            $pdf = $request->pdf;

            $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();
            $pdfName = $originalName . '_' . time() . '.' . $extension; 
            $pdf->move(public_path('pdfs'), $pdfName);
        }

        $capstone = Capstone::create([
            'status' => 'active',
            'title' => $request->title,
            'description' => $request->description,
            'authors' => $request->authors,
            'panels' => $request->panels,
            'adviser' => $request->adviser,
            'year_published' => $request->date,
            'pdf_name' => $pdfName,
            'type' => $request->type,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->images;
            foreach ($images as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $imageName = $originalName . '_' . time() . '.' . $extension;

                $image->move(public_path('images'), $imageName);

                Image::create([
                    'capstone_id' => $capstone->id,
                    'img_path' => 'images/' . $imageName,
                ]);
            }
        }
        
        // Notification
        if (auth()->user()->id !== 1) {
            $superAdmin = User::findOrFail(1);
            $title = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $type = 'Capstone Added';
            $message = ' has added a new capstone project titled "' . $capstone->title . '" to the collections.';
            $url = '/capstone/view/' . $capstone->id;
            $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            
            Notification::send($superAdmin, new NewNotification($title, $type, $message, $url, $color));
        }

        // Log
        $user_id = auth()->user()->id;
        $actions = 'created';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has added a new capstone project titled "' . $capstone->title . '" to the collections.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);
        
        return redirect()->back()->with(
            'message', 'Capstone was added successfully.',
        );
    }

    public function capstoneRequest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:web,mobile,desktop,game,pos,others',
            'authors' => 'required|string',
            'panels' => 'required|string',
            'adviser' => 'required|string|max:255',
            'pdf' => 'mimes:pdf|max:10240',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);
    
        $pdfName = null;
        if ($request->hasFile('pdf')) {
            $pdf = $request->pdf;

            $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();
            $pdfName = $originalName . '_' . time() . '.' . $extension; 
            $pdf->move(public_path('pdfs'), $pdfName);
        }

        $capstone = Capstone::create([
            'status' => 'inactive',
            'title' => $request->title,
            'description' => $request->description,
            'authors' => $request->authors,
            'panels' => $request->panels,
            'adviser' => $request->adviser,
            'year_published' => $request->date,
            'pdf_name' => $pdfName,
            'type' => $request->type,
        ]);

        $capstoneRequest = CapstoneRequest::create([
            'user_id' => auth()->user()->id,
            'capstone_id' => $capstone->id,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->images;
            foreach ($images as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $imageName = $originalName . '_' . time() . '.' . $extension;

                $image->move(public_path('images'), $imageName);

                Image::create([
                    'capstone_id' => $capstone->id,
                    'img_path' => 'images/' . $imageName,
                ]);
            }
        }
        
        // Notification
        $admins = User::where('is_admin', true)
            ->whereHas('role', function($query) {
                $query->where('manage_approval', true);
            })
            ->get();
            
        $title = 'Approval Request';
        $type = 'Approval Request';
        $message = ' for a capstone project titled "' . $capstone->title . '".';
        $url = '/approval/preview/' . $capstone->id;
        $color = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
        
        Notification::send($admins, new NewNotification($title, $type, $message, $url, $color));

        return redirect()->route('home')->with(
            'message', 'Capstone approval request was successfully sent.',
        );
    }

    public function edit($id, Request $request)
    {
        $capstone = Capstone::with('images')
            ->findOrFail($id);
        
        return view('admin.edit', [
            'user' => $request->user(),
            'capstone' => $capstone,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'capstone_id' => 'required',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:web,mobile,desktop,game,pos,others',
            'authors' => 'required|string',
            'panels' => 'required|string',
            'adviser' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $capstone = Capstone::findOrFail($request->capstone_id);

        $capstone->update([
            'title' => $request->title,
            'description' => $request->description,
            'authors' => $request->authors,
            'panels' => $request->panels,
            'adviser' => $request->adviser,
            'year_published' => $request->date,
            'type' => $request->type,
        ]);

        // Notification
        if (auth()->user()->id !== 1) {
            $superAdmin = User::findOrFail(1);
            $title = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $type = 'Capstone Updated';
            $message = ' has updated the capstone project titled "' . $capstone->title . '" from the collections.';
            $url = '/capstone/view/' . $capstone->id;
            $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            
            Notification::send($superAdmin, new NewNotification($title, $type, $message, $url, $color));
        }

        // Log
        $user_id = auth()->user()->id;
        $actions = 'updated';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has updated the capstone project titled "' . $capstone->title . '" from the collections.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);
        
        $message = $capstone->title . ' was updated successfully.';

        return redirect()->route('capstone.edit', $capstone->id)->with(
            'message', $message,
        );
    }

    public function downloadPDF($fileName)
    {
        $filePath = public_path('pdfs/' . $fileName);
        
        return response()->download($filePath);
    }

    public function updatePDF(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240',
        ]);

        $capstone = Capstone::find($request->id);

        if ($request->hasFile('pdf')) {
            $pdf = $request->pdf;

            $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();
            $pdfName = $originalName . '_' . time() . '.' . $extension; 
            $pdf->move(public_path('pdfs'), $pdfName);

            if ($capstone->pdf_name) {
                $oldPdfPath = public_path('pdfs/' . $capstone->pdf_name);
                if (file_exists($oldPdfPath)) {
                    unlink($oldPdfPath);
                }
            }

            $capstone->pdf_name = $pdfName;
        }

        $capstone->save();

        // Notification
        if (auth()->user()->id !== 1) {
            $superAdmin = User::findOrFail(1);
            $title = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $type = 'Capstone PDF Updated';
            $message = ' has updated the pdf file of capstone project titled "' . $capstone->title . '".';
            $url = '/capstone/view/' . $capstone->id;
            $color = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            
            Notification::send($superAdmin, new NewNotification($title, $type, $message, $url, $color));
        }

        // Log
        $user_id = auth()->user()->id;
        $actions = 'updated';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has updated the pdf file of capstone project titled "' . $capstone->title . '".';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        return redirect()->back()->with(
            'message', 'PDF file for this capstone was updated successfully.',
        );
    }

    public function updateImage(Request $request)
    {
        $capstone = Capstone::with('images')
            ->findOrFail($request->id);

        $images = $capstone->images;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $newImage) {
                $originalName = pathinfo($newImage->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $newImage->getClientOriginalExtension();
                $imageName = $originalName . '_' . time() . '.' . $extension; 
                $newImage->move(public_path('images'), $imageName);
    
                $capstone->images()->create([
                    'img_path' => 'images/' . $imageName,
                ]);
            }
        }
    
        foreach ($images as $image) {
            if ($image->img_path) {
                $oldImagePath = public_path($image->img_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $image->delete();
            }
        }

        // Notification
        if (auth()->user()->id !== 1) {
            $superAdmin = User::findOrFail(1);
            $title = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $type = 'Capstone Images Updated';
            $message = ' has updated the images of capstone project titled "' . $capstone->title . '".';
            $url = '/capstone/view/' . $capstone->id;
            $color = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            
            Notification::send($superAdmin, new NewNotification($title, $type, $message, $url, $color));
        }

        // Log
        $user_id = auth()->user()->id;
        $actions = 'updated';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has updated the images of capstone project titled "' . $capstone->title . '".';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        return redirect()->back()->with(
            'message', 'Images for this capstone was updated successfully.',
        );
    }

    public function destroy($id)
    {
        $capstone = Capstone::with('images')
            ->findOrFail($id);
        
        if (auth()->user()->id !== 1) {
            // Notification
            $superAdmin = User::findOrFail(1);
            $title = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $type = 'Deleted';
            $message = ' has deleted the capstone project titled "' . $capstone->title . '" from the collections.';
            $url = '/capstone';
            $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    
            Notification::send($superAdmin, new NewNotification($title, $type, $message, $url, $color));
        }

        // Log
        $user_id = auth()->user()->id;
        $actions = 'deleted';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has deleted the capstone project titled "' . $capstone->title . '" from the collections.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);
        
        foreach($capstone->images as $image) {
            $image->delete();
        }
        
        $users = $capstone->favoritedBy;

        $title = $capstone->title;
        $type = 'Capstone Deleted';
        $message = ' has been deleted from the collections and removed from your favorites list.';
        $url = '/favorites';
        $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';

        Notification::send($users, new NewNotification($title, $type, $message, $url, $color));

        $capstone->favoritedBy()->detach();

        $capstone->delete();
        
        $message = $capstone->title . ' has been deleted from the collections successfully.';
        
        return redirect()->route('admin.capstone')->with(
            'message', $message,
        );
    }
}
