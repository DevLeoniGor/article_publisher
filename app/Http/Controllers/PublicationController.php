<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicationStoreRequest;
use App\Http\Services\PublicationServices;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{
    private PublicationServices $publicationServices;

    public function __construct(PublicationServices $publicationServices)
    {
        $this->publicationServices = $publicationServices;
    }

    public function index()
    {
        return $this->publicationServices->getAll(request('is_active'));
    }

    public function store(PublicationStoreRequest $request)
    {
        return $this->publicationServices->store($request);
    }

    public function show(int $id)
    {
        return $this->publicationServices->getOne($id, request('is_active'));
    }

    public function update(PublicationStoreRequest $request, int $id)
    {
        return $this->publicationServices->update($request, $id);
    }

    public function destroy(int $id)
    {
        $publication = $this->publicationServices->destroy($id);
        $publicationName = data_get($publication, 'title');
        return response()->json(['message' => 'Publication "' . $publicationName . '" deleted.']);
    }

    public function active(int $id)
    {
        $user = Auth::user();
        $subscription_id = data_get($user, 'subscription_id');

        if(empty($subscription_id)) {
            return response()->json(['error' => 'User "' . data_get($user, 'name') . '" has no subscription.'], 404);
        }

        $subscription = Subscription::query()->findOrFail($subscription_id);
        $subscriptionAvailable = data_get($subscription, 'available');
        $countActivePublication = $this->publicationServices->countActivePublication($subscription_id);

        if($countActivePublication < $subscriptionAvailable) {
            return $this->publicationServices->active($id, $subscription_id);
        } else {
            return response()->json(['error' => 'The maximum number of publications in a subscription has been reached.'], 404);
        }
    }
}
