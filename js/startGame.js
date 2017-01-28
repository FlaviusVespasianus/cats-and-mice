$(document).ready(function () {

    $('#submit').hide();
    $('input').change(function(e) {
        if ($('#x1').val() && $('#x2').val() && $('#turns').val() && $('#cats').val() && $('#mice').val() && $('#dogs').val()) {
            $('#submit').fadeIn();
        } else {
            $('#submit').fadeOut();
        }
    });
    // var r,o;
    // o = 0;
    // $("#start").on('click', function() {
    //     $.ajax({
    //         // type: 'get',
    //         url: 'test.php',
    //         // data: data,
    //         complete: function(data) {
    //             r = data.responseText.split('+++');
    //             console.log(r);
    //
    //
    //         }
    //
    //     });
    // });
    // function success(o) {
    //     if (o > 50) return;
    //     $('#output').html('').append(r[o]);
    //
    //     setTimeout(function() {
    //         success(o+1);
    //     }, 650);
    // }
    //
    //
    // $("#start2").on('click', function() {
    //     // for (; o < r.length; o++) {
    //     success(0);
    //
    // });

});

// function validate() {
//     if ($('#x1').val().length   >   0   &&
//         $('#x2').val().length  >   0   &&
//         $('#turns').val().length    >   0) {
//         $("#submit").prop();
//     }
//     else {
//         $("#submit").invisible();
//     }
// }

// jQuery.fn.visible = function() {
//     return this.css('visibility', 'visible');
// };
//
// jQuery.fn.invisible = function() {
//     return this.css('visibility', 'hidden');
// };

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
