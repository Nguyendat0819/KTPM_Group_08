$(document).ready(function() {
    // Listen for changes in the "province" select box
    $('#province').on('change', function() {
      var province_id = $(this).val();
      if (province_id) {
        $.ajax({
          url: 'ajax_get_district.php', // Update this URL to your actual endpoint for fetching districts
          method: 'GET',
          dataType: "json",
          data: {
            province_id: province_id
          },
          success: function(data) {
            $('#district').empty();
            $('#district').append($('<option>', { value: '', text: 'Chọn quận/huyện' }));
            $.each(data, function(i, district) {
              $('#district').append($('<option>', {
                value: district.id,
                text: district.name
              }));
            });
            $('#wards').empty();
            $('#wards').append($('<option>', { value: '', text: 'Chọn phường/xã' }));
          },
          error: function(xhr, textStatus, errorThrown) {
            console.log('Error: ' + errorThrown);
          }
        });
      } else {
        $('#district').empty();
        $('#district').append($('<option>', { value: '', text: 'Chọn quận/huyện' }));
        $('#wards').empty();
        $('#wards').append($('<option>', { value: '', text: 'Chọn phường/xã' }));
      }
    });
    
    // Listen for changes in the "district" select box
    $('#district').on('change', function() {
      var district_id = $(this).val();
      if (district_id) {
        // If a district is selected, fetch the wards for that district using AJAX
        $.ajax({
          url: 'ajax_get_wards.php',
          method: 'GET',
          dataType: "json",
          data: {
            district_id: district_id
          },
          success: function(data) {
            $('#wards').empty();
            $('#wards').append($('<option>', { value: '', text: 'Chọn phường/xã' }));
            $.each(data, function(i, ward) {
              $('#wards').append($('<option>', {
                value: ward.id,
                text: ward.name
              }));
            });
          }, 
          error: function(xhr, textStatus, errorThrown) {
            console.log('Error: ' + errorThrown);
          }
        });
      } else {
        // If no district is selected, reset the "wards" select box
        $('#wards').empty();
        $('#wards').append($('<option>', { value: '', text: 'Chọn phường/xã' }));
      }
    });
  });
  