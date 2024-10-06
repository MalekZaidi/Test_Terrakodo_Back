<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Advice;
use App\Models\User;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'advice_id' => 'required|exists:advices,id',
            'score' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:255',
        ]);

        // Find the advice
        $advice = Advice::findOrFail($request->advice_id);

        // Check if the user is trying to rate their own advice
        if (Auth::id() === $advice->user_id) {
            return redirect()->back()->with('error', 'You cannot rate your own advice.');
        }

        // Check if the user has already rated this advice
        $rating = Rating::where('advice_id', $request->advice_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($rating) {
            // Update the existing rating
            $rating->update([
                'score' => $request->score,
                'comment' => $request->comment, 
            ]);
            return redirect()->back()->with('success', 'Rating updated successfully!');
        }

        // Create a new rating if none exists
        Rating::create([
            'advice_id' => $request->advice_id,
            'score' => $request->score,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Rating submitted successfully!');
    }

    // Display all ratings for admin
    public function index()
    {
        $ratings = Rating::with('advice', 'user')->get(); // Load related advice and user data
        return view('backoffice.ratings.index', compact('ratings')); // Create a view for admin to list all ratings
    }

    public function edit($id)
{
    $rating = Rating::findOrFail($id);
    $advices = Advice::all(); // Fetch all advices, if necessary to show in the edit view
    return view('backoffice.ratings.edit', compact('rating', 'advices'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'score' => 'required|integer|between:1,5',
        'comment' => 'nullable|string|max:255',
    ]);

    $rating = Rating::findOrFail($id);
    $rating->score = $request->score;
    $rating->comment = $request->comment;
    $rating->save();

    return redirect()->route('admin.ratings.index')->with('success', 'Rating updated successfully!');
}

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return redirect()->route('admin.ratings.index')->with('success', 'Rating deleted successfully!');
    }
}
