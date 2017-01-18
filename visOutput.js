$("#start").submit(function(){
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: 'post',
            url: '',
            data: data,
        //    beforeSend: function(data) {
         //       form.find('input[type="submit"]').attr('disabled', 'disabled');
         //   },
            complete: function(data) {
                //form.find('input[type="submit"]').prop('disabled', false);

            }

        });
        return false;
    });
