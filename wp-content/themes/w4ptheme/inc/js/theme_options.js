// Remap jQuery to $.
(function ($) {

  // Re-index profiles.
  function RefreshProfilesIndex(selector) {
    $(document).find("[id^=social_profile_" + selector + "]").each(function( index ) {
      $(this).attr('id', 'social_profile_' + selector + '_' + (index + 1) );
      $(this).closest('div').find('label').attr('for', 'social_profile_' + selector + '_' + (index + 1) );
    });
  }

  // Capitalize first letter on string.
  function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
  }

  // Update Events.
  function RefreshEventListener() {
    // Remove handler from existing elements
    $( "button.w4p-social-remove" ).off();

    // Re-add event handler for all matching elements
    $( "button.w4p-social-remove" ).on( "click", function(event) {
      event.preventDefault();

      var selected = $( event.target ).parent('div').find('input').attr('class');

      $( event.target ).parents('div.w4p-social-profile').css('visibility', 'hidden').slideUp("normal", function() {
        $(this).remove();
        RefreshProfilesIndex(selected);
      });
    });
  }

  // Select options toggle refresh.
  function RefreshSelectOptions(target_id) {
    if (target_id === undefined) {
      var $target = $(document).find("select.select-toggle option");
    } else {
      var $target = $(document).find("#"+target_id).closest("form").find("select.select-toggle option");
    }
    $target.on("mousedown", function () {
      var $self = $(this);

      if ($self.prop("selected"))
        $self.prop("selected", false);
      else
        $self.prop("selected", true);

      return false;
    });
  }

  /* trigger when page is ready */
  $(document).ready(function () {

    RefreshEventListener();

    $( "#social_profile_add" ).on( "click", function(event) {
      event.preventDefault();

      var selected = $( "#social_profile_selector" ).val();
      var count = parseInt($(document).find("[id^=w4p_social_profiles_" + selected + "]").length);
      var $clone =  $(document).find( ".w4p-social-profile" ).first().clone();
      if ($clone.length == 0) {
        $clone = $('<div>').addClass("w4p-social-profile");
        $clone.html(
        '<label for="w4p_social_profiles_' + selected + '_1" class="w4p-option-label">' + toTitleCase(selected) + ':</label>' +
        '<input type="text" id="w4p_social_profiles_' + selected + '_1" name="w4p_social_profiles[' + selected + '][]" class="' + selected + '" value="" placeholder="http://"/>' +
        '<button class="button w4p-social-remove"><b>-</b></button>');
        $clone.insertBefore( $(document).find( ".w4p-social-profile-selector-wrapper").prev() ).hide().css({ visibility: 'hidden' }).slideDown("normal", function() {
          $(this).css('visibility', 'visible');
        });
      } else {
        $clone.find("label").attr('for', 'w4p_social_profiles_' + selected + '_' + (count + 1));
        $clone.find("label").text(toTitleCase(selected) + ':');
        $clone.find("input").attr('id', 'w4p_social_profiles_' + selected + '_' + (count + 1));
        $clone.find("input").attr('class', selected);
        $clone.find("input").attr('name', 'w4p_social_profiles[' + selected + '][]');
        $clone.find("input").val('');
        $clone.insertAfter( $(document).find( ".w4p-social-profile" ).last() ).hide().css({ visibility: 'hidden' }).slideDown("normal", function() {
          $(this).css('visibility', 'visible');
        });
      }
      RefreshEventListener();
    });

    RefreshSelectOptions();
  });


  $(".widget-control-save").on( "click", function(event) {
    setTimeout(function(){
      RefreshSelectOptions(event.target.id)
    }, 500);
  });

}(window.jQuery || window.$));
