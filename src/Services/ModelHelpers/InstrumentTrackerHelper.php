<?php

namespace Vng\DennisCore\Services\ModelHelpers;

use Vng\DennisCore\Enums\FollowerRoleEnum;
use Vng\DennisCore\Enums\NotificationFrequencyEnum;
use Vng\DennisCore\Interfaces\IsInstrumentWatcherInterface;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\InstrumentTracker;

class InstrumentTrackerHelper
{
    public static function createQuickTrackerForCreator(
        Instrument $instrument,
        IsInstrumentWatcherInterface $instrumentWatcher
    ){
        static::trackInstrument(
            $instrument,
            $instrumentWatcher,
            FollowerRoleEnum::creator(),
            false
        );
    }

    public static function createQuickTrackerForAuthor(
        Instrument $instrument,
        IsInstrumentWatcherInterface $instrumentWatcher
    ){
        static::trackInstrument(
            $instrument,
            $instrumentWatcher,
            FollowerRoleEnum::author(),
        );
    }

    public static function createQuickTrackerForFollower(
        Instrument $instrument,
        IsInstrumentWatcherInterface $instrumentWatcher
    ){
        static::trackInstrument(
            $instrument,
            $instrumentWatcher,
            FollowerRoleEnum::follower(),
        );
    }

    public static function trackInstrument(
        Instrument $instrument,
        IsInstrumentWatcherInterface $instrumentWatcher,
        FollowerRoleEnum $role,
        bool $voluntary = true,
        ?NotificationFrequencyEnum $notificationFrequency = null,
        ?bool $onModification = null,
        ?bool $onExpiration = null
    ){
        $tracker = InstrumentTracker::query()->firstOrNew([
            'manager_id' => $instrumentWatcher->id,
            'instrument_id' => $instrument->id
        ]);

        if ($tracker->voluntary) {
            $tracker->voluntary = $voluntary;
        }

        $tracker->notification_frequency = $notificationFrequency ?? NotificationFrequencyEnum::monthly();

        if (!is_null($onModification)) {
            $tracker->on_modification = $onModification;
        }
        if (!is_null($onExpiration)) {
            $tracker->on_expiration = $onExpiration;
        }

        if (is_null($tracker->role) || FollowerRoleEnum::follower()->equals($tracker->role)) {
            // Only adjustable when not set or when a follower
            $tracker->role = $role;
        }

        $tracker->save();
    }
}
