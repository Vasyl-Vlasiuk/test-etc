jQuery(document).ready(function($) {
  let currentPage = 1;
  const resultsContainer = $('#property-results');
  const loadMoreButton = $('#load-more');

  function loadProperties(page = 1) {
      const formData = $('.real-estate-filter').serialize();

      $.ajax({
        url: realEstateAjax.ajax_url,
        type: 'GET',
        data: {
          action: 'search_estates',
          page: page,
          formData: formData
        },
        success: function(response) {
          if (response.success) {
            if (page === 1) {
              resultsContainer.html(response.data.html);
            } else {
              resultsContainer.append(response.data.html);
            }

            if (page < response.data.total_pages) {
              loadMoreButton.show();
            } else {
              loadMoreButton.hide();
            }
          } else {
            resultsContainer.html('<p>' + response.data + '</p>');
          }
        },
        error: function() {
            resultsContainer.html('<p>Error occurred while searching.</p>');
        }
      });
  }

  // Initial load
  loadProperties();

  // On form submit
  $('.real-estate-filter').on('submit', function(e) {
    e.preventDefault();
    currentPage = 1; // Reset to the first page
    loadProperties(currentPage);
  });

  // Load more button click
  loadMoreButton.on('click', function() {
    currentPage++;
    loadProperties(currentPage);
  });
});
