export interface AgeResult {
  years: number;
  months: number;
  days: number;
  totalDays: number;
  totalWeeks: number;
  totalHours: number;
  totalSeconds: number;
  direction: 'past' | 'future' | 'same';
  humanReadable: string;
}

export interface AppState {
  targetDate: string | null;
  fromDate: string | null;
  result: AgeResult | null;
}
