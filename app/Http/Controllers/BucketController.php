<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use Illuminate\Http\Request;

class BucketController extends Controller
{
    public function getBuckets() {
        $buckets = Bucket::all();
        return view('action.list_buckets', compact('buckets'));
    }

    public function newBucket() {
        return view('action.new_bucket');
    }

    // Add a bucket
    public function addBucket(Request $request) {
        $bucket = new Bucket();
        $bucket->category = $request->category;
        $bucket->vendor = $request->vendor;
        $bucket->save();
        return redirect()->route('action.list_buckets')->with('success', 'Bucket added successfully!');
    }

    // Get a bucket by ID
    public function getBucketById($id) {
        $bucket = Bucket::find($id);
        return view('action/update_bucket', compact('bucket'));
    }

    // Update a bucket
    public function updateBucket(Request $request, $id) {
        $bucket = Bucket::find($id);
        $bucket->category = $request->category;
        $bucket->vendor = $request->vendor;
        $bucket->save();
        return redirect()->route('action.list_buckets')->with('success', 'Bucket updated successfully!');
    }

    // Delete a bucket
    public function deleteBucket($id) {
        $bucket = Bucket::find($id);
        if ($bucket) {
            $bucket->delete();
            return redirect()->route('action.list_buckets')->with('success', 'Bucket deleted successfully!');
        }
        return redirect()->route('action.list_buckets')->with('error', 'Bucket not found!');
    }
}
