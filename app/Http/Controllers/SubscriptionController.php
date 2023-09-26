<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUsrToSubscriptionRequest;
use App\Http\Requests\SubscriptionStoreRequest;
use App\Http\Services\SubscriptionServices;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    private SubscriptionServices $subscriptionServices;

    public function __construct(SubscriptionServices $subscriptionServices)
    {
        $this->subscriptionServices = $subscriptionServices;
    }

    public function index()
    {
        return $this->subscriptionServices->getAll();
    }

    public function store(SubscriptionStoreRequest $request)
    {
        return $this->subscriptionServices->store($request);
    }

    public function show(int $id)
    {
        return $this->subscriptionServices->getOne($id);
    }

    public function update(SubscriptionStoreRequest $request, int $id)
    {
        return $this->subscriptionServices->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->subscriptionServices->destroy($id);
        return response()->json(['message' => 'Subscription deleted.']);
    }

    public function active(int $id)
    {
        return $this->subscriptionServices->active($id);
    }

    public function buy(int $id)
    {
        $user = Auth::user();
        $this->subscriptionServices->buy($id);
        return response()->json(['message' => 'Subscription purchased by user "' . $user->name . '".']);
    }
}
