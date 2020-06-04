function maxLengthCheck(object) {
  if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength)
}

function message() {
  $('#message').fadeOut();  
};

$(function() {
  $('.digit').click(function() {
    console.log($(this).text());
    switch ($(this).text()) {
      case "X":
        value = $('#focusJs').val();
        value = value.slice(0,-1);
        $('#focusJs').val(value);
        console.log($(this).text(), typeof(value));
      break;
      case "Ga":
        console.log($(this).text());
        $( "#playform" ).submit();
      break;
      default:
        value = $('#focusJs').val();
        value += $(this).text();
        $('#focusJs').val(value);
    }
  });

});
