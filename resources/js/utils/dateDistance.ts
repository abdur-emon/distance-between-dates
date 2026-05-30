/**
 * Date Distance Utility
 * 
 * Client-side date calculations using date-fns v4
 * 
 * Why client-side calculations?
 * - Instant feedback (no server round-trip)
 * - Reduces server load
 * - Works offline
 * - Better UX
 * 
 * Why date-fns?
 * - Tree-shakeable (only import what we use)
 * - Immutable (prevents bugs)
 * - TypeScript native
 * - Handles edge cases (leap years, DST, etc.)
 */

import {
  differenceInYears,
  differenceInMonths,
  differenceInDays,
  differenceInHours,
  differenceInSeconds,
  startOfDay,
  parseISO,
  isBefore,
  isSameDay,
  isValid,
  addYears,
  addMonths
} from 'date-fns';
import type { DateDistanceResult } from '@/types';

/**
 * Calculate the distance between two dates
 */
export function calculateDateDistance(
  targetDateStr: string,
  fromDateStr?: string
): DateDistanceResult {
  try {
    // Parse dates
    const targetDate = startOfDay(parseISO(targetDateStr));
    const fromDate = fromDateStr
      ? startOfDay(parseISO(fromDateStr))
      : startOfDay(new Date());

    if (!isValid(targetDate) || !isValid(fromDate)) {
      throw new Error('INVALID_CHRONOLOGY');
    }

    // Determine direction
    const direction = getDirection(fromDate, targetDate);

    // Calculate components
    const isPast = direction === 'past';

    // Total components for accurate UI
    const totalYears = Math.abs(differenceInYears(targetDate, fromDate));

    // Safely move the date forward/backward by years
    const afterYears = addYears(fromDate, isPast ? -totalYears : totalYears);

    // Calculate remaining months
    const totalMonths = Math.abs(differenceInMonths(targetDate, afterYears));
    const afterMonths = addMonths(afterYears, isPast ? -totalMonths : totalMonths);

    // Calculate remaining days
    const remainingDays = Math.abs(differenceInDays(targetDate, afterMonths));

    // Calculate Absolute Totals
    const totalDays = Math.abs(differenceInDays(targetDate, fromDate));
    const totalWeeks = parseFloat((totalDays / 7).toFixed(2));
    const totalHours = Math.abs(differenceInHours(targetDate, fromDate));
    const totalSeconds = Math.abs(differenceInSeconds(targetDate, fromDate));

    return {
      years: totalYears,
      months: totalMonths,
      days: remainingDays,
      totalDays,
      totalWeeks,
      totalHours,
      totalSeconds,
      direction,
      humanReadable: formatHumanReadable(totalYears, totalMonths, remainingDays, direction),
    };
  } catch (err) {
    console.error('Temporal Calculation Failure:', err);
    throw err;
  }
}

/**
 * Determine the direction of the date difference
 */
function getDirection(from: Date, target: Date): 'past' | 'future' | 'same' {
  if (isSameDay(from, target)) {
    return 'same';
  }
  return isBefore(target, from) ? 'past' : 'future';
}

/**
 * Format a human-readable duration string
 * 
 * Examples:
 * - "2 years, 3 months, 10 days ago"
 * - "1 year, 5 months from now"
 * - "Today"
 */
function formatHumanReadable(
  years: number,
  months: number,
  days: number,
  direction: 'past' | 'future' | 'same'
): string {
  if (direction === 'same') {
    return 'Today';
  }

  const parts: string[] = [];

  if (years > 0) {
    parts.push(`${years} ${years === 1 ? 'year' : 'years'}`);
  }

  if (months > 0) {
    parts.push(`${months} ${months === 1 ? 'month' : 'months'}`);
  }

  if (days > 0) {
    parts.push(`${days} ${days === 1 ? 'day' : 'days'}`);
  }

  if (parts.length === 0) {
    return 'Today';
  }

  const suffix = direction === 'past' ? ' ago' : ' from now';

  return parts.join(', ') + suffix;
}

/**
 * Validate a date string
 */
export function isValidDateString(dateStr: string): boolean {
  try {
    const date = parseISO(dateStr);
    return isValid(date);
  } catch {
    return false;
  }
}

