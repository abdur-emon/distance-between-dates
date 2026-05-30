import './bootstrap';
import { calculateAge, isValidDateString } from '@/utils/ageCalculator';
import { getInitialState, saveState, clearState } from '@/utils/state';
import type { AppState, AgeResult } from '@/types';

declare global {
  interface Window {
    __INITIAL_STATE__?: AppState;
  }
}

class AgeCalculatorApp {
  private state: AppState;

  // DOM Elements
  private form: HTMLFormElement;
  private targetDateInput: HTMLInputElement;
  private fromDateInput: HTMLInputElement;
  private useFromDateCheckbox: HTMLInputElement;
  private fromDateContainer: HTMLElement;
  private resultContainer: HTMLElement;
  private errorContainer: HTMLElement | null;
  private errorMessage: HTMLElement | null;

  // Auth only elements
  private resetButton: HTMLButtonElement | null;
  private copyButton: HTMLButtonElement | null;
  private shareButton: HTMLButtonElement | null;

  constructor() {
    this.state = window.__INITIAL_STATE__ || getInitialState();

    this.form = document.getElementById('date-form') as HTMLFormElement;
    this.targetDateInput = document.getElementById('target-date') as HTMLInputElement;
    this.fromDateInput = document.getElementById('from-date') as HTMLInputElement;
    this.useFromDateCheckbox = document.getElementById('use-from-date') as HTMLInputElement;
    this.fromDateContainer = document.getElementById('from-date-container') as HTMLElement;
    this.resultContainer = document.getElementById('result-container') as HTMLElement;

    this.resetButton = document.getElementById('reset-button') as HTMLButtonElement | null;
    this.copyButton = document.getElementById('copy-button') as HTMLButtonElement | null;
    this.shareButton = document.getElementById('share-button') as HTMLButtonElement | null;
    this.errorContainer = document.getElementById('error-container');
    this.errorMessage = document.getElementById('error-message');

    this.init();
  }

  private init(): void {
    // app.ts is loaded on every page (incl. the landing page), but the
    // calculator form only exists on the /app view. Bail out cleanly when
    // it's absent so we don't throw on pages without the form.
    if (!this.form) {
      return;
    }

    this.setupEventListeners();
  }

  private setupEventListeners(): void {
    this.form.addEventListener('submit', (e) => {
      e.preventDefault();
      this.handleCalculate();
    });

    this.useFromDateCheckbox.addEventListener('change', () => {
      this.toggleFromDate();
    });

    document.addEventListener('keydown', (e) => {
      if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        this.targetDateInput.focus();
      }
    });

    // Automatic calculations removed as per request.
    // Calculations only trigger on form submit (Process button).

    if (this.resetButton) {
      this.resetButton.addEventListener('click', () => this.handleReset());
    }

    if (this.copyButton) {
      this.copyButton.addEventListener('click', () => this.handleCopy());
    }

    if (this.shareButton) {
      this.shareButton.addEventListener('click', () => this.handleShare());
    }
  }

  private handleCalculate(): void {
    const targetDate = this.targetDateInput.value;
    const fromDate = this.useFromDateCheckbox.checked && this.fromDateInput.value
      ? this.fromDateInput.value
      : null;

    if (!targetDate || !isValidDateString(targetDate)) {
      this.showError('Target date is required and must be a valid temporal coordinate.');
      return;
    }

    if (fromDate && !isValidDateString(fromDate)) {
      this.showError('Custom origin date is invalid or out of temporal bounds.');
      return;
    }

    try {
      this.hideError();
      const result = calculateAge(targetDate, fromDate || undefined);

      this.state.targetDate = targetDate;
      this.state.fromDate = fromDate;
      this.state.result = result;

      saveState({
        targetDate,
        fromDate,
      });

      this.updateUI(result);
    } catch (err) {
      console.error('Calculation Error:', err);
      this.showError('CRITICAL_TEMPORAL_ERROR: Coordinates are out of bounds or mathematically impossible.');
    }
  }

  private showError(message: string): void {
    if (this.errorContainer && this.errorMessage) {
      this.errorMessage.textContent = message;
      this.errorContainer.classList.remove('hidden');
      this.resultContainer.classList.add('hidden');
    }
  }

  private hideError(): void {
    if (this.errorContainer) {
      this.errorContainer.classList.add('hidden');
    }
  }

  private updateUI(result: AgeResult): void {
    this.resultContainer.classList.remove('hidden');

    const humanReadable = document.getElementById('human-readable');
    if (humanReadable) humanReadable.textContent = result.humanReadable;

    const directionText = document.getElementById('direction-text');
    if (directionText) {
      if (result.direction === 'past') {
        directionText.textContent = 'In the past';
      } else if (result.direction === 'future') {
        directionText.textContent = 'In the future';
      } else {
        directionText.textContent = 'Right now';
      }
    }

    this.updateElement('years', result.years.toString());
    this.updateElement('months', result.months.toString());
    this.updateElement('days', result.days.toString());

    this.updateElement('total-days', result.totalDays.toLocaleString());
    this.updateElement('total-weeks', result.totalWeeks.toLocaleString());
    this.updateElement('total-hours', result.totalHours.toLocaleString());
    this.updateElement('total-seconds', result.totalSeconds.toLocaleString());
  }

  private updateElement(id: string, value: string): void {
    const element = document.getElementById(id);
    if (element) {
      element.textContent = value;
    }
  }

  private toggleFromDate(): void {
    if (this.useFromDateCheckbox.checked) {
      this.fromDateContainer.classList.remove('hidden');
    } else {
      this.fromDateContainer.classList.add('hidden');
      this.fromDateInput.value = '';
      this.state.fromDate = null;
      saveState({ fromDate: null });
    }
  }

  private handleReset(): void {
    clearState();

    // Clear inputs
    this.targetDateInput.value = '';
    this.fromDateInput.value = '';
    this.useFromDateCheckbox.checked = false;
    this.fromDateContainer.classList.add('hidden');
    this.hideError();

    // Reset state
    this.state = getInitialState();

    // Hide results
    this.resultContainer.classList.add('hidden');

    // Remove query params from URL without reload
    window.history.pushState({}, '', window.location.pathname);
  }

  private async handleCopy(): Promise<void> {
    if (!this.state.result) return;

    const textToCopy = `${this.state.result.humanReadable}\n\n` +
      `Breakdown:\n` +
      `- ${this.state.result.years} Years\n` +
      `- ${this.state.result.months} Months\n` +
      `- ${this.state.result.days} Days\n\n` +
      `Totals:\n` +
      `- ${this.state.result.totalDays.toLocaleString()} Days\n` +
      `- ${this.state.result.totalWeeks.toLocaleString()} Weeks\n` +
      `- ${this.state.result.totalHours.toLocaleString()} Hours`;

    try {
      await navigator.clipboard.writeText(textToCopy);
      const copyText = document.getElementById('copy-text');
      if (copyText) {
        const originalText = copyText.textContent;
        copyText.textContent = 'Copied!';
        setTimeout(() => {
          copyText.textContent = originalText;
        }, 2000);
      }
    } catch (err) {
      console.error('Failed to copy text: ', err);
    }
  }

  private async handleShare(): Promise<void> {
    const url = window.location.href;
    const title = 'Age Calculator Result';
    let text = 'Check out this date calculation!';
    if (this.state.result) {
      text = this.state.result.humanReadable;
    }

    const fallbackToClipboard = async () => {
      try {
        await navigator.clipboard.writeText(url);
        const shareText = document.getElementById('share-text');
        if (shareText) {
          const originalText = shareText.textContent;
          shareText.textContent = 'Link Copied!';
          setTimeout(() => {
            shareText.textContent = originalText;
          }, 2000);
        }
      } catch (err) {
        console.error('Failed to copy link: ', err);
      }
    };

    if (navigator.share) {
      try {
        await navigator.share({
          title,
          text,
          url,
        });
      } catch (err) {
        // If user cancelled, don't fallback, just ignore
        if (err instanceof Error && err.name === 'AbortError') {
          return;
        }
        // For other errors, try fallback to clipboard
        await fallbackToClipboard();
      }
    } else {
      await fallbackToClipboard();
    }
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    new AgeCalculatorApp();
  });
} else {
  new AgeCalculatorApp();
}
