<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonInterval;

/**
 * DateDistanceService
 * 
 * Handles all date distance calculations with precision.
 * 
 * Why Carbon?
 * - Laravel's native date library
 * - Handles timezones, DST, leap years automatically
 * - Immutable by default (prevents bugs)
 * - Rich API for date manipulation
 */
class DateDistanceService
{
    /**
     * Calculate the distance between two dates
     * 
     * @param string $targetDate The target date (Y-m-d format)
     * @param string|null $fromDate The from date (defaults to today)
     * @return array{
     *   years: int,
     *   months: int,
     *   days: int,
     *   totalDays: int,
     *   totalWeeks: float,
     *   totalHours: int,
     *   totalSeconds: int,
     *   direction: string,
     *   humanReadable: string
     * }
     */
    public function calculate(string $targetDate, ?string $fromDate = null): array
    {
        // Parse dates using Carbon (immutable to prevent side effects)
        $target = Carbon::parse($targetDate)->startOfDay();
        $from = $fromDate ? Carbon::parse($fromDate)->startOfDay() : Carbon::today();

        // Determine direction
        $direction = $this->getDirection($from, $target);

        // Calculate the interval
        $interval = $from->diff($target);

        // Calculate totals
        $totalDays = abs($from->diffInDays($target));
        $totalWeeks = round($totalDays / 7, 2);
        $totalHours = abs($from->diffInHours($target));
        $totalSeconds = abs($from->diffInSeconds($target));

        // Extract years, months, days from interval
        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;

        return [
            'years' => $years,
            'months' => $months,
            'days' => $days,
            'totalDays' => $totalDays,
            'totalWeeks' => $totalWeeks,
            'totalHours' => $totalHours,
            'totalSeconds' => $totalSeconds,
            'direction' => $direction,
            'humanReadable' => $this->formatHumanReadable($years, $months, $days, $direction),
        ];
    }

    /**
     * Determine the direction of the date difference
     * 
     * @param Carbon $from
     * @param Carbon $target
     * @return string 'past', 'future', or 'same'
     */
    private function getDirection(Carbon $from, Carbon $target): string
    {
        if ($target->isSameDay($from)) {
            return 'same';
        }

        // Direction is relative to $from, NOT to "now" — using isPast() here
        // would misreport direction whenever $from is a custom date.
        return $target->isBefore($from) ? 'past' : 'future';
    }

    /**
     * Format a human-readable duration string
     * 
     * Examples:
     * - "2 years, 3 months, 10 days ago"
     * - "1 year, 5 months from now"
     * - "Today"
     * 
     * @param int $years
     * @param int $months
     * @param int $days
     * @param string $direction
     * @return string
     */
    private function formatHumanReadable(int $years, int $months, int $days, string $direction): string
    {
        if ($direction === 'same') {
            return 'Today';
        }

        $parts = [];

        if ($years > 0) {
            $parts[] = $years . ' ' . ($years === 1 ? 'year' : 'years');
        }

        if ($months > 0) {
            $parts[] = $months . ' ' . ($months === 1 ? 'month' : 'months');
        }

        if ($days > 0) {
            $parts[] = $days . ' ' . ($days === 1 ? 'day' : 'days');
        }

        // If no parts, it means same day (edge case)
        if (empty($parts)) {
            return 'Today';
        }

        $suffix = $direction === 'past' ? ' ago' : ' from now';

        return implode(', ', $parts) . $suffix;
    }

    /**
     * Validate a date string
     * 
     * @param string $date
     * @return bool
     */
    public function isValidDate(string $date): bool
    {
        try {
            Carbon::parse($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

