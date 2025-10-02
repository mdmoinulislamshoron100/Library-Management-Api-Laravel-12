<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::with('activeBorrowings');

        if($request->has('search')){
            $search = trim($request->search);
            $query->where(function($q) use ($search){
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if($request->has('status')){
            $status = trim($request->status);
            $query->where('status', $status);
        }

        $members = $query->paginate(10);
        return $this->successPaginated('Members fetched successfully', MemberResource::collection($members));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $member = Member::create($request->validated());
        return $this->success('Member created successfully', new MemberResource($member), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['activeBorrowings', 'borrowings']);
        return $this->success('Member fetched successfully', new MemberResource($member));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        $member->load(['activeBorrowings', 'borrowings']);
        return $this->success('Member updated successfully', new MemberResource($member));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {

        if($member->activeBorrowings()->count() > 0){
            return $this->error("You can't Member deleted. Because This member borrowing books.");
        }

        $member->delete();
        return $this->success('Member deleted successfully');
    }
}
