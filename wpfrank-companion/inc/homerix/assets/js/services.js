/**
 * Services Page JavaScript
 * 
 * Handles dynamic loading and rendering of services, areas, and why choose items
 */

document.addEventListener('DOMContentLoaded', function () {
  loadServices();
  loadServiceAreas();
  loadWhyChoose();
});

/**
 * Load services from AJAX
 */
function loadServices() {
  const formData = new FormData();
  formData.append('action', 'get_services');

  fetch(HomerixServices.ajaxUrl, {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        renderServices(data.data);
      }
    })
    .catch((error) => {
      console.error('Error loading services:', error);
    });
}

/**
 * Render services
 */
function renderServices(groupedServices) {
  const container = document.getElementById('services-container');
  if (!container) return;

  let html = '';

  for (const [key, service] of Object.entries(groupedServices)) {
    if (service.items.length === 0) continue;

    // Use semantic CSS classes for service icon colors
    const colorMap = {
      blue: 'service-icon-blue',
      yellow: 'service-icon-yellow',
      red: 'service-icon-red',
      green: 'service-icon-green',
    };

    const badgeColorMap = {
      blue: 'bg-primary',
      yellow: 'bg-warning',
      red: 'bg-danger',
      green: 'bg-success',
    };

    const colorClass = colorMap[service.color] || 'service-icon-blue';
    const badgeColor = badgeColorMap[service.color] || 'bg-primary';

    html += `
			<div class="mb-20" id="${key}">
				<div class="flex flex-col md:flex-row items-center mb-8">
					<div class="md:w-1/3 mb-6 md:mb-0">
						<div class="${colorClass} p-4 rounded-full inline-block">
							<i class="fas ${service.icon} text-4xl"></i>
						</div>
						<h3 class="text-2xl font-bold mt-4">${escapeHtml(service.name)} Services</h3>
					</div>
					<div class="md:w-2/3">
						<p class="text-lg text-body mb-6">Professional ${escapeHtml(service.name).toLowerCase()} services for all your home repair needs.</p>
						
						<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
		`;

    service.items.forEach((item) => {
      html += `
				<div class="service-card card-light p-6 rounded-lg relative">
					<div class="price-badge ${badgeColor} text-on-primary px-3 py-1 rounded-full text-sm font-bold">$99+</div>
					<h4 class="text-xl font-semibold mb-3">${escapeHtml(item.title)}</h4>
					<p class="text-body mb-4">${escapeHtml(item.excerpt)}</p>
					<ul class="text-sm text-body space-y-2 mb-4">
						<li class="flex items-start">
							<i class="fas fa-check icon-success mr-2 mt-1"></i>
							<span>Professional service</span>
						</li>
						<li class="flex items-start">
							<i class="fas fa-check icon-success mr-2 mt-1"></i>
							<span>Licensed technicians</span>
						</li>
						<li class="flex items-start">
							<i class="fas fa-check icon-success mr-2 mt-1"></i>
							<span>Satisfaction guaranteed</span>
						</li>
					</ul>
					<a href="#booking" class="link-primary font-medium inline-flex items-center">Book Now <i class="fas fa-arrow-right ml-2"></i></a>
				</div>
			`;
    });

    html += `
						</div>
					</div>
				</div>
			</div>
		`;
  }

  container.innerHTML = html;
}

/**
 * Load service areas from AJAX
 */
function loadServiceAreas() {
  const formData = new FormData();
  formData.append('action', 'get_service_areas');

  fetch(HomerixServices.ajaxUrl, {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        renderServiceAreas(data.data);
      }
    })
    .catch((error) => {
      console.error('Error loading service areas:', error);
    });
}

/**
 * Render service areas
 */
function renderServiceAreas(areas) {
  const container = document.getElementById('service-areas-container');
  if (!container) return;

  let html = '';

  areas.forEach((area) => {
    html += `
			<div class="card-light p-6 rounded-lg">
				<h3 class="text-xl font-semibold mb-4 text-center">${escapeHtml(area.title)}</h3>
				<ul class="space-y-2 text-center">
		`;

    area.locations.forEach((location) => {
      html += `<li>${escapeHtml(location)}</li>`;
    });

    html += `
				</ul>
			</div>
		`;
  });

  container.innerHTML = html;
}

/**
 * Load why choose items from AJAX
 */
function loadWhyChoose() {
  const formData = new FormData();
  formData.append('action', 'get_why_choose');

  fetch(HomerixServices.ajaxUrl, {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        renderWhyChoose(data.data);
      }
    })
    .catch((error) => {
      console.error('Error loading why choose items:', error);
    });
}

/**
 * Render why choose items
 */
function renderWhyChoose(items) {
  const container = document.getElementById('why-choose-container');
  if (!container) return;

  // Use semantic CSS classes for icon colors
  const colorMap = {
    blue: 'service-icon-blue',
    yellow: 'service-icon-yellow',
    red: 'service-icon-red',
    green: 'service-icon-green',
  };

  let html = '';

  items.forEach((item) => {
    const colorClass = colorMap[item.color] || 'service-icon-blue';

    html += `
			<div class="card-base p-6 rounded-lg shadow-sm text-center">
				<div class="${colorClass} p-4 rounded-full inline-block mb-4">
					<i class="fas ${item.icon} text-3xl"></i>
				</div>
				<h3 class="text-xl font-semibold mb-3">${escapeHtml(item.title)}</h3>
				<p class="text-body">${escapeHtml(item.description)}</p>
			</div>
		`;
  });

  container.innerHTML = html;
}

/**
 * Escape HTML special characters
 */
function escapeHtml(text) {
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
  };
  return text.replace(/[&<>"']/g, (m) => map[m]);
}

