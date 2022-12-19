<?php

namespace Vng\DennisCore\Listeners;

use Illuminate\Support\Facades\Bus;
use Vng\DennisCore\Events\ContactAttachedEvent;
use Vng\DennisCore\Events\ContactDetachedEvent;
use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Events\ElasticResourceRemoved;
use Vng\DennisCore\Events\ElasticResourceSaved;
use Vng\DennisCore\Events\InstrumentAttachedEvent;
use Vng\DennisCore\Events\InstrumentDetachedEvent;
use Vng\DennisCore\Events\ProviderAttachedEvent;
use Vng\DennisCore\Events\ProviderDetachedEvent;
use Vng\DennisCore\Jobs\PruneSyncAttempts;
use Vng\DennisCore\Jobs\RemoveResourceFromElasticJob;
use Vng\DennisCore\Jobs\SyncSearchableModelToElasticJob;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Provider;
use Vng\DennisCore\Models\Region;
use Exception;
use Illuminate\Events\Dispatcher;
use Vng\DennisCore\Services\ElasticSearch\SyncService;

class ElasticResourceEventSubscriber
{
    public function handleRelatedResourceChanged(ElasticRelatedResourceChanged $event)
    {
        $relatedModel = $event->model;
        $attempt = SyncService::createSyncAttempt($relatedModel, 'save', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $event->relatedModel);

        $jobs = [
            new SyncSearchableModelToElasticJob($relatedModel, $attempt),
            new PruneSyncAttempts()
        ];

        Bus::chain($jobs)->dispatch();
    }

    public function handleInstrumentAttached(InstrumentAttachedEvent $event)
    {
        $instrument_id = $event->pivot->instrument_id;
        /** @var Instrument $instrument */
        $instrument = Instrument::withTrashed()->find($instrument_id);

        if (is_null($instrument)) {
            throw new Exception('No instrument found with id [' . $instrument_id . ']');
        }

        $attempt = SyncService::createSyncAttempt($instrument, 'attach', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $event->pivot);

        Bus::chain([
            new SyncSearchableModelToElasticJob($instrument, $attempt),
            new PruneSyncAttempts()
        ])->dispatch();
    }

    public function handleInstrumentDetached(InstrumentDetachedEvent $event)
    {
        $instrument_id = $event->pivot->instrument_id;
        /** @var Instrument $instrument */
        $instrument = Instrument::withTrashed()->find($instrument_id);

        if (is_null($instrument)) {
            throw new Exception('No instrument found with id [' . $instrument_id . ']');
        }

        $attempt = SyncService::createSyncAttempt($instrument, 'detach', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $event->pivot);

        Bus::chain([
            new SyncSearchableModelToElasticJob($instrument, $attempt),
            new PruneSyncAttempts()
        ])->dispatch();
    }

    public function handleProviderAttached(ProviderAttachedEvent $event)
    {
        /** @var Provider $provider */
        $provider = Provider::withTrashed()->find($event->pivot->provider_id);

        $attempt = SyncService::createSyncAttempt($provider, 'attach', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $event->pivot);

        Bus::chain([
            new SyncSearchableModelToElasticJob($provider, $attempt),
            new PruneSyncAttempts()
        ])->dispatch();
    }

    public function handleProviderDetached(ProviderDetachedEvent $event)
    {
        /** @var Provider $provider */
        $provider = Provider::withTrashed()->find($event->pivot->provider_id);

        $attempt = SyncService::createSyncAttempt($provider, 'detach', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $event->pivot);

        Bus::chain([
            new SyncSearchableModelToElasticJob($provider, $attempt),
            new PruneSyncAttempts()
        ])->dispatch();
    }

    public function handleContactAttached(ContactAttachedEvent $event)
    {
        $contact = $event->contact;

        /** @var Instrument|Provider|Region $attached */
        $attached = $event->contactable;

        $attempt = SyncService::createSyncAttempt($attached, 'attach', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $contact);

        $jobs = [
            new SyncSearchableModelToElasticJob($attached, $attempt),
            new PruneSyncAttempts()
        ];

        Bus::chain($jobs)->dispatch();
    }

    public function handleContactDetached(ContactDetachedEvent $event)
    {
        $contact = $event->contact;

        /** @var Instrument|Provider|Region $detached */
        $detached = $event->contactable;

        $attempt = SyncService::createSyncAttempt($detached, 'detach', 'created');
        $attempt = SyncService::addRelatedModel($attempt, $contact);

        $jobs = [
            new SyncSearchableModelToElasticJob($detached, $attempt),
            new PruneSyncAttempts()
        ];

        Bus::chain($jobs)->dispatch();
    }

    public function handleResourceRemoved(ElasticResourceRemoved $event)
    {
        $searchableModel = $event->model;
        $attempt = SyncService::createSyncAttempt($searchableModel, 'remove', 'created');

        $jobs = [
            new RemoveResourceFromElasticJob($searchableModel->getSearchIndex(), $searchableModel->getSearchId(), $attempt),
            new PruneSyncAttempts()
        ];

        Bus::chain($jobs)->dispatch();
    }

    public function handleResourceSaved(ElasticResourceSaved $event)
    {
        $searchableModel = $event->model;
        $attempt = SyncService::createSyncAttempt($searchableModel, 'save', 'created');

        $jobs = [
            new SyncSearchableModelToElasticJob($searchableModel, $attempt),
            new PruneSyncAttempts()
        ];

        Bus::chain($jobs)->dispatch();
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            ElasticRelatedResourceChanged::class,
            [ElasticResourceEventSubscriber::class, 'handleRelatedResourceChanged']
        );

        $events->listen(
            ElasticResourceSaved::class,
            [ElasticResourceEventSubscriber::class, 'handleResourceSaved']
        );

        $events->listen(
            ElasticResourceRemoved::class,
            [ElasticResourceEventSubscriber::class, 'handleResourceRemoved']
        );

        $events->listen(
            InstrumentAttachedEvent::class,
            [ElasticResourceEventSubscriber::class, 'handleInstrumentAttached']
        );

        $events->listen(
            InstrumentDetachedEvent::class,
            [ElasticResourceEventSubscriber::class, 'handleInstrumentDetached']
        );

        $events->listen(
            ProviderAttachedEvent::class,
            [ElasticResourceEventSubscriber::class, 'handleProviderAttached']
        );

        $events->listen(
            ProviderDetachedEvent::class,
            [ElasticResourceEventSubscriber::class, 'handleProviderDetached']
        );

        $events->listen(
            ContactAttachedEvent::class,
            [ElasticResourceEventSubscriber::class, 'handleContactAttached']
        );

        $events->listen(
            ContactDetachedEvent::class,
            [ElasticResourceEventSubscriber::class, 'handleContactDetached']
        );
    }
}
