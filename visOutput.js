$(document).ready(function () {
    var r,o;
    o = 0;
    $("#start").on('click', function() {
        $.ajax({
            // type: 'post',
            url: 'test.php',
            // data: data,
            complete: function(data) {
                r = data.responseText.split('+++');
                console.log(r);


            }

        });
    });
    function success(o) {
        if (o > 50) return;
        $('#output').html('').append(r[o]);

        setTimeout(function() {
            success(o+1);
        }, 650);
    }


    $("#start2").on('click', function() {
        // for (; o < r.length; o++) {
        success(0);

    });

});




// $("#start").submit(function(){
//         var form = $(this);
//         var data = form.serialize();
//         $.ajax({
//             type: 'post',
//             url: '',
//             data: data,
//         //    beforeSend: function(data) {
//          //       form.find('input[type="submit"]').attr('disabled', 'disabled');
//          //   },
//             complete: function(data) {
//                 //form.find('input[type="submit"]').prop('disabled', false);
//
//             }
//
//         });
//         return false;
//     });
