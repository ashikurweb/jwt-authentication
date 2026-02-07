<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorPayout;
use App\Http\Resources\Api\Admin\PayoutResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PayoutController extends Controller
{
    /**
     * Display a listing of the payouts.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $payouts = InstructorPayout::query()
            ->with(['instructor', 'processedBy'])
            ->when($request->search, fn($q, $search) => $q->search($search))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return PayoutResource::collection($payouts);
    }

    /**
     * Display the specified payout.
     */
    public function show(InstructorPayout $payout): PayoutResource
    {
        return new PayoutResource($payout->load(['instructor', 'processedBy']));
    }

    /**
     * Update payout status (process payout).
     */
    public function update(Request $request, InstructorPayout $payout): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:processing,completed,failed,cancelled',
            'transaction_id' => 'required_if:status,completed|string|nullable',
            'notes' => 'nullable|string'
        ]);

        if ($request->status === 'completed') {
            $payout->process($request->transaction_id, $request->user());
        } else {
            $payout->update([
                'status' => $request->status,
                'notes' => $request->notes,
                'processed_by' => $request->user()->id,
                'processed_at' => now()
            ]);
        }

        return response()->json([
            'message' => 'Payout updated successfully',
            'payout' => new PayoutResource($payout)
        ]);
    }

    /**
     * Remove the specified payout (only if pending/failed/cancelled).
     */
    public function destroy(InstructorPayout $payout): JsonResponse
    {
        if ($payout->status === 'completed') {
            return response()->json([
                'message' => 'Cannot delete a completed payout'
            ], 422);
        }

        $payout->delete();

        return response()->json([
            'message' => 'Payout deleted successfully'
        ]);
    }
}
