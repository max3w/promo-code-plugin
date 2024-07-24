jQuery(document).ready(function($) {
    var timerElement = $('.elementor-jet-countdown-timer .jet-countdown-timer');
    var dueDate = parseInt(timerElement.data('due-date'));

    console.log(dueDate);
    var currentTime = Math.floor(Date.now() / 1000);
    console.log(currentTime);
    var remainingTime = dueDate - currentTime;
    console.log(remainingTime);

    var timer = setInterval(function() {
        if (remainingTime <= 0) {
            clearInterval(timer);
            $.ajax({
                url: csp_ajax.ajax_url,
                method: 'POST',
                data: {
                    action: 'get_promo_text'
                },
                success: function(response) {
                    if (response.success) {
                        $('.elementor-heading-title.elementor-size-default').text(response.data);
                    }
                }
            });
        } else {
            remainingTime--;
        }
    }, 1000);

    // Copy to clipboard functionality
    $('.copytext').on('click', function() {
        var textToCopy = $('.elementor-heading-title.elementor-size-default').text();
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(textToCopy).select();
        document.execCommand('copy');
        tempInput.remove();
        $(this).addClass('copied');
        alert('Promo code copied! ' + textToCopy);
    });
});
