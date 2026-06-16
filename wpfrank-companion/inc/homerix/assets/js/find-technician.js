/**
 * Find Technician Page JavaScript
 * Handles search, filtering, and pagination
 */

(function () {
  'use strict';

  // State management
  const state = {
    currentPage: 1,
    searchTerm: '',
    selectedService: '',
    selectedLocation: '',
    filteredTechnicians: [],
    allTechnicians: [],
    perPage: 9,
    services: [],
    locations: [],
  };

  /**
   * Get all technician cards from the DOM
   */
  function getAllTechnicians() {
    const cards = document.querySelectorAll('.technician-card');
    const technicians = [];

    cards.forEach((card) => {
      const name = card.querySelector('h3')?.textContent || '';
      const specialty = card.querySelector('.text-primary')?.textContent || '';
      const bio = card.querySelector('.text-body')?.textContent || '';

      // Extract service and location from data attributes or card content
      const service = card.dataset.service || '';
      const location = card.dataset.location || '';

      technicians.push({
        element: card,
        name: name.toLowerCase(),
        specialty: specialty.toLowerCase(),
        bio: bio.toLowerCase(),
        service: service.toLowerCase(),
        location: location.toLowerCase(),
      });
    });

    return technicians;
  }

  /**
   * Validate if a service value exists in the services repeater
   */
  function isValidService(serviceValue) {
    if (!serviceValue) {
      return true; // Empty value is always valid (means "all services")
    }
    return state.services.some((service) => service.value === serviceValue);
  }

  /**
   * Validate if a location value exists in the locations repeater
   */
  function isValidLocation(locationValue) {
    if (!locationValue) {
      return true; // Empty value is always valid (means "all locations")
    }
    return state.locations.some((location) => location.value === locationValue);
  }

  /**
   * Filter technicians based on search and filters
   */
  function filterTechnicians() {
    state.filteredTechnicians = state.allTechnicians.filter((tech) => {
      // Search filter
      const matchesSearch = state.searchTerm === '' ||
        tech.name.includes(state.searchTerm.toLowerCase()) ||
        tech.specialty.includes(state.searchTerm.toLowerCase()) ||
        tech.bio.includes(state.searchTerm.toLowerCase());

      // Service filter - validate against services repeater
      const matchesService = state.selectedService === '' ||
        (isValidService(tech.service) && tech.service === state.selectedService.toLowerCase());

      // Location filter - validate against locations repeater
      const matchesLocation = state.selectedLocation === '' ||
        (isValidLocation(tech.location) && tech.location === state.selectedLocation.toLowerCase());

      return matchesSearch && matchesService && matchesLocation;
    });

    // Debug logging
    if (state.selectedLocation !== '') {
      console.log('Location filter:', state.selectedLocation);
      console.log('Available locations:', state.locations);
      console.log('Filtered technicians:', state.filteredTechnicians.length);
    }

    // Reset to page 1 when filtering
    state.currentPage = 1;
    updateDisplay();
  }

  /**
   * Update the display based on current page and filters
   */
  function updateDisplay() {
    const start = (state.currentPage - 1) * state.perPage;
    const end = start + state.perPage;
    const visibleTechs = state.filteredTechnicians.slice(start, end);

    // Hide all cards
    state.allTechnicians.forEach((tech) => {
      tech.element.style.display = 'none';
    });

    // Show filtered cards for current page
    visibleTechs.forEach((tech) => {
      tech.element.style.display = 'block';
    });

    // Update pagination
    updatePagination();

    // Update technician count
    updateTechnicianCount();
  }

  /**
   * Update pagination controls
   */
  function updatePagination() {
    const totalPages = Math.ceil(state.filteredTechnicians.length / state.perPage);
    const pageNumbersContainer = document.getElementById('page-numbers');

    if (!pageNumbersContainer) {
      return;
    }

    pageNumbersContainer.innerHTML = '';

    // Generate page numbers
    const maxPagesToShow = 3;
    let startPage = Math.max(1, state.currentPage - 1);
    let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

    if (endPage - startPage < maxPagesToShow - 1) {
      startPage = Math.max(1, endPage - maxPagesToShow + 1);
    }

    // Previous button
    const prevBtn = document.querySelector('.prev-btn');
    if (prevBtn) {
      prevBtn.disabled = state.currentPage === 1;
      prevBtn.dataset.page = state.currentPage - 1;
    }

    // Page number buttons
    for (let i = startPage; i <= endPage; i++) {
      const btn = document.createElement('button');
      btn.className = 'pagination-btn px-4 py-1 rounded';
      btn.textContent = i;
      btn.dataset.page = i;

      if (i === state.currentPage) {
        btn.classList.add('active');
      }

      btn.addEventListener('click', (e) => {
        e.preventDefault();
        goToPage(i);
      });

      pageNumbersContainer.appendChild(btn);
    }

    // Ellipsis if needed
    if (endPage < totalPages) {
      const ellipsis = document.createElement('span');
      ellipsis.className = 'px-2 text-muted';
      ellipsis.textContent = '...';
      pageNumbersContainer.appendChild(ellipsis);

      // Last page button
      const lastBtn = document.createElement('button');
      lastBtn.className = 'pagination-btn px-4 py-1 rounded';
      lastBtn.textContent = totalPages;
      lastBtn.dataset.page = totalPages;
      lastBtn.addEventListener('click', (e) => {
        e.preventDefault();
        goToPage(totalPages);
      });
      pageNumbersContainer.appendChild(lastBtn);
    }

    // Next button
    const nextBtn = document.querySelector('.next-btn');
    if (nextBtn) {
      nextBtn.disabled = state.currentPage === totalPages;
      nextBtn.dataset.page = state.currentPage + 1;
    }
  }

  /**
   * Go to a specific page
   */
  function goToPage(page) {
    const totalPages = Math.ceil(state.filteredTechnicians.length / state.perPage);
    if (page >= 1 && page <= totalPages) {
      state.currentPage = page;
      updateDisplay();
      // Scroll to technician list
      const container = document.getElementById('technician-list');
      if (container) {
        container.scrollIntoView({ behavior: 'smooth' });
      }
    }
  }

  /**
   * Update technician count display
   */
  function updateTechnicianCount() {
    const countElement = document.querySelector('.technician-count');
    if (countElement) {
      countElement.textContent = state.filteredTechnicians.length;
    }
  }

  /**
   * Initialize event listeners
   */
  function initEventListeners() {
    // Search input
    const searchInput = document.getElementById('technician-search');
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        state.searchTerm = e.target.value;
        filterTechnicians();
      });
    }

    // Service filter
    const serviceFilter = document.getElementById('service-filter');
    if (serviceFilter) {
      serviceFilter.addEventListener('change', (e) => {
        state.selectedService = e.target.value;
        filterTechnicians();
      });
    }

    // Location filter
    const locationFilter = document.getElementById('location-filter');
    if (locationFilter) {
      locationFilter.addEventListener('change', (e) => {
        state.selectedLocation = e.target.value;
        filterTechnicians();
      });
    }

    // Pagination buttons
    document.addEventListener('click', (e) => {
      if (e.target.classList.contains('pagination-btn')) {
        e.preventDefault();
        const page = parseInt(e.target.dataset.page, 10);
        if (!isNaN(page)) {
          goToPage(page);
        }
      }
    });
  }

  /**
   * Load services and locations from data attributes
   */
  function loadServicesAndLocations() {
    const container = document.getElementById('technicians-container');
    if (!container) {
      return;
    }

    // Load services from data attribute.
    const servicesData = container.dataset.services;
    if (servicesData) {
      try {
        state.services = JSON.parse(servicesData);
      } catch (e) {
        console.error('Failed to parse services data:', e);
        state.services = [];
      }
    }

    // Load locations from data attribute.
    const locationsData = container.dataset.locations;
    if (locationsData) {
      try {
        state.locations = JSON.parse(locationsData);
      } catch (e) {
        console.error('Failed to parse locations data:', e);
        state.locations = [];
      }
    }

    console.log('Loaded services:', state.services);
    console.log('Loaded locations:', state.locations);
  }

  /**
   * Initialize the page
   */
  function init() {
    loadServicesAndLocations();
    state.allTechnicians = getAllTechnicians();
    state.filteredTechnicians = [...state.allTechnicians];

    initEventListeners();
    updateDisplay();

    console.log('Find Technician page initialized with', state.allTechnicians.length, 'technicians');
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

