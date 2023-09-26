<?php

namespace App\Http\Services;

use App\Http\Requests\PublicationStoreRequest;
use App\Models\Publication;
use App\Models\Scopes\UserScope;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PublicationServices
{
    public function getAll(int $active): Collection|array
    {
        return $this->builder(false)->where('active', $active)->get();
    }

    public function getOne(int $id, int $active): Model|Builder|null
    {
        return $this->builder(false)->where('active', $active)->findOrFail($id);
    }

    public function store(PublicationStoreRequest $request)
    {
        return $this->builder()->create([
            'title' => $request->title,
            'text' => $request->text
        ]);
    }

    public function update(PublicationStoreRequest $request, int $id): Model|Collection|Builder|array|null
    {
        $publication = $this->builder()->findOrFail($id);

        $publication->update([
            'title' => $request->title,
            'text' => $request->text
        ]);

        return $publication;
    }

    public function destroy(int $id)
    {
        $publication = $this->builder()->findOrFail($id);
        $publicationData = $publication;
        $publication->delete();

        return $publicationData;
    }

    public function active(int $id, int $subscription_id)
    {
        $publication = $this->getOne($id, 0);

        $publication->subscriptions()
            ->sync([$subscription_id]);

        $publication->update([
                'active' => 1,
            ]);

        return $publication;
    }

    public function countActivePublication(int $subscription_id): int
    {
        return $this->builder()->whereHas('subscriptions', function ($query) use ($subscription_id) {
            $query->where('subscriptions.id', $subscription_id);
        })->where('active', 1)->count();
    }

    private function builder(bool $viewOnlyCurrentUser = true): Builder
    {
        $publication = Publication::query();

        if(!$viewOnlyCurrentUser) {
            $publication->withoutGlobalScope(UserScope::class);
        }

        return $publication;
    }
}
