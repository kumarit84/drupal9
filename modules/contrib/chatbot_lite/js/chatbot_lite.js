(function ($, Drupal) {

  Drupal.behaviors.chatbot_lite = {
    attach: function (context, settings) {
      $(".chatbot-lite-close").once().on("click", function () {
        $('.chatbot-lite-window').hide('slow');
        $(".chatbot-lite-open").show('slow');
      });
      $(".chatbot-lite-open").once().on("click", function () {
        $('.chatbot-lite-window').show('slow');
        $(this).hide();
      });

      $(document).ajaxStart(function () {
        $('#edit-chatbot-lite-input').attr("disabled", "disabled");
        $('#edit-chatbot-lite-button').attr("disabled", "disabled");
      });
      $(document).ajaxSuccess(function () {
        $('#edit-chatbot-lite-input').removeAttr("disabled");
        $('#edit-chatbot-lite-button').removeAttr("disabled");
        $("#edit-chatbot-lite-body").each(function () {
          $(this).scrollTop($(this)[0].scrollHeight);
        });
      });
    }
  };
})(jQuery, Drupal);
