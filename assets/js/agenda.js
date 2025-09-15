// Constants using more descriptive names
const DISPLAY_CLASSES = {
  SHOW: "d-block",
  HIDE: "d-none",
};

class EventFilter {
  constructor(eventSelector, filterSelector, resetSelector) {
    this.events = document.querySelectorAll(eventSelector);
    this.filters = document.querySelectorAll(filterSelector);
    this.resetSelector = resetSelector;
    this.init();
  }

  init() {
    // Use event delegation for better performance
    document.addEventListener("change", (event) => {
      const filter = event.target.closest(".jnd-filter");
      if (filter) {
        this.applyFilters();
      }
    });

    // Add click listener for reset button
    document.addEventListener("click", (event) => {
      if (event.target.matches(this.resetSelector)) {
        this.resetFilters();
      }
    });
  }

  /**
   * Checks if an element matches a filter's criteria
   * @param {HTMLElement} filter - The filter element
   * @param {HTMLElement} element - The element to check
   * @returns {boolean} - Whether the element matches the filter
   */
  checkFilter(filter, element) {
    const filterTarget = filter.getAttribute("jnd-filter-target");
    const elementValue = element.getAttribute(filterTarget);

    // Guard clause for invalid attributes
    if (!filterTarget || !elementValue) {
      console.warn("Missing filter target or element value", {
        filter,
        element,
      });
      return false;
    }

    return filter.value === "all" || elementValue.includes(filter.value);
  }

  /**
   * Updates element visibility based on filter state
   * @param {HTMLElement} element - The element to update
   * @param {boolean} isVisible - Whether the element should be visible
   */
  updateElementVisibility(element, isVisible) {
    element.classList.toggle(DISPLAY_CLASSES.HIDE, !isVisible);
    element.classList.toggle(DISPLAY_CLASSES.SHOW, isVisible);
  }

  /**
   * Applies all filters to the elements
   */
  applyFilters() {
    try {
      // Validate required elements
      if (!this.events?.length || !this.filters?.length) {
        throw new Error("Required elements not found");
      }

      // Convert filters to array for better performance in loops
      const activeFilters = Array.from(this.filters);

      this.events.forEach((element) => {
        // Use every() for better readability and performance
        const isVisible = activeFilters.every((filter) =>
          this.checkFilter(filter, element)
        );

        this.updateElementVisibility(element, isVisible);
      });
    } catch (error) {
      console.error("Error applying filters:", error.message);
      // Use a more professional error message
      this.showErrorMessage(
        "An error occurred while filtering events. Please contact support if the issue persists."
      );
    }
  }

  resetFilters() {
    this.filters.forEach((filter) => {
      filter.value = "all";
    });

    // Apply filters after reset
    this.applyFilters();
  }

  /**
   * Displays an error message to the user
   * @param {string} message - The error message to display
   */
  showErrorMessage(message) {
    // You can implement your preferred error handling here
    console.error(message);
    // Optional: Display error to user through UI
    // alert(message);
  }
}

// Initialize the filter system
const eventFilter = new EventFilter(
  ".agenda-event",
  ".jnd-filter",
  ".jnd-filter-reset"
);
const agendaEvents = document.getElementById("agenda-events");
