$(document).ready(function() {
  // Show the popup
  $('#popup').fadeIn();

  // Close the popup when the close button is clicked
  $('.close-btn').on('click', function() {
      $('#popup').fadeOut();
  });

  // Close the popup when clicking outside the popup content
  $('#popup').on('click', function(event) {
      if (!$(event.target).closest('.popup-content').length) {
          $('#popup').fadeOut();
      }
  });
});