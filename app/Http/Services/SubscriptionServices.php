<?php

namespace App\Http\Services;

use App\Http\Requests\SubscriptionStoreRequest;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SubscriptionServices
{
    public function getAll(): Collection|array
    {
        return Subscription::query()->get();
    }

    public function getOne(int $id): Model|Builder|null
    {
        return Subscription::query()->findOrFail($id);
    }

    public function store(SubscriptionStoreRequest $request)
    {
        return Subscription::query()->create([
            'title' => $request->title,
            'cost' => $request->cost,
            'available' => $request->available,
        ]);
    }

    public function update(SubscriptionStoreRequest $request, int $id): Model|Collection|Builder|array|null
    {
        $subscription = Subscription::query()->findOrFail($id);

        $subscription->update([
            'title' => $request->title,
            'cost' => $request->cost,
            'available' => $request->available,
        ]);

        return $subscription;
    }

    public function destroy(int $id): Model|Collection|Builder|array|null
    {
        $subscription = Subscription::query()->findOrFail($id);
        $subscriptionData = $subscription;
        $subscription->delete();

        return $subscriptionData;
    }

    public function active(int $id): Model|Collection|Builder|array|null
    {
        $subscription = Subscription::query()->findOrFail($id);

        $subscription->update([
            'active' => 1,
        ]);

        return $subscription;
    }

    public function buy(int $id): void
    {
        $subscription = Subscription::query()->findOrFail($id);
        $user = Auth::user();
        $user->update([
            'subscription_id' => $subscription->id
        ]);
    }
}
